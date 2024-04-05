<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaService.php";
include_once "./services/facturas/consulta/FacturaConsultaValidaciones.php";
include_once './services/consulta/consultaHelpers.php';
include_once './services/Helpers.php';

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
        global $isEnabledAudit;
        $isEnabledAudit = 'recibo de consulta';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;        
        FacturaConsultaValidaciones::validacionesGenerales($_POST);
        FacturaConsultaValidaciones::validarSiEsAsegurada($_POST['consulta_id']);

        $_globalModel = new GlobalModel();
        $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();
        $_POST['monto_consulta_bs'] = $_POST['monto_consulta_usd'] * (float) $valorDivisa->value;

        $data = $validarFactura->dataScape($_POST);
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->insert($data);
        $data['factura_id'] = $id;
        
        if ($id > 0) {
            FacturaConsultaHelpers::insertarPreciosFacturaNormal($_POST['consulta_id']);
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $_POST['consulta_id'])->update(array('estatus_con' => 3));

            $respuesta = new Response('INSERCION_EXITOSA');
            $respuesta->setData($data);
            return $respuesta->json(201);
        }

        $respuesta = new Response('INSERCION_FALLIDA');
        return $respuesta->json(400);
    }

    public function listarFacturaConsulta() {
        $consultaList = FacturaConsultaService::listarFacturas();
        $_facturaConsultaModel = new FacturaConsultaModel();

        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_facturaConsultaModel->limit([$primer_registro, $size]);
            }

            if (strlen($_GET['search']['value']) > 0) {
                $_facturaConsultaModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            }
        }

        if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
            $_facturaConsultaModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        } else {
            $_facturaConsultaModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_facturaConsultaModel->getAll();
        
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $consultaList);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id) {

        $consultaList = FacturaConsultaService::listarFacturaPorId($factura_consulta_id);
        $mensaje = ( count($consultaList) > 0);
        FacturaConsultaHelpers::RetornarMensaje($mensaje, $consultaList);
    }
}
