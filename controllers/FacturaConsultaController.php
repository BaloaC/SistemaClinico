<?php

class FacturaConsultaController extends Controller
{

    //Método index (vista principal)
    public function index()
    {

        return $this->view('facturas/consulta/index');
    }

    public function formRegistrarFacturaConsulta()
    {

        return $this->view('facturas/consulta/registrarFacturas');
    }

    public function formActualizarFacturaConsulta($factura_consulta_id)
    {

        return $this->view('facturas/consulta/actualizarFacturas', ['factura_consulta_id' => $factura_consulta_id]);
    }

    public function insertarFacturaConsulta(/*Request $request*/)
    {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        $camposNumericos = array('monto_sin_iva');
        $camposId = array('consulta_id', 'paciente_id');

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
                return $respuesta->json(200);

            case $validarFactura->isEliminated('consulta', 'consulta_id', $_POST['consulta_id']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case $validarFactura->isDuplicatedId('paciente_id', 'consulta_id', $_POST['consulta_id'], $_POST['paciente_id'], 'consulta'):
                $respuesta = new Response(false, 'La consulta indicada no coincide con el paciente ingresado');
                return $respuesta->json(400);

            case $validarFactura->isDuplicated('factura_consulta', 'consulta_id', $_POST['consulta_id']):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:

                $data = $validarFactura->dataScape($_POST);

                $_facturaConsultaModel = new FacturaConsultaModel();
                $_facturaConsultaModel->byUser($token);
                $id = $_facturaConsultaModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarFacturaConsulta()
    {
        // hacer inner para mostrar las fechas, el nombre del paciente, el nombre del medico
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->getAll();
        $mensaje = ($id > 0);
        return $this->RetornarMensaje($mensaje, $id);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id)
    {
        // hacer inner para mostrar las fechas, el nombre del paciente, el nombre del medico
        $_facturaConsultaModel = new FacturaConsultaModel();
        $id = $_facturaConsultaModel->where('factura_consulta_id', '=', $factura_consulta_id)->getFirst();
        return $this->RetornarMensaje($id, $id);
    }

    public function eliminarFacturaConsulta($factura_consulta_id)
    {

        $validarFactura = new Validate;
        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_facturaModel = new FacturaConsultaModel();
        $_facturaModel->byUser($token);
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_facturaModel->where('factura_consulta_id', '=', $factura_consulta_id)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones
    public function RetornarMensaje($mensaje, $data)
    {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        return $respuesta->json(200);
    }
}
