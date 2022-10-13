<?php

class ProveedorController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('proveedores/index');
    }

    public function formRegistrarProveedores(){

        return $this->view('proveedores/registrarProveedores');
    }

    public function formActualizarProveedor($idProveedor){
        
        return $this->view('proveedores/actualizarProveedores', ['idProveedor' => $idProveedor]);
    } 

    public function insertarProveedores(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_proveedorModel = new ProveedorModel();
        $id = $_proveedorModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarProveedores(){

        $_proveedorModel = new ProveedorModel();
        $lista = $_proveedorModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarProveedoresPorId($idProveedor){

        $_proveedorModel = new ProveedorModel();
        $proveedor = $_proveedorModel->where('proveedor_id','=',$idProveedor)->getFirst();
        $mensaje = ($proveedor != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($proveedor);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarProveedor(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_proveedorModel = new ProveedorModel();

        $actualizado = $_proveedorModel->where('proveedor_id','=',$_POST['idProveedor'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarProveedor($idProveedor){

        $_proveedorModel = new ProveedorModel();

        $eliminado = $_proveedorModel->where('proveedor_id','=',$idProveedor)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>