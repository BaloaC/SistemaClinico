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
        $camposId = array('consulta');
        
        switch ($validarFactura) {
            case ($validarFactura->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarFactura->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarFactura->existsInDB($_POST, $camposId):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

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
                $seguroId = $citaInfo->cedula_titular;
                $seguroInfo = $_seguroModel->where('seguro_id','=',$seguroId)->getFirst();

                // sacando el límite de la fecha
                $fecha_limite = strtotime('+30 day', strtotime($consulta->fecha_consulta,));
                $fecha_limite = date('Y-m-d', $fecha_limite);

                $insert = array(
                    'consulta_id' => $data['consulta_id'],
                    'seguro_id' => $seguroInfo,
                    'tipo_servicio' => $data['tipo_servicio'],
                    'monto' => $data['monto'],
                    'fecha_ocurrencia'=> $consulta->fecha_consulta,
                    'especialidad_id' => $consulta->especialidad_id,
                    'nombre_especialidad' => $consulta->nombre_especialidad,
                    'nombre_paciente' => $consulta->nombre_paciente,
                    'nombre_titular' => $pacienteTitular->nombres,
                    'autorizacion' => $consulta->clave,
                    'fecha_pago_limite' => $fecha_limite
                );
                
                $_facturaSeguroModel = new FacturaSeguroModel();
                $id = $_facturaSeguroModel->insert($insert);
                $mensaje = ($id > 0);
                
                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarFacturaSeguro(){
        
        $_facturaSeguroModel = new FacturaSeguroModel();
        $id = $_facturaSeguroModel->getAll();
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarFacturaSeguroPorId($factura_seguro_id){

        $_facturaSeguroModel = new FacturaSeguroModel();
        $id = $_facturaSeguroModel->where('factura_seguro_id', '=', $factura_seguro_id)->getFirst();

        $respuesta = new Response($id ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json($id ? 200 : 404);
    }

    public function eliminarFacturaSeguro($factura_seguro_id){

        $_facturaModel = new FacturaModel();
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_facturaModel->where('factura_seguro_id','=',$factura_seguro_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}

 

?>