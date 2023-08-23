<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaService.php";

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
        $camposNumericos = array('monto_consulta');
        $camposId = array('consulta_id', 'paciente_id');

        switch ($validarFactura) {
            case ($validarFactura->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarFactura->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarFactura->existsInDB($_POST, $camposId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case $validarFactura->isEliminated('consulta', 'consulta_id', $_POST['consulta_id']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            // case !$validarFactura->isDuplicatedId('paciente_id', 'consulta_id', $_POST['consulta_id'], $_POST['paciente_id'], 'consulta'):
            //     $respuesta = new Response(false, 'La consulta indicada no coincide con el paciente ingresado');
            //     return $respuesta->json(400);

            case $validarFactura->isDuplicated('factura_consulta', 'consulta_id', $_POST['consulta_id']):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:

                $data = $validarFactura->dataScape($_POST);
                $_facturaConsultaModel = new FacturaConsultaModel();
                $id = $_facturaConsultaModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
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
