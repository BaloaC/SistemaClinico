<?php

include_once "./services/facturas/consulta seguro/ConsultaSeguroService.php";
include_once "./services/facturas/seguro/FacturaSeguroService.php";
include_once "./services/facturas/seguro/FacturaSeguroValidaciones.php";

class FacturaSeguroController extends Controller{

    protected $arrayInner = array (
        "seguro" => "factura_seguro"
    );

    protected $arraySelect = array(
        "factura_seguro.factura_seguro_id",
        "factura_seguro.seguro_id",
        "factura_seguro.mes",
        "factura_seguro.fecha_ocurrencia",
        "factura_seguro.fecha_vencimiento",
        "factura_seguro.monto_bs",
        "factura_seguro.monto_usd",
        "factura_seguro.estatus_fac",
        "seguro.nombre",
        "seguro.rif"
    );

    protected $consultaInner = array (
        "consulta" => "consulta_seguro"
    );

    protected $consultaSelect = array(
        "consulta.consulta_id",
        "consulta.fecha_consulta",
        "consulta_seguro.consulta_seguro_id",
        "consulta_seguro.seguro_id",
        "consulta_seguro.tipo_servicio",
        "consulta_seguro.fecha_ocurrencia",
        "consulta_seguro.monto_consulta_usd",
        "consulta_seguro.monto_consulta_bs",
        "consulta_seguro.estatus_con"
    );
    
    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/seguros/index');
    
    }
    public function segurosAge(){

        return $this->view('facturas/seguros/seguros-age');
    }

    public function formRegistrarFacturaMedico(){

        return $this->view('facturas/medicos/registrarFacturas');
    }

    public function formActualizarFacturaMedico($factura_medico_id){
        
        return $this->view('facturas/medicos/actualizarFacturas', ['factura_medico_id' => $factura_medico_id]);
    } 

    public function solicitarFacturaSeguro(/*Request $request*/) { // método para obtener todas las facturas
        global $isEnabledAudit;
        $isEnabledAudit = 'facturas de consultas aseguradas';

        // if ( date("d") != "01") {
            
            date_default_timezone_set('America/Caracas');
            $fecha_actual = new DateTime();
            $fecha_actual = $fecha_actual->format("Y-m-d");
            
            $mes = date("m", strtotime($fecha_actual));
            $anio = date("Y", strtotime($fecha_actual));

            $_seguroModel = new SeguroModel();
            $seguroList = $_seguroModel->where('estatus_seg', '=', '1')->getAll();

            // Por cada seguro buscamos las facturas que tengan de las consultas
            foreach ($seguroList as $seguro) {
                
                $factura = FacturaSeguroService::calcularFactura($seguro->seguro_id, $mes, $anio);
                $facturaExiste = FacturaSeguroHelpers::comprobarExistenciaFactura($seguro->seguro_id, $mes, $anio);
                $_facturaSeguroModel = new FacturaSeguroModel();

                if ($facturaExiste) {
                    
                    $_facturaSeguroModel->where('seguro_id', '=', $seguro->seguro_id)
                                        ->where('YEAR(factura_seguro.fecha_ocurrencia)', '=', $anio)
                                        ->where('MONTH(factura_seguro.fecha_ocurrencia)', '=', $mes)
                                        ->update($factura);

                } else {
                    $_facturaSeguroModel->insert($factura);
                }
            }

            $respuesta = new Response('CORRECTO');
            return $respuesta->json(200);
        // }
    }

    public function listarFacturaSeguro(){

        $_facturaSeguroModel = new FacturaSeguroModel();
        $inners = $_facturaSeguroModel->listInner($this->arrayInner);
        $id = $_facturaSeguroModel->innerJoin($this->arraySelect, $inners, "factura_seguro");
        
        return FacturaSeguroHelpers::retornarMensaje($id);
    }

    public function listarFacturaSeguroPorSeguro($seguro_id){
        
        $_facturaSeguroModel = new FacturaSeguroModel();
        $inners = $_facturaSeguroModel->listInner($this->arrayInner);
        $id = $_facturaSeguroModel->where('factura_seguro.seguro_id', '=', $seguro_id)->innerJoin($this->arraySelect, $inners, "factura_seguro");
        
        return FacturaSeguroHelpers::retornarMensaje($id);
    }

    public function listarFacturaSeguroPorFecha($fecha){
        
        $seguro_id = $_GET["seguro"];
        $mes = $_GET["mes"];
        $anio = $_GET["anio"];

        $_facturaSeguroModel = new FacturaSeguroModel();
        $inners = $_facturaSeguroModel->listInner($this->arrayInner);
        $facturas["factura"] = $_facturaSeguroModel->where('factura_seguro.seguro_id', '=', $seguro_id)
                                                    ->where('YEAR(factura_seguro.fecha_ocurrencia)',"=",$anio)
                                                    ->where('MONTH(factura_seguro.fecha_ocurrencia)', '=', $mes)
                                                    ->innerJoin($this->arraySelect, $inners, "factura_seguro");

        // Si no hay factura en ese año/mes retornar error
        FacturaSeguroValidaciones::validarLengthFactura($facturas);
        
        $consultasSeguro = ConsultaSeguroService::listarConsultasPorSeguroYMes($seguro_id, $mes, $anio);

        $facturas["consultas"] = $consultasSeguro; 
        return FacturaSeguroHelpers::retornarMensaje($facturas);
    }

    public function listarFacturaPorId($factura_seguro_id){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        FacturaSeguroValidaciones::validarFacturaId($factura_seguro_id);
        return FacturaSeguroService::listarFacturaId($factura_seguro_id);
    }

    public function actualizarFacturaSeguro($factura_seguro_id) {
        $respuesta = FacturaSeguroService::actualizarEstatus($factura_seguro_id);
        return $respuesta;
    }
}
