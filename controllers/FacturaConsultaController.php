<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaService.php";
include_once "./services/facturas/consulta/FacturaConsultaValidaciones.php";
include_once './services/consulta/consultaHelpers.php';

class FacturaConsultaController extends Controller {

    //Método index (vista principal)
    public function index() {
        return $this->view('facturas/consulta/index');
    }

    public function formRegistrarFacturaConsulta() {
        return $this->view('facturas/consulta/registrarFacturas');
    }

    public function formActualizarFacturaConsulta($factura_consulta_id) {
        return $this->view('facturas/consulta/actualizarFacturas', ['factura_consulta_id' => $factura_consulta_id]);
    }

    public function insertarFacturaConsulta(/*Request $request*/) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;        
        FacturaConsultaValidaciones::validacionesGenerales($_POST);

        $_globalModel = new GlobalModel();
        $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();
        $_POST['monto_consulta_bs'] = $_POST['monto_consulta_usd'] * (float) $valorDivisa->value;

        $data = $validarFactura->dataScape($_POST);
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->insert($data);
        
        if ($id > 0) {
            FacturaConsultaHelpers::insertarPreciosFacturaNormal($_POST['consulta_id']);
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $_POST['consulta_id'])->update(array('estatus_con' => 3));

            $respuesta = new Response('INSERCION_EXITOSA');
            return $respuesta->json(201);
        }

        $respuesta = new Response('INSERCION_FALLIDA');
        return $respuesta->json(400);
    }

    public function listarFacturaConsulta() {
        $consultaList = FacturaConsultaService::listarFacturas();
        $mensaje = ( count($consultaList) > 0);
        FacturaConsultaHelpers::RetornarMensaje($mensaje, $consultaList);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id) {

        $consultaList = FacturaConsultaService::listarFacturaPorId($factura_consulta_id);
        $mensaje = ( count($consultaList) > 0);
        FacturaConsultaHelpers::RetornarMensaje($mensaje, $consultaList);
    }
}
