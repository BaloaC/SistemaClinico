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

    public function insertarFacturaMedicoPorId(/*Request $request*/){
        
    }

    public function actualizarFacturaMedico($factura_medico_id){}

    public function listarFacturaMedico(){
        
    }

    public function listarFacturaMedicoPorId($factura_medico_id){
        
      
    }

    public function listarFacturaPorMedico($medico_id){
      
    }

    public function listarFacturaPorFecha(){
    }
}
