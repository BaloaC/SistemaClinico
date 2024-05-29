<?php

include_once './services/citas/CitasValidaciones.php';
include_once './services/citas/CitasHelpers.php';
include_once './services/Helpers.php';

class CitaController extends Controller {

    protected $arraySelect = array(
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellido_medico",
        "especialidad.nombre AS nombre_especialidad",
        "cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.fecha_cita",
        "cita.hora_entrada",
        "cita.hora_salida",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.tipo_cita",
        "cita.tipo_servicio",
        "cita.estatus_cit",
        "cita.monto_aprobado"
    );

    protected $arrayInner = array(
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita",
    );

    protected $seguroSelect = array(
        "cita_seguro.seguro_id",
        "seguro.nombre AS nombre_seguro",
        "cita_seguro.clave"
    );

    protected $seguroInner = array(
        "seguro" => "cita_seguro"
    );

    //Método index (vista principal)
    public function index() {

        return $this->view('citas/index');
    }

    public function formRegistrarCitas() {
        return $this->view('citas/registrarCitas');
    }

    public function formActualizarCita($cita_id) {
        return $this->view('citas/actualizarCitas', ['cita_id' => $cita_id]);
    }

    public function insertarCita(/*Request $request*/) {
        global $isEnabledAudit;
        $isEnabledAudit = 'citas';

        $_POST = json_decode(file_get_contents('php://input'), true);
        CitasValidaciones::validacionesGenerales($_POST);
        CitasValidaciones::validarDisponibilidad($_POST);
        CitasValidaciones::validarHorario($_POST);
        CitasValidaciones::validarFecha($_POST);

        if (array_key_exists('examenes', $_POST)) {
            CitasValidaciones::validarCitaExamen($_POST['examenes']);

            if ($_POST['tipo_cita'] == 2 && $_POST['tipo_servicio'] == 1) {
                CitasValidaciones::validarExamenesCitaAsegurada($_POST);
            }
        }

        $validarCita = new Validate;

        $data = $validarCita->dataScape($_POST);

        // verificaciones si la cita es asegurada
        if ($data['tipo_cita'] == 2) {

            // verificamos que el titular pueda ser titular
            $esTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], 3, 'paciente');
            if (!$esTitular) {
                $respuesta = new Response(false, 'La cédula no pertenece a ningún titular de seguro');
                return $respuesta->json(400);
            }

            // Verificamos que el titular este asociado a ese seguro
            $esSeguroAsociado = $validarCita->isDuplicatedId('paciente_id', 'seguro_id', $data['paciente_titular_id'], $data['seguro_id'], 'paciente_seguro');
            if (!$esSeguroAsociado) {
                $respuesta = new Response(false, 'El paciente indicado no se encuentra asociado a ese seguro');
                return $respuesta->json(400);
            }

            $_pacienteModel = new PacienteBeneficiadoModel();
            $pacienteBeneficiaro = $_pacienteModel->where('paciente_id', '=', $data['paciente_id'])->getFirst();
            
            // Validamos que sea beneficiado
            if ($data['paciente_id'] != $data['paciente_titular_id']) {
                if ( !$pacienteBeneficiaro ) {
                    $respuesta = new Response(false, 'El paciente indicado no es beneficiario de un seguro');
                    return $respuesta->json(400);
                } else {
                    // validamos que esté asociado a ese titular
                    if ( !$validarCita->isDuplicatedId('paciente_id', 'paciente_beneficiado_id', $data['paciente_titular_id'], $pacienteBeneficiaro->paciente_beneficiado_id, 'titular_beneficiado') ) {
                        $respuesta = new Response(false, 'El paciente indicado no tiene relación con ese titular, por favor verifique nuevamente');
                        return $respuesta->json(400);
                    }
                }
            }

            // Asignamos el estatus dependiendo del contenido del campo clave
            if (array_key_exists("clave", $data)) {

                $verClave = empty($data['clave']);
                $data['estatus_cit'] = ($verClave ? 3 : 1);
            } else {
                $data['estatus_cit'] = 3;
            }

        } else {

            $_citaModel = new CitaModel();
            $id = $_citaModel->where('cedula_titular', '=', $_POST['cedula_titular'])->getFirst();
            $data['estatus_cit'] = 1;
        }

        $_citaModel = new CitaModel();
        $id = $_citaModel->insert($data);
        $mensaje = ($id > 0);

        if ($mensaje && array_key_exists('examenes', $_POST)) {
            CitasHelpers::insertarCitaExamen($data, $id);
        }

        // Insertamos cita_seguro si es asegurada
        if ($mensaje && $data['tipo_cita'] == 2) {
            $_citaSeguroModel = new CitaSeguroModel();

            $citaSeguro = [
                "cita_id" => $id,
                "seguro_id" => $data["seguro_id"],
            ];

            if ( !empty($data['clave']) ) { $citaSeguro['clave'] = $data["clave"]; }

            $isInserted = $_citaSeguroModel->insert($citaSeguro);

            if (!$isInserted) {
                $_citaModel = new CitaModel();
                $_citaModel->where('cita_id', '=', $id)->delete();

                $mensaje = new Response('INSERCION_FALLIDA');
                $mensaje->setData('Ocurrió un error insertando la información relacionada al seguro');
                return $mensaje->json(400);
            } else {
                $mensaje = new Response('INSERCION_EXITOSA');
                return $mensaje->json(201);
            }

        } else if (!$mensaje && $data['tipo_cita'] == 2) {
            $mensaje = new Response('INSERCION_FALLIDA');
            return $mensaje->json(400);

        } else if ($data['tipo_cita'] == 1) { // Si es cita natural no aplicamos ninguna inserción extra
            $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
            return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarCitas() {

        $_citaModel = new CitaModel();

        if (isset($_GET['estatus'])) {
            $_citaModel->where('estatus_cit', '=', $_GET['estatus']);
        } else {
            $_citaModel->where('estatus_cit', '!=', 2);
        }

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                
                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_citaModel->limit([$primer_registro, $size]);
            }
            
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_citaModel->where('CONCAT(motivo_cita)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_citaModel->where('CONCAT(motivo_cita)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $lista = $_citaModel->getAll();

        $especialidades =  $_citaModel->getAll();
        $_citaModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_citaModel->setSelect('COUNT(*) AS total')->where('CONCAT(motivo_cita)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_citaModel->setSelect('COUNT(*) AS total')->where('CONCAT(motivo_cita)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_citaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_citaModel->setSelect('COUNT(*) AS total');
        }

        if (isset($_GET['estatus'])) {
            $_citaModel->where('estatus_cit', '=', $_GET['estatus']);
        } else {
            $_citaModel->where('estatus_cit', '!=', 2);
        }

        $total_registros = $_citaModel->getAll();
                
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $especialidades);
        // Helpers::retornarMensajeListado($lista);
    }

    public function listarCitaPorId($cita_id) {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('cita_id', '=', $cita_id)
                            ->where('estatus_cit', '!=', '2')
                            ->innerJoin($this->arraySelect, $inners, "cita");
        
        $_medicoEspecialidadModel = new MedicoEspecialidadModel();
        $medico_especialidad = $_medicoEspecialidadModel->where('medico_id', '=', $lista[0]->medico_id)
                                                        ->where('especialidad_id', '=', $lista[0]->especialidad_id)
                                                        ->where('estatus_med', '=', 1)->getFirst();
        $lista[0]->costo_especialidad = $medico_especialidad->costo_especialidad;
        if ($lista) {
            $lista_citas = "";
            
            if ($lista[0]->tipo_cita == 2) {
                $lista_citas = CitasHelpers::innerCita($lista[0]);
                $lista_citas->examenes = CitasHelpers::obtenerExamenes($cita_id);
                
            } else {
                $lista_citas = $lista[0];
                $lista_citas->examenes = CitasHelpers::obtenerExamenes($cita_id);
            }

            Helpers::retornarMensajeListado($lista_citas);
        }

        return Helpers::retornarMensajeListado(false, false);
    }

    public function listarCitaPorPacienteId($paciente_id) {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('estatus_cit', '!=', '2')->where('cita.paciente_id', '=', $paciente_id)->innerJoin($this->arraySelect, $inners, "cita");
        
        if ( count($lista) > 0 ) {
            $lista_citas = [];
            foreach ($lista as $cita) {
                $lista_citas[] = CitasHelpers::innerCita($cita);
            }
            Helpers::retornarMensajeListado($lista_citas);
        } else {

            $respuesta = new Response(false, 'El paciente indicado todavía no posee citas');
            return $respuesta->json(400);
        }
    }

    public function listarCitasPorFecha() {
        CitasValidaciones::validarCitasPorFecha($_GET);
        $_citaModel = new CitaModel();
        $citas = $_citaModel->where('fecha_cita', '=', $_GET['fecha'])
                            ->where('medico_id', '=', $_GET['medico'])
                            ->getAll();

        $response = new Response('CORRECTO');
        $response->setData($citas);
        return $response->json(200);
    }

    public function actualizarCita($cita_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'citas';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarCita = new Validate;
        CitasValidaciones::validarActualizacion($_POST, $cita_id);
        CitasValidaciones::validarCitaId($cita_id);

        $data = $validarCita->dataScape($_POST);
        $newArray['clave'] = $data['clave'];

        $cita_actualizada = Array(
            'monto_aprobado' => $data['monto_aprobado'],
            'estatus_cit' => 1
        );

        $_citaSeguroModel = new CitaSeguroModel();
        $cita = $_citaSeguroModel->where('cita_id', '=', $cita_id)->getFirst();

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro_id', '=', $cita->seguro_id)->getFirst();

        $hoy = new DateTime('now');
        $hoy->modify('+'.$seguro->maximo_dias.' days');        

        if (date('Y-m-d') > $hoy->format('Y-m-d')) {
            $respuesta = new Response(false, 'Esta cita ya no puede ser actualizada, cree una cita nueva');
            echo $respuesta->json(400);
            exit();
        }

        $_citaSeguroModel = new CitaSeguroModel();
        $actualizado = $_citaSeguroModel->where('cita_id', '=', $cita_id)->update($newArray);
        $esActualizado = "";
        
        if ($actualizado > 0) {
            $_cita = new CitaModel();
            $esActualizado = $_cita->where('cita_id', '=', $cita_id)->update($cita_actualizada);

            if (array_key_exists('cita_examenes', $_POST)) {
                CitasHelpers::actualizarExamenCita($_POST['cita_examenes']);
            }
        }

        if ($esActualizado > 0) {
            
        }
        $mensaje = ($esActualizado > 0);
        Helpers::retornarMensajeActualizacion($mensaje, $actualizado);
    }

    public function reprogramarCita($cita_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'citas';

        $_POST = json_decode(file_get_contents('php://input'), true);
        CitasValidaciones::validarCitaId($cita_id);
        CitasValidaciones::validarFecha($_POST);
        CitasValidaciones::validarDisponibilidadReprogramacion($_POST);

        $_citaModel = new CitaModel();
        $cita = $_citaModel->where('cita_id', '=', $cita_id)->getFirst();

        CitasValidaciones::validarReprogramacion($cita);

        // Le actualizamos el estatus a la cita original
        $newEstatus = array( "estatus_cit" => "5" );

        $actualizado = $_citaModel->update($newEstatus);
        $isUpdate = ($actualizado > 0);

        if (!$isUpdate) {
            $respuesta = new Response(false, 'Ha ocurrido un error actualizando la cita actual');
            return $respuesta->json(400);
        }

        // Comenzamos a insertar la cita nueva
        $cita->fecha_cita = $_POST['fecha_cita'];
        $cita->hora_entrada = $_POST['hora_entrada'];
        $cita->hora_salida = $_POST['hora_salida'];
        $newCita = get_object_vars( $cita ); // (Volvemos nuestro objeto un array)
        unset($newCita['cita_id']);
        unset($newCita['estatus_cit']);
        unset($newCita['clave']);
        
        $_cita = new CitaModel();
        $id = $_cita->insert($newCita);
        $isInserted = ($id > 0);

        $isInserted = new Response($isInserted, $isInserted ? 'Cita reprogramada exitosamente' : 'Ocurrió un error reprogramando la cita');
        return $isInserted->json($isInserted ? 201 : 400);
    }

    public function eliminarCita($cita_id) {

        $_citaModel = new CitaModel();
        $data = array(
            "estatus_cita" => "2"
        );

        $eliminado = $_citaModel->where('cita_id', '=', $cita_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}