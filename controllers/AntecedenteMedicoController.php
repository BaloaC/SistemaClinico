<?php

class AntecedenteMedicoController extends Controller {

    protected $arraySelect = array(
        "antecedentes_medicos.antecedentes_medicos_id",
        "antecedentes_medicos.paciente_id",
        "antecedentes_medicos.descripcion",
        "antecedentes_medicos.fecha_creacion",
        "antecedentes_medicos.tipo_antecedente_id",
        "tipo_antecedente.nombre"
    );

    protected $arrayInner = array(
        "tipo_antecedente" => "antecedentes_medicos",
    );

    //Método index (vista principal)
    public function index() {

        return $this->view('antecedentes/index');
    }

    public function formRegistrarAntecedentes() {
        return $this->view('antecedentes/registrarAntecedente');
    }

    public function formActualizarAntecedente($antecedente_id) {
        return $this->view('antecedentes/actualizarAntecedente', ['antecedente_id' => $antecedente_id]);
    }

    public function insertarAntecedente(/*Request $request*/) {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $campoId = array("tipo_antecedente_id","paciente_id");
        $validarAntecedente = new Validate;
        
        switch ($_POST) {
            
            case ($validarAntecedente->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case !$validarAntecedente->existsInDB($_POST, $campoId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            default:

                $data = $validarAntecedente->dataScape($_POST);
                $_antecedenteModel = new AntecedenteMedicoModel();
                $header = apache_request_headers();
                $token = substr($header['Authorization'], 7) ;
                $_antecedenteModel->byUser($token);

                $isInserted = $_antecedenteModel->insert($data);
                $mensaje = ($isInserted > 0);
                
                $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarAntecedentes() {

        $_antecedenteModel = new AntecedenteMedicoModel();
        $inners = $_antecedenteModel->listInner($this->arrayInner);
        $lista = $_antecedenteModel->where('estatus_ant', '!=', '2')->innerJoin($this->arraySelect, $inners, "antecedentes_medicos");
        return $this->retornarMensaje($lista);
    }

    public function listarAntecedentesPorPaciente($paciente_id) {

        $_antecedenteModel = new AntecedenteMedicoModel();
        $inners = $_antecedenteModel->listInner($this->arrayInner);
        $lista = $_antecedenteModel->where('estatus_ant', '!=', '2')
                                    ->where('paciente_id', '=', $paciente_id)
                                    ->innerJoin($this->arraySelect, $inners, "antecedentes_medicos");
        return $this->retornarMensaje($lista);
    }

    public function listarAntecedentePorId($antecedentes_medicos_id) {

        $_antecedenteModel = new AntecedenteMedicoModel();
        $inners = $_antecedenteModel->listInner($this->arrayInner);
        $lista = $_antecedenteModel->where('estatus_ant', '!=', '2')
                                    ->where('antecedentes_medicos_id', '=', $antecedentes_medicos_id)
                                    ->innerJoin($this->arraySelect, $inners, "antecedentes_medicos");
        return $this->retornarMensaje($lista);
    }

    public function actualizarAntecedente($antecedentes_medicos_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $campoId = array("paciente_id" , "tipo_antecedente_id ");
        $validarAntecedente = new Validate;
        
        switch ($_POST) {
            
            case ($validarAntecedente->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            default:

                if ( isset($_POST['paciente_id']) ) {
                    $respuesta = new Response('DATOS_VACIOS');
                    $respuesta->setData("Error al buscar el paciente id".$_POST['tipo_antecedente_id']);
                    return $respuesta->json(400);
                }

                if ( isset($_POST['tipo_antecedente_id']) ) {
                    $respuesta = new Response('DATOS_VACIOS');
                    $respuesta->setData("Error al buscar el tipo de antecedente id".$_POST['tipo_antecedente_id']);
                    return $respuesta->json(400);
                }

                $data = $validarAntecedente->dataScape($_POST);
                $_antecedenteModel = new AntecedenteMedicoModel();
                $header = apache_request_headers();
                $token = substr($header['Authorization'], 7) ;
                $_antecedenteModel->byUser($token);

                $isInserted = $_antecedenteModel->where('antecedentes_medicos_id', '=', $antecedentes_medicos_id)->update($data);
                $mensaje = ($isInserted > 0);
                
                $mensaje = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function eliminarAntecedente($antecedentes_medicos_id) {

        $header = apache_request_headers();
        $token = substr($header['Authorization'], 7) ;

        $_antecedenteModel = new AntecedenteMedicoModel();
        $_antecedenteModel->byUser($token);
        $data = array(
            "estatus_ant" => "2"
        );

        $eliminado = $_antecedenteModel->where('antecedentes_medicos_id', '=', $antecedentes_medicos_id)->update($data);
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
