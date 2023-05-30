<?php

class FacturaSeguroController extends Controller{
    
    protected $arrayInner = array (
        "medico" => "factura_medico"
    );

    protected $arraySelect = array(
        "medico.nombre",
        "medico.apellidos",
        "factura_medico.medico_id",
        "factura_medico.factura_medico_id",
        "factura_medico.acumulado_seguro_total",
        "factura_medico.acumulado_consulta_total",
        "factura_medico.pago_total",
        "factura_medico.pacientes_seguro",
        "factura_medico.pacientes_consulta",
        "factura_medico.fecha_pago"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/seguros/index');
    }

    public function formRegistrarFacturaMedico(){

        return $this->view('facturas/seguros/registrarFacturas');
    }

    public function formActualizarFacturaMedico($factura_medico_id){
        
        return $this->view('facturas/seguros/actualizarFacturas', ['factura_medico_id' => $factura_medico_id]);
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
            
            $header = apache_request_headers();
            $token = substr($header['Authorization'], 7) ;

            // Por cada seguro buscamos las facturas que tengan de las consultas
            foreach ($seguroList as $seguro) {
                $facturaList = [];
                $_consultaSeguro = new ConsultaSeguroModel();
                $consultaList = $_consultaSeguro->where('seguro_id', '=',$seguro->seguro_id)->whereDate('fecha_ocurrencia', $primer_dia, $ultimo_dia)->getAll();
                
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
                $_facturaSeguroModel->byUser($token);
                $id = $_facturaSeguroModel->insert($facturaList);
            }
        }
    }

    // public function solicitarFacturaMedicoPorId(/*Request $request*/){
        
    //     $_POST = json_decode(file_get_contents('php://input'), true);
    //     $validarFactura = new Validate;

    //     $token = $validarFactura->validateToken(apache_request_headers());
    //     if (!$token) {
    //         $respuesta = new Response('TOKEN_INVALID');
    //         return $respuesta->json(401);
    //     }

    //     $camposId = array('medico_id');
        
    //     switch ($validarFactura) {
    //         case ($validarFactura->isEmpty($_POST)):
    //             $respuesta = new Response('DATOS_VACIOS');
    //             return $respuesta->json(400);

    //         case !($validarFactura->existsInDB($_POST, $camposId)):
    //             $respuesta = new Response('MD_NOT_FOUND');
    //             return $respuesta->json(200);

    //         case $validarFactura->isDate($_POST['fecha_actual']):
    //             $respuesta = new Response('NOT_FOUND');
    //             return $respuesta->json(200);
            
    //         default:
                
    //             $data = $validarFactura->dataScape($_POST);
    //             $insert = $this->contabilizarFactura($data);
                
    //             $_facturaMedicoModel = new FacturaMedicoModel();
    //             $_facturaMedicoModel->byUser($token);
    //             $id = $_facturaMedicoModel->insert($insert);
    //             $mensaje = ($id > 0);

    //             $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
    //             return $respuesta->json($mensaje ? 201 : 400);
    //     }
    // }

    // public function actualizarFacturaMedico($factura_medico_id){

    //     $header = apache_request_headers();
    //     $token = substr($header['Authorization'], 7);
    //     $_facturaMedico = new FacturaMedicoModel();
    //     $factura_medico = $_facturaMedico->where('factura_medico_id', '=', $factura_medico_id)->getFirst();

    //     if ($factura_medico->estatus_fac != '1') {
    //         $respuesta = new Response(false, 'No puede realizar operaciones con una factura ya cancelada o eliminada');
    //         $respuesta->setData("Error al actualizar la factura $factura_medico_id con estatus ".($factura_medico->estatus_fac == '2' ? 'pagado' : 'anulada'));
    //         return $respuesta->json(400);
    //     }

    //     $_facturaMedico->byUser($token);
    //     $data = array(
    //         'estatus_fac' => '2'
    //     );
        
    //     $actualizado = $_facturaMedico->where('factura_medico_id', '=', $factura_medico_id)->update($data);
    //     return $this->mensajeActualizaciónExitosa($actualizado);
    // }

    // public function listarFacturaMedico(){

    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //     $id = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
        
    //     return $this->retornarMensaje($id);
    // }

    // public function listarFacturaMedicoPorId($factura_medico_id){
        
    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //     $id = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
    //     return $this->retornarMensaje($id);
    // }

    // public function listarFacturaPorMedico($medico_id){
        
    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //     $id = $_facturaMedicoModel->where('medico.medico_id','=',$medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
    //     return $this->retornarMensaje($id);
    // }

    // public function listarFacturaPorFecha(){
        
    //     $_POST = json_decode(file_get_contents('php://input'), true);
    //     $validarFactura = new Validate;
        
    //     if ( $validarFactura->isDate($_POST['fecha_inicio']) || $validarFactura->isDate($_POST['fecha_fin']) ) {
    //         $respuesta = new Response('FECHA_INVALIDA');
    //         return $respuesta->json(400);

    //     } else {

    //         $_facturaMedicoModel = new FacturaMedicoModel();
    //         $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //         $id = $_facturaMedicoModel->whereDate('factura_medico.fecha_pago',$_POST['fecha_inicio'],$_POST['fecha_fin'])->innerJoin($this->arraySelect, $inners, "factura_medico");
            
    //         return $this->retornarMensaje($id);
    //     }        
    // }

    // public function eliminarFacturaMedico($factura_medico_id){

    //     $header = apache_request_headers();
    //     $token = substr($header['Authorization'], 7) ;
        
    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $_facturaMedicoModel->byUser($token);
    //     $data = array(
    //         'estatus_fac' => '3'
    //     );

    //     $eliminado = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->update($data, 1);
    //     return $this->mensajeActualizaciónExitosa($eliminado);
    // }

    // // Funciones de utilidades
    // public function contabilizarFactura($form) {

    //     // inner con las consultas
    //     $arrayInner = array(
    //         "consulta" => "factura_consulta"
    //     );

    //     $arraySelect = array(
    //         "consulta.consulta_id",
    //         "consulta.fecha_consulta",
    //         "consulta.medico_id",
    //         "factura_consulta.monto_sin_iva"
    //     );

    //     $fecha_actual = $_POST['fecha_actual'];
    //     $fecha_inicio = strtotime('-1 month', strtotime($fecha_actual));
    //     $fecha_inicio = date('Y-m-d', $fecha_inicio);

    //     $_facturaConsultaModel = new FacturaConsultaModel();
    //     $inners = $_facturaConsultaModel->listInner($arrayInner);
    //     $inner = $_facturaConsultaModel->where('consulta.medico_id', '=', $form['medico_id'])->where('consulta.estatus_con','=',1)->where('factura_consulta.estatus_fac','!=',2)->whereDate('consulta.fecha_consulta',$fecha_inicio,$fecha_actual)->innerJoin($arraySelect, $inners, "factura_consulta");
        
    //     $pacientesConsulta = 0;
    //     $montoTotal = 0;

    //     // Si no tiene consultas naturales no se realiza el foreach
    //     if ($inner) {
    //         foreach ($inner as $inners) {
    //             //calculo consultas
    //             $montoTotal += $inners->monto_sin_iva;
    //             $pacientesConsulta += 1;
    //         }
    //     }

    //     $montoConsultas = $montoTotal * 50 / 100;
        

    //     // inner con los seguros
    //     $arrayInnerSeguro = array(
    //         "consulta" => "factura_seguro"
    //     );

    //     $arraySelectSeguro = array(
    //         "consulta.consulta_id",
    //         "consulta.medico_id",
    //         "factura_seguro.fecha_ocurrencia",
    //         "factura_seguro.monto"
    //     );

    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $innersSeguro = $_facturaMedicoModel->listInner($arrayInnerSeguro);
    //     $innerSeguro = $_facturaMedicoModel->where('consulta.medico_id', '=', $form['medico_id'])->where('estatus_con','=',1)->where('estatus_fac','!=',2)->whereDate('factura_seguro.fecha_ocurrencia',$fecha_inicio,$fecha_actual)->innerJoin($arraySelectSeguro, $innersSeguro, "factura_seguro");

    //     $pacientesSeguros = 0;
    //     $montoTotal = 0;

    //     // Si no tiene consultas por seguro no se realiza el foreach

    //     if ($innerSeguro) {
    //         foreach ($innerSeguro as $inners) {
    //             //calculo seguros
    //             $montoTotal += $inners->monto;
    //             $pacientesSeguros += 1;
    //         }
    //     } else{
    //         $montoTotal = 0;
    //         $pacientesSeguros = 0;
    //     }

    //     $montoSeguros = $montoTotal * 20 / 100;
    //     $pagoTotal = $montoConsultas + $montoSeguros;

        

    //     $arrayInsert = array(
    //         'medico_id' => $form['medico_id'],
    //         'acumulado_seguro_total' => $montoSeguros,
    //         'acumulado_consulta_total' => $montoConsultas,
    //         'pago_total' => $pagoTotal,
    //         'pacientes_seguro' => $pacientesSeguros,
    //         'pacientes_consulta' => $pacientesConsulta,
    //         'fecha_pago' => $fecha_actual
    //     );

    //     return $arrayInsert;
    // }

    // public function retornarMensaje($mensaje) {

    //     $bool = ($mensaje > 0);

    //     $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
    //     $respuesta->setData($mensaje);
    //     return $respuesta->json(200);
        
    // }

    // public function mensajeActualizaciónExitosa($update) {
    //     $isTrue = ($update > 0);
    //     $respuesta = new Response($isTrue ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
    //     return $respuesta->json($isTrue ? 200 : 400);
    // }
}
