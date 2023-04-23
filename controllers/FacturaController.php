<?php

class FacturaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/index');
    }

    public function formRegistrarFacturas(){

        return $this->view('facturas/registrarFacturas');
    }

    public function formActualizarFactura($idFactura){
        
        return $this->view('facturas/actualizarFacturas', ['idFactura' => $idFactura]);
    } 

    public function insertarFacturas(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        // var_dump($_POST);
        $_facturaModel = new FacturaModel();
        $id = $_facturaModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarFacturas(){

        $_facturaModel = new FacturaModel();
        $lista = $_facturaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarFacturasPorId($idFactura){

        $_facturaModel = new FacturaModel();
        $factura = $_facturaModel->where('factura_id','=',$idFactura)->getFirst();
        $mensaje = ($factura != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($factura);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarFactura(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_facturaModel = new FacturaModel();

        $actualizado = $_facturaModel->where('factura_id','=',$_POST['idFactura'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarFactura($idFactura){

        $_facturaModel = new FacturaModel();

        $eliminado = $_facturaModel->where('factura_id','=',$idFactura)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>