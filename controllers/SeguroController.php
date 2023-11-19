<?php

include_once './services/Helpers.php';
include_once './services/seguros/seguro/SeguroService.php';
include_once './services/seguros/seguro/SeguroHelpers.php';
include_once './services/seguros/seguro/SeguroValidaciones.php';

class SeguroController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('seguros/index');
    }

    public function formRegistrarSeguros(){

        return $this->view('seguros/registrarSeguros');
    }

    public function formActualizarSeguro($seguro_id){
        
        return $this->view('seguros/actualizarSeguros', ['seguro$seguro_id' => $seguro_id]);
    } 

    public function insertarSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        SeguroService::insertarSeguro($_POST);
    }

    public function listarSeguros(){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('estatus_seg', '=', '1')->getAll();
        $seguro_lista = array();   

        foreach ($seguro as $seguros) {
            $seguro_lista[] = SeguroService::ListarTodos($seguros);
        }

        $mensaje = ($seguro_lista != null);
        SeguroHelpers::retornarMensaje($mensaje, $seguro_lista);
    }

    public function listarSeguroPorId($seguro_id){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->getFirst();

        if ($seguro) {

            $seguro_lista = array();   

            $seguro_lista = SeguroService::ListarTodos($seguro);

            $mensaje = ($seguro_lista != null);
            SeguroHelpers::retornarMensaje($mensaje, $seguro_lista);
            
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarSeguro($seguro_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        SeguroService::actualizarSeguro($_POST, $seguro_id);

        $validarSeguro = new Validate();
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        $respuesta->setData($validarSeguro->dataScape($_POST));
        return $respuesta->json(200);
    }

    public function eliminarSeguro($idSeguro){

        $_seguroModel = new SeguroModel();
        $data = array(
            "estatus_seg" => "2"
        );

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function insertarSeguroExamen($form) { // form puede ser el seguro_id o un array de datos
        SeguroService::insertarSeguroExamen($form);
    }

    public function eliminarSeguroExamen($seguro_id) {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        SeguroValidaciones::validarExistenciaSeguro($seguro_id);
        SeguroService::eliminarSeguroExamen($_POST, $seguro_id);
        
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        return $respuesta->json(200);
    }
}