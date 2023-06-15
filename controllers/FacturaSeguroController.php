<?php

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
        "factura_seguro.monto",
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
        "consulta_seguro.monto",
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

    public function insertarFacturaSeguro(/*Request $request*/) { // método para obtener todas las facturas
        
        if ( date("d") == "01") {
            // Obteniendo primer y último día
            $fecha_mes = new DateTime();
            $fecha_mes->modify('first day of this month');
            $primer_dia = $fecha_mes->format("Y-m-d");
            
            $fecha_mes->modify('last day of this month');
            $ultimo_dia = $fecha_mes->format("Y-m-d");
            
            $_seguroModel = new SeguroModel();
            $seguroList = $_seguroModel->where('estatus_seg', '=', '1')->getAll();
            
            // $header = apache_request_headers();
            // $token = substr($header['Authorization'], 7) ;
            // echo '<pre>';
            // Por cada seguro buscamos las facturas que tengan de las consultas
            foreach ($seguroList as $seguro) {
                $facturaList = [];
                $_consultaSeguro = new ConsultaSeguroModel();
                // $consultaList = $_consultaSeguro->where('seguro_id', '=',$seguro->seguro_id)->whereDate('fecha_ocurrencia', $primer_dia, $ultimo_dia)->getAll();
                $inners = $_consultaSeguro->listInner($this->consultaInner);
                $consultaList = $_consultaSeguro->where('consulta_seguro.estatus_con', '=', '1')->where('consulta.estatus_con', '=', '1')
                                                ->whereDate('consulta.fecha_consulta', $primer_dia, $ultimo_dia)
                                                ->innerJoin($this->consultaSelect, $inners, "consulta_seguro");
                // Por cada factura en consulta, sumamos el monto para obtener el total
                $montoConsulta = 0;

                if (count($consultaList) > 0) {
                    foreach ($consultaList as $consulta) {
                        $montoConsulta += $consulta->monto;
                    }
                }

                // Le sumamos 1 mes a la fecha de hoy
                $fecha_actual = date("Y-m-d"); 
                $fecha_vencimiento = strtotime('+1 month', strtotime($fecha_actual));
                $fecha_vencimiento = date('Y-m-d', $fecha_vencimiento);
                
                // date_default_timezone_set("America/Caracas");
                setlocale(LC_TIME, 'es_VE.UTF-8','esp');

                $facturaList = [
                    "seguro_id" => $seguro->seguro_id,
                    "fecha_vencimiento" => "$fecha_vencimiento",
                    "monto" => $montoConsulta,
                    "mes" => strftime("%B")
                ];

                $_facturaSeguroModel = new FacturaSeguroModel();
                // $_facturaSeguroModel->byUser($token);
                $id = $_facturaSeguroModel->insert($facturaList);
            }
        }
    }

    public function listarFacturaSeguro(){

        $_facturaSeguroModel = new FacturaSeguroModel();
        $inners = $_facturaSeguroModel->listInner($this->arrayInner);
        $id = $_facturaSeguroModel->innerJoin($this->arraySelect, $inners, "factura_seguro");
        
        return $this->retornarMensaje($id);
    }

    public function listarFacturaSeguroPorSeguro($seguro_id){
        
        $_facturaSeguroModel = new FacturaSeguroModel();
        $inners = $_facturaSeguroModel->listInner($this->arrayInner);
        $id = $_facturaSeguroModel->where('factura_seguro.seguro_id', '=', $seguro_id)->innerJoin($this->arraySelect, $inners, "factura_seguro");
        
        return $this->retornarMensaje($id);
    }

    public function listarFacturaPorId($factura_seguro_id){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;

        if ( !$validarFactura->isDuplicated('factura_seguro', 'factura_seguro_id', $factura_seguro_id) ) {
            $respuesta = new Response(false, 'No se encontró la factura indicada en la base de datos');
            $respuesta->setData("Error en factura seguros con el id $factura_seguro_id");
            return $respuesta->json(400);
        }

        // Obtenemos el seguro para saber por cuáles fechas filtrar
        $_facturaSeguroModel = new FacturaSeguroModel();
        $factura = $_facturaSeguroModel->where('factura_seguro.factura_seguro_id', '=', $factura_seguro_id)->getFirst();
        
        // Obtenemos las fechas
        $fechaVencimiento = $factura->fecha_vencimiento;
        $fechaOcurrencia = strtotime('-1 month', strtotime($fechaVencimiento));
        $fechaOcurrencia = date('Y-m-d', $fechaOcurrencia);

        $fechaMes = new DateTime($fechaOcurrencia);
        $fechaMes->modify('first day of this month');
        $primer_dia = $fechaMes->format("Y-m-d");
        
        $fechaMes->modify('last day of this month');
        $ultimo_dia = $fechaMes->format("Y-m-d");

        // Pedimos las consultas relacionadas a ese seguro en el mes de esa factura
        $_consultaSeguro = new ConsultaSeguroModel();
        $inners = $_consultaSeguro->listInner($this->consultaInner);
        $consultaList = $_consultaSeguro->where('consulta_seguro.estatus_con', '=', '1')->where('consulta.estatus_con', '=', '1')
                                        ->where('seguro_id', '=', $factura->seguro_id)
                                        ->whereDate('consulta.fecha_consulta', $primer_dia, $ultimo_dia)
                                        ->innerJoin($this->consultaSelect, $inners, "consulta_seguro");

        if ( count($consultaList) > 0 ) {
            return $this->retornarMensaje($consultaList);
        } else {
            $respuesta = new Response(false, "No hay consultas en el mes de $factura->mes para la factura indicada");
            $respuesta->setData("Error con la factura id $factura->factura_seguro_id");
            return $respuesta->json(200);
        }

    }

    public function retornarMensaje($resultadoSentencia) {

        $bool = ($resultadoSentencia > 0);

        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultadoSentencia);
        return $respuesta->json(200);
        
    }
}
