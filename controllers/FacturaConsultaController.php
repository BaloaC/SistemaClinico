<?php

class FacturaConsultaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/consulta/index');
    }

    public function formRegistrarFacturaConsulta(){

        return $this->view('facturas/consulta/registrarFacturas');
    }

    public function formActualizarFacturaConsulta($factura_consulta_id){
        
        return $this->view('facturas/consulta/actualizarFacturas', ['factura_consulta_id' => $factura_consulta_id]);
    } 

    public function insertarFacturaConsulta(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        $camposNumericos = array('monto_con_iva','monto_sin_iva');
        $camposId = array('consulta', 'paciente');
        
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
            
                //crear una funcion que verifique que el paciene pertenece a esa consulta
                //crear una funcion que no permita crear dos facturas para la misma consulta

            default:
            
                $data = $validarFactura->dataScape($_POST);
                
                $_facturaConsultaModel = new FacturaConsultaModel();
                $id = $_facturaConsultaModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarFacturaConsulta(){
        // hacer inner para mostrar las fechas, el nombre del paciente, el nombre del medico
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->getAll();
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id){
        // hacer inner para mostrar las fechas, el nombre del paciente, el nombre del medico
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->where('factura_consulta_id', '=', $factura_consulta_id)->getFirst();

        $respuesta = new Response($id ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json($id ? 200 : 404);
    }

    public function eliminarFacturaConsulta($factura_consulta_id){

        $_facturaModel = new FacturaModel();
        $data = array(
            'estatus_fac' => '3'
        );

        $eliminado = $_facturaModel->where('factura_consulta_id','=',$factura_consulta_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}

 

?>