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
        MedicoService::insertarMedico($_POST);

        $respuesta = new Response('INSERCION_EXITOSA');
        return $respuesta->json(201);
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

        MedicoService::actualizarMedico($_POST, $medico_id);
        $respuesta = new Response(true, 'Información insertada correctamente');
        return $respuesta->json(200);
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
