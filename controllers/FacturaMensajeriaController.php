<?php

include_once "./services/facturas/mensajeria/FacturaMensajeriaValidaciones.php";
include_once './services/facturas/mensajeria/FacturaMensajeriaService.php';

class FacturaMensajeriaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/mensajeria/index');
    }

    public function formRegistrarFacturaMensajeria(){

        return $this->view('facturas/mensajeria/registrarFacturas');
    }

    public function insertarFacturaMensajeria(/*Request $request*/) { // método para obtener todas las facturas
        
        $_POST = json_decode(file_get_contents('php://input'), true);

        FacturaMensajeriaValidaciones::validarFactura($_POST);
        $validarFactura = new Validate;
        $data = $validarFactura->dataScape($_POST);

        FacturaMensajeriaService::insertarFactura($data);
        
        $respuesta = new Response('INSERCION_EXITOSA');
        return $respuesta->json(201);
    }

    public function actualizarFacturaMensajeria($factura_mensajeria_id) {
        FacturaMensajeriaService::actualizarFactura($factura_mensajeria_id);
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        return $respuesta->json(201);
    }

    public function listarFacturaMensajeria(){
        $_facturaMensajeriaModel = new FacturaMensajeriaModel();
        $facturas = $_facturaMensajeriaModel->getAll();
        
        $facturaLista = FacturaMensajeriaService::listarFacturas($facturas);
        
        $mensaje = (count( (Array) $facturaLista) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($facturaLista);
        return $respuesta->json(200);
    }

    public function listarFacturaMensajeriaPorId($factura_mensajeria_id){

        $_facturaMensajeriaModel = new FacturaMensajeriaModel();
        $facturas = $_facturaMensajeriaModel->where('factura_mensajeria_id', '=', $factura_mensajeria_id)->getFirst();
        
        if ( is_null($facturas) ) {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }

        $facturaLista = FacturaMensajeriaService::listarFacturaMensajeriaId($facturas);
        
        $mensaje = (count( (Array) $facturaLista) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($facturaLista);
        return $respuesta->json(200);
    }
}
