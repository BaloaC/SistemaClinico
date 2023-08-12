<?php

use PSpell\Config;

include_once "./services/facturas/consulta seguro/ConsultaSeguroValidaciones.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroService.php";

include_once "./services/pacientes/paciente seguro/PacienteSeguroService.php";

class ConsultaSeguroController extends Controller{

    protected $selectConsultas = array(
        "consulta_seguro.consulta_seguro_id",
        "consulta_seguro.consulta_id",
        "consulta_seguro.tipo_servicio",
        "consulta_seguro.fecha_ocurrencia AS fecha_factura",
        "consulta_seguro.monto",
        "consulta_seguro.estatus_con",
        "consulta.observaciones",
        "consulta.fecha_consulta",
        "consulta.es_emergencia"
    );

    protected $innerConsulta = array(
        "consulta" => "consulta_seguro",
    );

    protected $selectCitas = array(
        "consulta_cita.consulta_cita_id",
        "consulta_cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.cedula_titular",
        "cita.tipo_cita",
        "paciente.nombre AS nombre_beneficiado",
        "paciente.cedula AS cedula_beneficiado",
        "paciente.telefono AS telefono_beneficiado",
        "paciente.direccion AS direccion_beneficiado",
        "paciente.fecha_nacimiento AS nacimiento_beneficiado",
        "medico.nombre AS nombre_medico",
        "especialidad.nombre nombre_especialidad"
    );

    protected $innerCita = array(
        "cita" => "consulta_cita",
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/consulta_seguro/index');
    }

    public function formRegistrarConsultaSeguro(){

        return $this->view('facturas/consulta_seguro/registrarFacturas');
    }

    public function formActualizarConsultaSeguro($consulta_seguro_id){

        return $this->view('facturas/consulta_seguro/actualizarFacturas', ['factura_id' => $consulta_seguro_id]);
    }

    public function insertarConsultaSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        ConsultaSeguroValidaciones::validarConsultaSeguro($_POST);        
        
        $validarConsulta = new Validate;
        $data = $validarConsulta->dataScape($_POST);
        $_consultaSeguroModel = new ConsultaSeguroModel();

        // Obtengo la consulta para extraer el paciente y buscarlo en paciente_seguro
        $_consultaCita = new ConsultaCitaModel();
        $consulta = $_consultaCita->where('consulta_id', '=', $data['consulta_id'])->getFirst();

        if ( is_null($consulta) ){
            // Si no es consulta por cita, es consulta por emergencia
            ConsultaSeguroValidaciones::validarConsultaEmergencia($data);
            ConsultaSeguroService::insertarConsultaEmergencia($data);
            ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);

            $respuesta = new Response('INSERCION_EXITOSA');
            return $respuesta->json(201);

        } else {

            $_cita = new CitaModel();
            $cita = $_cita->where('cita_id', '=', $consulta->cita_id)->getFirst();

            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('cedula', '=', $cita->cedula_titular)->getFirst();
            
            $_citaSeguro = new CitaSeguroModel();
            $citaSeguro = $_citaSeguro->where('cita_id', '=', $consulta->cita_id)->getFirst();
            $data['seguro_id'] = $citaSeguro->seguro_id;

            $_pacienteSeguro = new PacienteSeguroModel();
            $pacienteSeguro = $_pacienteSeguro->where('paciente_id', '=', $paciente->paciente_id)->where('seguro_id', '=', $citaSeguro->seguro_id)->getFirst();

            if ($data['monto'] > $pacienteSeguro->saldo_disponible) {
                $respuesta = new Response(false, 'Saldo insuficiente para cubrir la consulta');
                $respuesta->setData("Error al procesar al paciente id $pacienteSeguro->paciente_id con saldo $pacienteSeguro->saldo_disponible");
                return $respuesta->json(400);
            }

            $id = $_consultaSeguroModel->insert($data);
            $mensaje = ($id > 0);

            if (!$mensaje) {
                $respuesta = new Response(false, 'Error insertando la factura de la consulta');
                return $respuesta->json(400);
            }

            // ya insertada la factura, modificamos el estatus de la consulta a pagada
            ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);

            $montoActualizado = $pacienteSeguro->saldo_disponible - $data['monto'];
            PacienteSeguroService::actualizarSaldoPaciente($montoActualizado, $_pacienteSeguro);
        }
    }

    public function listarConsultaSeguro(){

        $_consultaSeguroModel = new ConsultaSeguroModel();

        // Hacemos el inner de la información general
        $innersConsulta = $_consultaSeguroModel->listInner($this->innerConsulta);
        $ConsultasSeguros = $_consultaSeguroModel->innerJoin($this->selectConsultas, $innersConsulta, "consulta_seguro");

        if (count($ConsultasSeguros)) {
            foreach ($ConsultasSeguros as $consulta) {
                $consulta = $this->obtenerInformacion($consulta);
            }

        } else {
            $respuesta = new Response(false, 'No hay consultas por seguros registradas por los momentos');
            return $respuesta->json(200);
        }

        // Comprobamos que haya una lista
        $isExist = count($ConsultasSeguros) > 0;
        $respuesta = new Response($isExist ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($ConsultasSeguros);
        return $respuesta->json(200);
    }

    public function listarConsultaSeguroPorId($consulta_seguro_id){

        $consultasSeguro = json_decode($this->listarConsultaSeguro());
        $factura = array_filter($consultasSeguro->data, fn($consulta) => $consulta->consulta_seguro_id == $consulta_seguro_id);

        $isExist = count($factura) > 0;
        $respuesta = new Response($factura ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($factura);
        return $respuesta->json(200);
    }

    public function eliminarConsultaSeguro($consulta_seguro_id){

        $validarConsulta = new Validate;

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $data = array(
            'estatus_con' => '2'
        );

        $eliminado = $_consultaSeguroModel->where('consulta_seguro_id','=',$consulta_seguro_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Obtenemos la información de las citas
    public function obtenerInformacion($consulta, $id = null) {
        // Extraemos la información con la relación de citas
        $_consultaCita = new ConsultaCitaModel();
        $innersCita = $_consultaCita->listInner($this->innerCita);
        $consultaCita = $_consultaCita->where('consulta_id', '=', $consulta->consulta_id)
                                    ->innerJoin($this->selectCitas, $innersCita, "consulta_cita");
        $consulta->cita = $consultaCita[0];

        // Obtenemos la información del paciente titular
        $_paciente = new PacienteModel();
        $pacienteTitular = $_paciente->where('cedula', '=', $consulta->cita->cedula_titular)->getFirst();
        $consulta->titular = $pacienteTitular;

        $_consultaInsumos = new ConsultaInsumoModel();
        $consultaInsumos = $_consultaInsumos->where('consulta_id', '=', $consulta->consulta_id)->getAll();

        $monto_consulta = 0;
        if ( count($consultaInsumos) > 0) {
            foreach ($consultaInsumos as $insumo) {
                $monto_insumos = 0;
                $_insumo = new InsumoModel();
                $insumos = $_insumo->where('insumo_id', '=', $insumo->insumo_id)->getFirst();
                $insumo->monto_total = $insumo->cantidad * $insumos->precio;
                $insumo->precio = $insumos->precio;
                $monto_insumos += $insumo->monto_total;
                $monto_consulta += $monto_insumos;
            }

            $consulta->insumos = $consultaInsumos;
        }

        $consulta->monto_total = $consulta->monto + $monto_consulta;
        return $consulta;
    }

    // Funciones
    public function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json(200);
    }
}
