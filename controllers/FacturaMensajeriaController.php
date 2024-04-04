<?php

include_once "./services/facturas/mensajeria/FacturaMensajeriaValidaciones.php";
include_once './services/facturas/mensajeria/FacturaMensajeriaService.php';
include_once './services/Helpers.php';

class FacturaMensajeriaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/mensajeria/index');
    }

    public function formRegistrarFacturaMensajeria(){

        return $this->view('facturas/mensajeria/registrarFacturas');
    }

    public function insertarFacturaMensajeria(/*Request $request*/) { // método para obtener todas las facturas
        global $isEnabledAudit;
        $isEnabledAudit = 'recibo de mensajería';

        $_POST = json_decode(file_get_contents('php://input'), true);

        FacturaMensajeriaValidaciones::validarFactura($_POST);
        $validarFactura = new Validate;
        $data = $validarFactura->dataScape($_POST);

        $id = FacturaMensajeriaService::insertarFactura($data);
        $data['factura_id'] = $id;
        
        $respuesta = new Response('INSERCION_EXITOSA');
        $respuesta->setData($data);
        return $respuesta->json(201);
    }

    public function actualizarFacturaMensajeria($factura_mensajeria_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'recibo de mensajería';

        FacturaMensajeriaService::actualizarFactura($factura_mensajeria_id);
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        return $respuesta->json(201);
    }

    public function listarFacturaMensajeria(){
        $_facturaMensajeriaModel = new FacturaMensajeriaModel();
        
        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_facturaMensajeriaModel->limit([$primer_registro, $size]);
            }

            if (strlen($_GET['search']['value']) > 0) {
                $_facturaMensajeriaModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            }
        }
        
        $facturas = $_facturaMensajeriaModel->getAll();
        $facturaLista = FacturaMensajeriaService::listarFacturas($facturas);

        $_facturaMensajeriaModel->resetValues();

        if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
            $_facturaMensajeriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        } else {
            $_facturaMensajeriaModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_facturaMensajeriaModel->where('estatus_fac', '=', '1')->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $facturaLista);
        
        // $mensaje = (count( (Array) $facturaLista) > 0);
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        // $respuesta->setData($facturaLista);
        // return $respuesta->json(200);
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
