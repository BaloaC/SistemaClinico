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
        "cita.estatus_cit"
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

        $_POST = json_decode(file_get_contents('php://input'), true);
        CitasValidaciones::validacionesGenerales($_POST);
        CitasValidaciones::validarDisponibilidad($_POST);
        CitasValidaciones::validarHorario($_POST);
        CitasValidaciones::validarFecha($_POST);

        $validarCita = new Validate;

        $data = $validarCita->dataScape($_POST);

        // verificaciones si la cita es asegurada
        if ($data['tipo_cita'] == 2) {

            // verificamos que pueda solicitar cita asegurada
            /*** Estas líneas fueron comentadas porque aparentemente no hacían nada ***/
            // $siEsTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '3', 'paciente');
            // $siEsBeneficiario = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '4', 'paciente');
            // $siSeguroAsociado = $validarCita->isDuplicatedId('paciente_id', 'seguro_id', $_POST['paciente_titular_id'], $_POST['seguro_id'], 'paciente_seguro');

            // if (!$siEsTitular && !$siEsBeneficiario) {
            //     $respuesta = new Response(false, 'El paciente ingresado no está registrado como asegurado');
            //     return $respuesta->json(400);
            // }

            // if (!$siSeguroAsociado) {
            //     $respuesta = new Response(false, 'Ese seguro no se encuentra asociado con el paciente indicado');
            //     return $respuesta->json(400);
            // }
            /*** Estas líneas fueron comentadas porque aparentemente no hacían nada ***/

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
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('estatus_cit', '!=', '2')->innerJoin($this->arraySelect, $inners, "cita");

        $lista_citas = [];
        foreach ($lista as $cita) {

            if ($cita->tipo_cita == 2) {
                $lista_citas[] = CitasHelpers::innerCita($cita);
            } else {
                $lista_citas[] = $cita;
            }
        }

        Helpers::retornarMensajeListado($lista_citas);
    }

    public function listarCitaPorId($cita_id) {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('cita_id', '=', $cita_id)->where('estatus_cit', '!=', '2')->innerJoin($this->arraySelect, $inners, "cita");
        
        if ($lista) {
            $lista_citas = "";
            
            if ($lista[0]->tipo_cita == 2) {
                $lista_citas = CitasHelpers::innerCita($lista[0]);
                // var_dump($lista_citas);
            } else {
                $lista_citas = $lista[0];
            }

            Helpers::retornarMensajeListado($lista_citas);
        }

        return Helpers::retornarMensajeListado(false, false);
    }

    public function listarCitaPorPacienteId($paciente_id) {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('estatus_cit', '!=', '2')->where('cita.paciente_id', '=', $paciente_id)->innerJoin($this->arraySelect, $inners, "cita");
        var_dump($lista);
        if ( count($lista) > 0 && $lista[0]->tipo_cita == 2) {
            $lista_citas = CitasHelpers::innerCita($lista[0]);
            Helpers::retornarMensajeListado($lista_citas);
        } else {

            $respuesta = new Response(false, 'El paciente indicado todavía no posee citas');
            return $respuesta->json(400);
        }
    }

    public function actualizarCita($cita_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarCita = new Validate;

        CitasValidaciones::validarActualizacion($_POST, $cita_id);
        CitasValidaciones::validarCitaId($cita_id);

        $data = $validarCita->dataScape($_POST);
        $newStatus['estatus_cit'] = 1;
        $newArray['clave'] = $data['clave'];

        $_citaSeguroModel = new CitaSeguroModel();
        $actualizado = $_citaSeguroModel->where('cita_id', '=', $cita_id)->update($newArray);
        $esActualizado = "";
        
        if ($actualizado > 0) {
            $_cita = new CitaModel();
            $esActualizado = $_cita->where('cita_id', '=', $cita_id)->update($newStatus);
        }

        $mensaje = ($esActualizado > 0);

        Helpers::retornarMensajeActualizacion($mensaje, $actualizado);
    }

    public function reprogramarCita($cita_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        CitasValidaciones::validarCitaId($cita_id);
        CitasValidaciones::validarFecha($_POST);

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