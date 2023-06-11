<?php

class CitaController extends Controller {

    protected $arraySelect = array(
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellido_medico",
        "especialidad.nombre AS nombre_especialidad",
        "seguro.nombre AS nombre_seguro",
        "cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.seguro_id",
        "cita.fecha_cita",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.clave",
        "cita.tipo_cita",
        "cita.estatus_cit"
    );

    protected $arrayInner = array(
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita",
        "seguro" => "cita"
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

        // Creando los strings para las validaciones
        $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "cedula_titular", "tipo_cita", "medico_id");
        $camposString = array("motivo_cita");
        $campoId = array("paciente_id", "medico_id", "especialidad_id", "cita_id");
        $exclude = array("seguro_id");

        $validarCita = new Validate;

        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch ($_POST) {

            case ($validarCita->isEmpty($_POST, $exclude)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            // case !$validarCita->existsInDB($_POST, $campoId):
            //     $respuesta = new Response('NOT_FOUND');
            //     return $respuesta->json(404);

            case $validarCita->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarCita->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarCita->existsInDB($_POST, $campoId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case !$validarCita->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $_POST['medico_id'], 'medico_especialidad'):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarCita->isDate($_POST['fecha_cita']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarCita->isDate($_POST['hora_entrada'], "H:i"):
                $respuesta = new Response('HORA_INVALIDA');
                $respuesta->setData('Error en la hora de entrada '.$_POST['hora_entrada']);
                return $respuesta->json(400);

            case $validarCita->isDate($_POST['hora_salida'], 'H:i'):
                $respuesta = new Response('HORA_INVALIDA');
                $respuesta->setData('Error en la hora de entrada '.$_POST['hora_salida']);
                return $respuesta->json(400);

            case $validarCita->isToday($_POST['fecha_cita'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case !$validarCita->isDuplicated('paciente', "cedula", $_POST['cedula_titular']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $_POST['hora_entrada'] >= $_POST['hora_salida']:
                $respuesta = new Response(false, 'La hora de salida debe ser posteior de la hora de entrada');
                return $respuesta->json(400);

            default:

                // Validamos que no haya otra cita a esa hora
                $_citasDelDía = new CitaModel();
                $isDuplicated = $_citasDelDía->where('fecha_cita', '=', $_POST['fecha_cita'])->where('hora_entrada', '>=', $_POST['hora_entrada'])->where('hora_entrada', '<=', $_POST['hora_salida'])
                        ->orWhere('fecha_cita', '=', $_POST['fecha_cita'])->where('hora_entrada', '<=', $_POST['hora_entrada'])->where('hora_salida', '>=', $_POST['hora_salida'])
                        ->orWhere('fecha_cita', '=', $_POST['fecha_cita'])->where('hora_entrada', '<=', $_POST['hora_entrada'])->where('hora_salida', '>=', $_POST['hora_entrada'])
                        ->orWhere('fecha_cita', '=', $_POST['fecha_cita'])->where('hora_entrada', '>=', $_POST['hora_entrada'])->where('hora_salida', '<=', $_POST['hora_entrada'])
                        ->getAll();
                
                if ( count($isDuplicated) > 0 ) {
                    $respuesta = new Response('DUPLICATE_APPOINTMENT');
                    return $respuesta->json(400);
                }

                $data = $validarCita->dataScape($_POST);

                // verificaciones si la cita es asegurada
                if ($data['tipo_cita'] == 2) {

                    // verificamos que pueda solicitar cita asegurada
                    $siEsTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '3', 'paciente');
                    $siEsBeneficiario = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '4', 'paciente');
                    $siSeguroAsociado = $validarCita->isDuplicatedId('paciente_id', 'seguro_id', $_POST['paciente_titular_id'], $_POST['seguro_id'], 'paciente_seguro');

                    if (!$siSeguroAsociado) {
                        $respuesta = new Response(false, 'Ese seguro no se encuentra asociado con el paciente indicado');
                        return $respuesta->json(400);
                    }

                    if (!$siEsTitular && !$siEsBeneficiario) {
                        $respuesta = new Response(false, 'El paciente ingresado no está registrado como asegurado');
                        return $respuesta->json(400);
                    }

                    // verificamos que el titular pueda ser titular
                    $esTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], 3, 'paciente');
                    if (!$esTitular) {
                        $respuesta = new Response(false, 'La cédula no pertenece a ningún titular de seguro');
                        return $respuesta->json(404);
                    }

                    // Asignamos el estatus dependiendo del contenido del campo clave
                    if (array_key_exists("clave", $data)) {

                        $verClave = empty($data['clave']);
                        $data['clave'] = ($verClave ? 3 : 1);
                    } else {
                        $data['estatus_cit'] = 3;
                    }
                } else {

                    $_citaModel = new CitaModel();
                    $id = $_citaModel->where('cedula_titular', '=', $_POST['cedula_titular'])->getFirst();
                    $data['estatus_cit'] = 1;
                }

                $_citaModel = new CitaModel();
                $_citaModel->byUser($token);
                $id = $_citaModel->insert($data);
                $mensaje = ($id > 0);

                $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarCitas() {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('estatus_cit', '!=', '2')->innerJoin($this->arraySelect, $inners, "cita");
        return $this->retornarMensaje($lista);
    }

    public function listarCitaPorId($cita_id) {

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('cita_id', '=', $cita_id)->where('estatus_cit', '!=', '2')->innerJoin($this->arraySelect, $inners, "cita");

        return $this->retornarMensaje($lista);
    }

    public function listarCitaPorPacienteId($paciente_id) {

        $_citaModel = new CitaModel();
        $lista = $_citaModel->where('estatus_cit', '!=', '2')->where('paciente_id', '=', $paciente_id)->getAll();
        $mensaje = ($lista != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function actualizarCita($cita_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarCita = new Validate;

        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch ($validarCita) {
            case $validarCita->isEmpty($_POST):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

                // ** Enrique
            case !$validarCita->isDuplicated('cita', 'cita_id', $cita_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(400);

            case !$validarCita->isDuplicatedId('cita_id', 'estatus_cit', $cita_id, 3, 'cita'):
                $respuesta = new Response(false, 'La cita seleccionada ya se encuentra asignada');
                return $respuesta->json(400);

            default:

                $data = $validarCita->dataScape($_POST);
                $newArray['estatus_cit'] = 1;
                $newArray['clave'] = $data['clave'];

                $_citaModel = new CitaModel();
                $_citaModel->byUser($token);

                $actualizado = $_citaModel->where('cita_id', '=', $cita_id)->update($newArray);
                $mensaje = ($actualizado > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);
                return $respuesta->json($mensaje ? 200 : 404);
        }
    }

    public function reprogramarCita($cita_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $validarCita = new Validate;

        switch ($validarCita) {
            case !$validarCita->isDuplicated('cita', 'cita_id', $cita_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(400);

            case $validarCita->isDataTime($_POST['fecha_cita']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarCita->isToday($_POST['fecha_cita'], true):
                $respuesta = new Response('FECHA_POSTERIOR');
                return $respuesta->json(400);

            default:

                $_citaModel = new CitaModel();
                $cita = $_citaModel->where('cita_id', '=', $cita_id)->getFirst();

                if ($cita->estatus_cit == 2 || $cita->estatus_cit == 4 || $cita->estatus_cit == 5) {
                    $respuesta = new Response(false, 'La cita no puede estar eliminada, reprogramada o asociada a una consulta');
                    $respuesta->setData("Ocurrió un error reprogramando la cita con estatus ".$cita->estatus_cit);
                    return $respuesta->json(400);

                } else if ( $validarCita->isDuplicatedId('medico_id', 'fecha_cita', $cita->medico_id, $_POST['fecha_cita'], 'cita') ) {
                    $respuesta = new Response('DUPLICATE_APPOINTMENT');
                    $respuesta->setData("Ya existe una cita el día ".$cita->fecha_cita);
                    return $respuesta->json(400);
                }

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

                $isInserted = new Response(false, $isInserted ? 'Cita reprogramada exitosamente' : 'Ocurrió un error reprogramando la cita');
                return $isInserted->json($isInserted ? 201 : 400);
        }
    }

    public function eliminarCita($cita_id) {

        $validarCita = new Validate;
        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_citaModel = new CitaModel();
        $_citaModel->byUser($token);
        $data = array(
            "estatus_cita" => "2"
        );

        $eliminado = $_citaModel->where('cita_id', '=', $cita_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // utils
    public function retornarMensaje($mensaje) {

        $bool = ($mensaje != null);

        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);

        return $respuesta->json($bool ? 200 : 404);
    }
}