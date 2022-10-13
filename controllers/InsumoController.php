<?php

class InsumoController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('insumos/index');
    }

    public function formRegistrarInsumos(){

        return $this->view('insumos/registrarInsumos');
    }

    public function formActualizarInsumo($idInsumo){
        
        return $this->view('insumos/actualizarInsumos', ['idInsumo' => $idInsumo]);
    } 

    public function insertarInsumos(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_insumoModel = new InsumoModel();
        $id = $_insumoModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarInsumos(){

        $_insumoModel = new InsumoModel();
        $lista = $_insumoModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarInsumosPorId($idInsumo){

        $_insumoModel = new InsumoModel();
        $insumo = $_insumoModel->where('insumo_id','=',$idInsumo)->getFirst();
        $mensaje = ($insumo != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($insumo);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarInsumo(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_insumoModel = new InsumoModel();

        $actualizado = $_insumoModel->where('insumo_id','=',$_POST['idInsumo'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarInsumo($idInsumo){

        $_insumoModel = new InsumoModel();

        $eliminado = $_insumoModel->where('insumo_id','=',$idInsumo)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>