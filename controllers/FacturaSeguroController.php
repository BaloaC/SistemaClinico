<?php

class FacturaSeguroController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/seguros/index');
    }

    public function formRegistrarFacturaSeguro(){

        return $this->view('facturas/seguros/registrarFacturas');
    }

    public function formActualizarFacturaSeguro($factura_seguro_id){
        
        return $this->view('facturas/seguros/actualizarFacturas', ['factura_id' => $factura_seguro_id]);
    } 

    public function insertarFacturaSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        $camposNumericos = array('monto');
        $camposId = array('consulta_id');

        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        switch ($validarFactura) {
            case ($validarFactura->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarFactura->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarFactura->existsInDB($_POST, $camposId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarFactura->isEliminated('consulta', 'consulta_id',$_POST['consulta_id']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);
            
            default:
            
                $data = $validarFactura->dataScape($_POST);
                $consulta_id = $data['consulta_id'];
                
                $_consultaController = new ConsultaController();
                $consultaArray = $_consultaController->listarConsultaPorId($consulta_id);
                $json = json_decode($consultaArray);
                $consulta = $json->data['0'];
                
                // ID para obtener el resto de la información
                $cita = $consulta->cita_id;
                $_citaModel = new CitaModel();
                $citaInfo = $_citaModel->where('cita_id','=',$cita)->getFirst();
                
                //Obtener el nombre del paciente titular por la cita
                $_pacienteModel = new PacienteModel();
                $CItitular = $citaInfo->cedula_titular;
                $pacienteTitular = $_pacienteModel->where('cedula','=',$CItitular)->getFirst();
                
                //Obtener el id del seguro
                $_seguroModel = new SeguroModel();
                $seguroId = $citaInfo->seguro_id;
                // $seguroInfo = $_seguroModel->where('seguro_id','=',$seguroId)->getFirst();

                // sacando el límite de la fecha
                $fecha_limite = strtotime('+30 day', strtotime($consulta->fecha_consulta,));
                $fecha_limite = date('Y-m-d', $fecha_limite);

                $insert = array(
                    'consulta_id' => $data['consulta_id'],
                    'seguro_id' => $seguroId,
                    'tipo_servicio' => $data['tipo_servicio'],
                    'monto' => $data['monto'],
                    'fecha_ocurrencia'=> $consulta->fecha_consulta,
                    'especialidad_id' => $consulta->especialidad_id,
                    'nombre_especialidad' => $consulta->nombre_especialidad,
                    'nombre_paciente' => $consulta->nombre_paciente,
                    'nombre_titular' => $pacienteTitular->nombre,
                    'autorizacion' => $consulta->clave,
                    'fecha_pago_limite' => $fecha_limite
                );
                
                $_facturaSeguroModel = new FacturaSeguroModel();
                $_facturaSeguroModel->byUser($token);
                $id = $_facturaSeguroModel->insert($insert);

                $mensaje = ($id > 0);
                
                if ($mensaje) {
                    
                    // Restando el monto de la factura al saldo disponible del paciente
                    $_pacienteSeguroModel = new PacienteSeguroModel;
                    $paciente = $_pacienteSeguroModel->where('estatus_pac','=',1)->where('paciente_id', '=',$pacienteTitular->paciente_id)->where('seguro_id','=',$seguroId)->getFirst();
                    $saldo = $paciente->saldo_disponible;

                    if ($data['monto'] > $saldo) {
                        $respuesta = new Response('INSUFFICIENT_AMOUNT');
                        return $respuesta->json(400);
                    }

                    $montoActualizado = $saldo - $data['monto'];
                    $update = array('saldo_disponible' => $montoActualizado);
                    
                    $respuesta = $_pacienteSeguroModel->where('paciente_id', '=',$pacienteTitular->paciente_id)->update($update);

                    if (!$respuesta) {
                        $respuesta = new Response(false, 'Hubo un error manipulando el saldo del paciente');
                        return $respuesta->json(400);
                    }

                    $respuesta = new Response('INSERCION_EXITOSA');
                    return $respuesta->json(201);

                } else {

                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarFacturaSeguro(){
        
        $_facturaSeguroModel = new FacturaSeguroModel();
        $id = $_facturaSeguroModel->getAll();
        $mensaje = ($id > 0);
        return $this->retornarMensaje($id, $id);
    }

    public function listarFacturaSeguroPorId($factura_seguro_id){

        $_facturaSeguroModel = new FacturaSeguroModel();
        $id = $_facturaSeguroModel->where('factura_seguro_id', '=', $factura_seguro_id)->getFirst();
        return $this->retornarMensaje($id, $id);
    }

    public function eliminarFacturaSeguro($factura_seguro_id){

        $validarFactura = new Validate;
        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        $_facturaSeguroModel = new FacturaSeguroModel();
        $_facturaSeguroModel->byUser($token);
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_facturaSeguroModel->where('factura_seguro_id','=',$factura_seguro_id)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones
    public function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json($mensaje ? 200 : 404);
    }
}

 

?>