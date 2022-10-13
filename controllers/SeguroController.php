<?php

class SeguroController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('seguros/index');
    }

    public function formRegistrarSeguros(){

        return $this->view('seguros/registrarSeguros');
    }

    public function formActualizarSeguro($idSeguro){
        
        return $this->view('seguros/actualizarSeguros', ['idSeguro' => $idSeguro]);
    } 

    public function insertarSeguros(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_seguroModel = new SeguroModel();
        $id = $_seguroModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarSeguros(){

        $_seguroModel = new SeguroModel();
        $lista = $_seguroModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarSegurosPorId($idSeguro){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro_id','=',$idSeguro)->getFirst();
        $mensaje = ($seguro != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($seguro);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarSeguro(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_seguroModel = new SeguroModel();

        $actualizado = $_seguroModel->where('seguro_id','=',$_POST['idSeguro'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarSeguro($idSeguro){

        $_seguroModel = new SeguroModel();

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>