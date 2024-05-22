<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaService.php";
include_once "./services/facturas/consulta/FacturaConsultaValidaciones.php";
include_once './services/consulta/consultaHelpers.php';
include_once './services/facturas/consulta seguro/ConsultaSeguroService.php';
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

        // verificamos si la factura consulta cubre una consulta completa o una incompleta
        $_consultaSeguroModel = new ConsultaSeguroModel();
        $consulta_seguro = $_consultaSeguroModel->where('consulta_id', '=', $_POST['consulta_id'])->getFirst();
        $monto_consulta_usd = 0;
        
        if (!is_null($consulta_seguro)) {
            $factura = ConsultaSeguroService::listarConsultasSeguroId($consulta_seguro->consulta_seguro_id);

            if (isset($factura[0]['factura'])) {
                $monto_consulta_usd = round($factura[0]['factura']->total_consulta - $factura[0]['factura']->monto_aprobado, 2);
            } else {
                $monto_consulta_usd = $factura[0]['monto_total_usd'] - $factura[0]['cobertura_seguro'];
            }
            $_POST['diferencia_asegurada'] = true;
            
        } else {
            $monto_consulta_usd = FacturaConsultaHelpers::obtenerPrecioConsulta($_POST['consulta_id']);;
        }
        
        $_POST['monto_consulta_usd'] = $monto_consulta_usd;
        $_POST['monto_consulta_bs'] = $monto_consulta_usd * (float) $valorDivisa->value;

        $data = $validarFactura->dataScape($_POST);
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->insert($data);
        $data['factura_id'] = $id;
        
        if ($id > 0) {
            if (!isset($_POST['diferencia_asegurada'])) {
                FacturaConsultaHelpers::insertarPreciosFacturaNormal($_POST['consulta_id']);
            } else {
                if (array_key_exists('factura', $factura[0])) {
                    FacturaConsultaHelpers::insertarDiferenciaEmergencia($_POST, $factura[0]);
                } else {
                    FacturaConsultaHelpers::insertarDiferenciaExamenes($_POST, $factura[0]);
                }
            }
            
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

        // if (isset($_GET['start']) || isset($_GET['search'])) {
        //     if (isset($_GET['start'])) {
        //         $size = isset($_GET['length']) ? $_GET['length'] : 10;
        //         $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

        //         $ultimo_registro = $pagina_actual * $size;
        //         $primer_registro = $ultimo_registro - $size;
        //         $_facturaConsultaModel->limit([$primer_registro, $size]);
        //     }

        //     if (strlen($_GET['search']['value']) > 0) {
        //         $_facturaConsultaModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        //     }
        // }
        $facturasList = "";

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_facturaConsultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(factura_consulta.factura_consulta_id)", 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_facturaConsultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(factura_consulta.factura_consulta_id)", 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_facturaConsultaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_facturaConsultaModel->setSelect('COUNT(*) AS total');
        }

        // if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
        //     $_facturaConsultaModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        // } else {
        //     $_facturaConsultaModel->setSelect('COUNT(*) AS total');
        // }

        // $total_registros = $_facturaConsultaModel->getAll();
        $innersConsulta = $_facturaConsultaModel->listInner(array("consulta" => "factura_consulta"));
        $selectConsulta = array("factura_consulta.factura_consulta_id","factura_consulta.consulta_id","factura_consulta.tipo_consulta","factura_consulta.metodo_pago","factura_consulta.monto_consulta_bs","factura_consulta.monto_consulta_usd","factura_consulta.estatus_fac","consulta.fecha_consulta","consulta.es_emergencia");

        if ( array_key_exists('date', $_GET) ) {
            
            $fecha_mes = DateTime::createFromFormat('Y-m-d', $_GET['date']);
            $mes = $fecha_mes->format("m");
            $anio = $fecha_mes->format("Y");
            
            $facturasList = $_facturaConsultaModel->where('YEAR(fecha_consulta)',"=",$anio)
                                                ->where('MONTH(fecha_consulta)', '=', $mes)
                                                ->innerJoin($selectConsulta, $innersConsulta, "factura_consulta");

        } else {
            $facturasList = $_facturaConsultaModel->innerJoin($selectConsulta, $innersConsulta, "factura_consulta");
        }
        
        // Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $consultaList);
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($facturasList), $consultaList);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id) {

        $consultaList = FacturaConsultaService::listarFacturaPorId($factura_consulta_id);
        $mensaje = ( count($consultaList) > 0);
        FacturaConsultaHelpers::RetornarMensaje($mensaje, $consultaList);
    }
}
