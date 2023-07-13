<?php

class FacturaConsultaController extends Controller {

    protected $selectConsulta = array(
        "factura_consulta.factura_consulta_id",
        "factura_consulta.consulta_id",
        "factura_consulta.metodo_pago",
        "factura_consulta.monto_consulta",
        "factura_consulta.estatus_fac",
        "consulta.fecha_consulta",
        "consulta.es_emergencia"
    );
    
    protected $innerConsulta = array("consulta" => "factura_consulta");

    protected $selectGeneral = array(
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos",
        "paciente.cedula",
        "paciente.direccion",
        "especialidad.nombre AS nombre_especialidad",
        "medico.nombre AS nombre_medico"
    );

    protected $selectConsultaSinCita = array(
        "consulta_sin_cita.paciente_id",
        "consulta_sin_cita.especialidad_id",
        "consulta_sin_cita.medico_id",
    );

    protected $innerConsultaSinCita = array(
        "paciente" => "consulta_sin_cita",
        "especialidad" => "consulta_sin_cita",
        "medico" => "consulta_sin_cita"
    );

    protected $selectConsultaCita = array(
        "consulta_cita.cita_id",
        "cita.paciente_id",
        "cita.especialidad_id",
        "cita.medico_id",
    );

    protected $innerConsultaCita = array(
        "cita" => "consulta_cita",
        "paciente" => "cita",
        "especialidad" => "cita",
        "medico" => "cita"
    );


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

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        $camposNumericos = array('monto_consulta');
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

            // case !$validarFactura->isDuplicatedId('paciente_id', 'consulta_id', $_POST['consulta_id'], $_POST['paciente_id'], 'consulta'):
            //     $respuesta = new Response(false, 'La consulta indicada no coincide con el paciente ingresado');
            //     return $respuesta->json(400);

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

    public function listarFacturaConsulta() {
        
        // Obtenemos todas las facturas
        $_facturaConsulta = new FacturaConsultaModel();
        $innersConsulta = $_facturaConsulta->listInner($this->innerConsulta);

        if ( array_key_exists('date', $_GET) ) {
            
            $fecha_mes = DateTime::createFromFormat('Y-m-d', $_GET['date']);
            $fecha_mes->modify('first day of this month');
            $fecha_inicio = $fecha_mes->format("Y-m-d");
            
            $fecha_mes->modify('last day of this month');
            $fecha_fin = $fecha_mes->format("Y-m-d");
            
            $facturasList = $_facturaConsulta->whereDate('fecha_consulta', $fecha_inicio, $fecha_fin)
                                                ->innerJoin($this->selectConsulta, $innersConsulta, "factura_consulta");

        } else {
            $facturasList = $_facturaConsulta->innerJoin($this->selectConsulta, $innersConsulta, "factura_consulta");
        }
        
        // Hacemos inner para obtener los datos de las consultas
        $consultaList = [];
        
        foreach ($facturasList as $factura) {
            $consultaList[] = $this->obtenerInformacion($factura);
        }
        
        $mensaje = ( count($consultaList) > 0);
        return $this->RetornarMensaje($mensaje, $consultaList);
    }

    public function listarFacturaConsultaPorId($factura_consulta_id) {

        // Obtenemos todas las facturas
        $_facturaConsulta = new FacturaConsultaModel();
        $innersConsulta = $_facturaConsulta->listInner($this->innerConsulta);
        $factura = $_facturaConsulta->where('factura_consulta_id', '=', $factura_consulta_id)
                                        ->innerJoin($this->selectConsulta, $innersConsulta, "factura_consulta");
        
        $factura = (object) $factura[0];

        // Hacemos inner para obtener los datos de las consultas
        $consultaList = $this->obtenerInformacion($factura);
        $mensaje = ( count($consultaList) > 0);
        return $this->RetornarMensaje($mensaje, $consultaList);
    }

    // public function eliminarFacturaConsulta($factura_consulta_id) {

    //     $validarFactura = new Validate;
    //     $token = $validarFactura->validateToken(apache_request_headers());
    //     if (!$token) {
    //         $respuesta = new Response('TOKEN_INVALID');
    //         return $respuesta->json(401);
    //     }

    //     $_facturaModel = new FacturaConsultaModel();
    //     $_facturaModel->byUser($token);
    //     $data = array(
    //         'estatus_fac' => '3'
    //     );

    //     $eliminado = $_facturaModel->where('factura_consulta_id', '=', $factura_consulta_id)->update($data, 1);
    //     $mensaje = ($eliminado > 0);

    //     $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
    //     $respuesta->setData($eliminado);

    //     return $respuesta->json($mensaje ? 200 : 400);
    // }

    public function obtenerInformacion($factura) {

        $_consultaCita = new ConsultaCitaModel();
        $innerConsultaCita = $_consultaCita->listInner( $this->innerConsultaCita );
        $consulta = $_consultaCita->where('consulta_cita.consulta_id', '=',$factura->consulta_id)
                                    ->where('cita.tipo_cita', '=', 1)                        
                                    ->innerJoin( array_merge($this->selectConsultaCita, $this->selectGeneral), $innerConsultaCita, 'consulta_cita');
        
        // Si la consulta no es por cita, buscamos las que son sin cita
        if ( is_null($consulta) || count($consulta) <= 0 ) {
            $_consultaSinCita = new ConsultaSinCitaModel();
            $innerConsultaSinCita = $_consultaSinCita->listInner( $this->innerConsultaSinCita );
            $consulta = $_consultaSinCita->where('consulta_id', '=',$factura->consulta_id)
                                            ->innerJoin( array_merge($this->selectConsultaSinCita, $this->selectGeneral) , $innerConsultaSinCita, 'consulta_sin_cita');
        }


        if ( isset($consulta[0]) ) {
            $consulta = array_merge( (array) $consulta[0],  (array) $factura);
        } else {
            $consulta = array_merge( (array) $consulta,  (array) $factura);
        }

        $_consultaInsumo = new ConsultaInsumoModel();
        $consultaInsumos = $_consultaInsumo->where('consulta_id', '=', $factura->consulta_id)
                                    ->where('estatus_con', '!=', '2')
                                    ->getAll();

        // Revisamos si tienes insumos asociados
        if ( count($consultaInsumos) > 0 ) {
            $monto = $factura->monto_consulta;

            foreach ($consultaInsumos as $consulta_insumo) {
                
                $_insumoModel = new InsumoModel();
                $insumo = $_insumoModel->where('insumo_id', '=', $consulta_insumo->insumo_id)->getFirst();
                $consulta_insumo->precio_insumo = $insumo->precio;
                $consulta_insumo->monto_total = $consulta_insumo->cantidad * $insumo->precio;
                $monto += $consulta_insumo->monto_total;
            }
            
            $consulta['monto_consulta'] = $monto;
            $consulta['insumos'] = $consultaInsumos;
        }

        $consultaList[] = $consulta;
        return $consultaList[0];
    }

    // Funciones
    public function RetornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        return $respuesta->json(200);
    }
}
