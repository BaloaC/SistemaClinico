<?php

class FacturaMedicoController extends Controller{
    
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

        return $this->view('facturas/medico/index');
    }

    public function formRegistrarFacturaMedico(){

        return $this->view('facturas/medico/registrarFacturas');
    }

    public function formActualizarFacturaMedico($factura_medico_id){
        
        return $this->view('facturas/medico/actualizarFacturas', ['factura_medico_id' => $factura_medico_id]);
    } 

    public function solicitarFacturaMedico(/*Request $request*/){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;

        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        // ** Enrique
        $camposId = array('medico_id');
        
        switch ($validarFactura) {
            case ($validarFactura->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case !($validarFactura->existsInDB($_POST, $camposId)):
                $respuesta = new Response('MD_NOT_FOUND');
                return $respuesta->json(200);

            case $validarFactura->isDate($_POST['fecha_actual']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);
            
            default:
                
                $data = $validarFactura->dataScape($_POST);
                $insert = $this->contabilizarFactura($data);
                
                $_facturaMedicoModel = new FacturaMedicoModel();
                $_facturaMedicoModel->byUser($token);
                $id = $_facturaMedicoModel->insert($insert);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarFacturaMedico(){

        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
        
        return $this->retornarMensaje($id);
    }

    public function listarFacturaMedicoPorId($factura_medico_id){
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
        return $this->retornarMensaje($id);
    }

    public function listarFacturaPorMedico($medico_id){
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->where('medico.medico_id','=',$medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
        return $this->retornarMensaje($id);
    }

    public function listarFacturaPorFecha(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        
        if ( $validarFactura->isDate($_POST['fecha_inicio']) || $validarFactura->isDate($_POST['fecha_fin']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);

        } else {

            $_facturaMedicoModel = new FacturaMedicoModel();
            $inners = $_facturaMedicoModel->listInner($this->arrayInner);
            $id = $_facturaMedicoModel->whereDate('factura_medico.fecha_pago',$_POST['fecha_inicio'],$_POST['fecha_fin'])->innerJoin($this->arraySelect, $inners, "factura_medico");
            
            return $this->retornarMensaje($id);
        }        
    }

    public function eliminarFacturaMedico($factura_medico_id){

        $validarFactura = new Validate;
        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_facturaMedicoModel = new FacturaMedicoModel();
        $_facturaMedicoModel->byUser($token);
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones de utilidades
    public function contabilizarFactura($form) {

        // inner con las consultas
        $arrayInner = array(
            "consulta" => "factura_consulta"
        );

        $arraySelect = array(
            "consulta.consulta_id",
            "consulta.fecha_consulta",
            "consulta.medico_id",
            "factura_consulta.monto_sin_iva"
        );

        $fecha_actual = $_POST['fecha_actual'];
        $fecha_inicio = strtotime('-1 month', strtotime($fecha_actual));
        $fecha_inicio = date('Y-m-d', $fecha_inicio);

        $_facturaConsultaModel = new FacturaConsultaModel();
        $inners = $_facturaConsultaModel->listInner($arrayInner);
        $inner = $_facturaConsultaModel->where('consulta.medico_id', '=', $form['medico_id'])->where('consulta.estatus_con','=',1)->where('factura_consulta.estatus_fac','!=',2)->whereDate('consulta.fecha_consulta',$fecha_inicio,$fecha_actual)->innerJoin($arraySelect, $inners, "factura_consulta");
        
        $pacientesConsulta = 0;
        $montoTotal = 0;

        // Si no tiene consultas naturales no se realiza el foreach
        if ($inner) {
            foreach ($inner as $inners) {
                //calculo consultas
                $montoTotal += $inners->monto_sin_iva;
                $pacientesConsulta += 1;
            }
        }

        $montoConsultas = $montoTotal * 50 / 100;
        

        // inner con los seguros
        $arrayInnerSeguro = array(
            "consulta" => "factura_seguro"
        );

        $arraySelectSeguro = array(
            "consulta.consulta_id",
            "consulta.medico_id",
            "factura_seguro.fecha_ocurrencia",
            "factura_seguro.monto"
        );

        $_facturaMedicoModel = new FacturaMedicoModel();
        $innersSeguro = $_facturaMedicoModel->listInner($arrayInnerSeguro);
        $innerSeguro = $_facturaMedicoModel->where('consulta.medico_id', '=', $form['medico_id'])->where('estatus_con','=',1)->where('estatus_fac','!=',2)->whereDate('factura_seguro.fecha_ocurrencia',$fecha_inicio,$fecha_actual)->innerJoin($arraySelectSeguro, $innersSeguro, "factura_seguro");

        $pacientesSeguros = 0;
        $montoTotal = 0;

        // Si no tiene consultas por seguro no se realiza el foreach

        if ($innerSeguro) {
            foreach ($innerSeguro as $inners) {
                //calculo seguros
                $montoTotal += $inners->monto;
                $pacientesSeguros += 1;
            }
        } else{
            $montoTotal = 0;
            $pacientesSeguros = 0;
        }

        $montoSeguros = $montoTotal * 20 / 100;
        $pagoTotal = $montoConsultas + $montoSeguros;

        

        $arrayInsert = array(
            'medico_id' => $form['medico_id'],
            'acumulado_seguro_total' => $montoSeguros,
            'acumulado_consulta_total' => $montoConsultas,
            'pago_total' => $pagoTotal,
            'pacientes_seguro' => $pacientesSeguros,
            'pacientes_consulta' => $pacientesConsulta,
            'fecha_pago' => $fecha_actual
        );

        return $arrayInsert;
    }

    public function retornarMensaje($mensaje) {

        $bool = ($mensaje > 0);

        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json(200);
        
    }
}
