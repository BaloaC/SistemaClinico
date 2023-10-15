<?php

include_once './services/medico/medico/MedicoService.php';

class MedicoController extends Controller {

    protected $arrayInnerHorario = array(
        "medico" => "horario"
    );

    protected $arraySelectHorario = array(
        "horario.horario_id",
        "horario.dias_semana",
        "horario.hora_entrada",
        "horario.hora_salida"
    );

    protected $arrayInner = array(
        // "medico" => "medico_especialidad",
        "especialidad" => "medico_especialidad",
    );

    protected $arraySelect = array(
        "especialidad.nombre AS nombre_especialidad",
        "especialidad.especialidad_id",
        "medico_especialidad.medico_especialidad_id"
    );

    //Método index (vista principal)
    public function index() {

        return $this->view('medicos/index');
    }

    public function formRegistrarMedicos() {

        return $this->view('medicos/registrarMedicos');
    }

    public function formActualizarMedico($medico_id) {

        return $this->view('medicos/actualizarMedicos', ['medico_id' => $medico_id]);
    }

    public function perfilMedico() {
        return $this->view('medicos/perfilMedico');
    }

    public function insertarMedico(/*Request $request*/) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        // $validarMedico = new Validate;

        MedicoService::insertarMedico($_POST);

        

        // switch ($_POST) {
        //     case ($validarMedico->isEmpty($_POST)):
        //         $respuesta = new Response('DATOS_INVALIDOS');
        //         return $respuesta->json(400);

        //     case $validarMedico->isNumber($_POST, $camposNumericos):
        //         $respuesta = new Response('DATOS_INVALIDOS');
        //         return $respuesta->json(400);

        //     case $validarMedico->isString($_POST, $camposString):
        //         $respuesta = new Response('DATOS_INVALIDOS');
        //         return $respuesta->json(400);

        //     case $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]):
        //         $respuesta = new Response('DATOS_DUPLICADOS');
        //         return $respuesta->json(400);

        //     default:

                // Extrayendo la información de las tablas foráneas
                // $especialidad = $_POST['especialidad'];
                // $horario = $_POST['horario'];
                // unset($_POST['especialidad']);
                // unset($_POST['horario']);

                // $data = $validarMedico->dataScape($_POST);

                // $_medicoModel = new MedicoModel();
                // $id = $_medicoModel->insert($data);

                // MedicoValidaciones::validarDuplicadoMedicoEspecialidad($especialidad, $id);
                // MedicoValidaciones::validarMedicoHorario($horario, $id);

                // Comprobando que se haya insertado el médico para formar las relaciones
                // if ($id > 0) {
                //     // $insertarEspecialidad = new MedicoEspecialidadController;
                //     // $mensaje = $insertarEspecialidad->insertarMedicoEspecialidad($especialidad, $id);

                //     if ($mensaje == true) {
                //         return $mensaje;
                //     } else {

                //         $insertarHorario = new HorarioController;
                //         $mensaje = $insertarHorario->insertarHorario($horario, $id);

                //         if ($mensaje == true) {
                //             return $mensaje;
                //         } else {

                            $respuesta = new Response('INSERCION_EXITOSA');
                            return $respuesta->json(201);
                //         }
                //     }
                // } else {

                //     $respuesta = new Response('INSERCION_FALLIDA');
                //     return $respuesta->json(400);
                // }
        // }
    }

    public function listarMedicos() {

        $_medicoModel = new MedicoModel();
        $medico2 = $_medicoModel->where('estatus_med', '=', '1')->getAll();

        if ($medico2) {
            $resultado = array();

            foreach ($medico2 as $medicos) {
                // Especialidad
                $_medicoModel = new MedicoModel();
                $inners = $_medicoModel->listInner($this->arrayInner);
                $medico = $_medicoModel->where('medico_especialidad.medico_id', '=', $medicos->medico_id)->where('medico_especialidad.estatus_med', '=', '1')->innerJoin($this->arraySelect, $inners, "medico_especialidad");

                if ($medico) {
                    $medicos->especialidad = $medico;
                }

                $_medicoModel = new MedicoModel();
                $innersH = $_medicoModel->listInner($this->arrayInnerHorario);
                $horario = $_medicoModel->where('horario.medico_id', '=', $medicos->medico_id)->where('horario.estatus_hor', '=', '1')->innerJoin($this->arraySelectHorario, $innersH, "horario");

                // Horario
                if ($horario) {
                    $medicos->horario = $horario;
                }
                $resultado[] = $medicos;
            }

            return $this->retornarMensaje($resultado, $resultado);
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function listarMedicoPorId($medico_id) {

        $_medicoModel = new MedicoModel();
        $medicos = $_medicoModel->where('estatus_med', '=', '1')->where('medico_id', '=', $medico_id)->getFirst();

        if ($medicos) {
            $resultado = array();

            // Especialidad
            $_medicoModel = new MedicoModel();
            $inners = $_medicoModel->listInner($this->arrayInner);
            $medico = $_medicoModel->where('medico_especialidad.medico_id', '=', $medicos->medico_id)->where('medico_especialidad.estatus_med', '=', '1')->innerJoin($this->arraySelect, $inners, "medico_especialidad");

            if ($medico) {
                $medicos->especialidad = $medico;
            }

            $_medicoModel = new MedicoModel();
            $innersH = $_medicoModel->listInner($this->arrayInnerHorario);
            $horario = $_medicoModel->where('horario.medico_id', '=', $medicos->medico_id)->where('horario.estatus_hor', '=', '1')->innerJoin($this->arraySelectHorario, $innersH, "horario");

            // Horario
            if ($horario) {
                $medicos->horario = $horario;
            }
            $resultado[] = $medicos;

            return $this->retornarMensaje($resultado, $resultado);
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarMedico($medico_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "telefono", "especialidad_id");
        $camposString = array("nombres", "apellidos", "direccion");
        $validarMedico = new Validate;

        switch ($_POST) {

            case ($validarMedico->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarMedico->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarMedico->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarMedico->isDuplicated('medico', 'medico_id', $medico_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case array_key_exists('cedula', $_POST):
                if ($validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);
                }

            default:

                if (array_key_exists('especialidad', $_POST)) {
                    $especialidad = $_POST['especialidad'];
                    unset($_POST['especialidad']);

                    $insertarEspecialidad = new MedicoEspecialidadController;
                    $mensajeEspecialidad = $insertarEspecialidad->insertarMedicoEspecialidad($especialidad, $medico_id);

                    if ($mensajeEspecialidad == false) {
                        return $mensajeEspecialidad;
                    }
                }

                if (array_key_exists('horario', $_POST)) {
                    $horario = $_POST['horario'];
                    unset($_POST['horario']);

                    $insertarHorario = new HorarioController;
                    $mensaje = $insertarHorario->insertarHorario($horario, $medico_id);

                    if ($mensaje == false) {
                        return $mensaje;
                    }
                }

                $data = $validarMedico->dataScape($_POST);

                if (!empty($data)) {

                    $_medicoModel = new MedicoModel();
                    $actualizado = $_medicoModel->where('medico_id', '=', $medico_id)->update($data);
                    $mensaje = ($actualizado > 0);
                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);
                } else {

                    $respuesta = new Response(true, 'Información insertada correctamente');
                    return $respuesta->json(201);
                }
        }
    }

    public function eliminarMedico($medico_id) {

        $_medicoModel = new MedicoModel();
        $data = array(
            "estatus_med" => "2"
        );

        $eliminado = $_medicoModel->where('medico_id', '=', $medico_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones
    public function retornarMensaje($mensaje, $dataReturn) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($dataReturn);
        return $respuesta->json(200);
    }
}
