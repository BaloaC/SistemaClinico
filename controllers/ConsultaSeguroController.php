<?php

use PSpell\Config;

include_once "./services/facturas/consulta seguro/ConsultaSeguroValidaciones.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroService.php";
include_once "./services/pacientes/paciente seguro/PacienteSeguroService.php";
include_once "./services/globals/GlobalsHelpers.php";

class ConsultaSeguroController extends Controller{

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
        global $isEnabledAudit;
        $isEnabledAudit = 'recibo de consulta asegurada';

        $_POST = json_decode(file_get_contents('php://input'), true);
        ConsultaSeguroValidaciones::validarConsultaSeguro($_POST);
        ConsultaSeguroValidaciones::validarConsultaAsegurada($_POST);
        
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
            // ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);

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
            
            if ($data['monto_consulta_usd'] > $pacienteSeguro->saldo_disponible) {
                $respuesta = new Response(false, 'Saldo insuficiente para cubrir la consulta');
                $respuesta->setData("Error al procesar al paciente id $pacienteSeguro->paciente_id con saldo $pacienteSeguro->saldo_disponible");
                return $respuesta->json(400);
            }

            $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
            // $data['monto_consulta_bs'] = $data['monto_consulta_usd'] * $valorDivisa;
            $data['monto_consulta_bs'] = 0;
            $id = $_consultaSeguroModel->insert($data);
            $data['factura_id'];
            $mensaje = ($id > 0);

            if (!$mensaje) {
                $respuesta = new Response(false, 'Error insertando la factura de la consulta');
                return $respuesta->json(400);
            }

            // ya insertada la factura, modificamos el estatus de la consulta a pagada
            ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);

            $montoActualizado = $pacienteSeguro->saldo_disponible - $data['monto_consulta_usd'];
            PacienteSeguroService::actualizarSaldoPaciente($montoActualizado, $_pacienteSeguro);
        }
    }

    public function listarConsultaSeguro(){

        $consultasSeguros = ConsultaSeguroService::listarconsultasSeguros();

        // Comprobamos que haya una lista
        $hayResultados = count($consultasSeguros) > 0;

        $respuesta = new Response($hayResultados ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($consultasSeguros);
        return $respuesta->json(200);
    }

    public function listarConsultaSeguroPorId($consulta_seguro_id){

        $factura = ConsultaSeguroService::listarConsultasSeguroId($consulta_seguro_id);
        $siExiste = count($factura) > 0;
        $respuesta = new Response($siExiste ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($factura[0]);
        return $respuesta->json(200);
    }

    public function listarConsultaSeguroPorSeguro($seguro_id) {
        $factura = ConsultaSeguroService::listarConsultasSeguroPorSeguro($seguro_id);
        $siExiste = count($factura) > 0;
        $respuesta = new Response($siExiste ? 'CORRECTO' : 'ERROR');
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
}
