<?php

use PSpell\Config;

include_once "./services/facturas/consulta seguro/ConsultaSeguroValidaciones.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroService.php";
include_once "./services/pacientes/paciente seguro/PacienteSeguroService.php";
include_once "./services/globals/GlobalsHelpers.php";
include_once './services/Helpers.php';

class ConsultaSeguroController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/consulta_seguro/index');
    }

    public function getAllConsultasSeguro() {
        return $this->view('consulta-seguro/index');
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

            // $_pacienteSeguro = new PacienteSeguroModel();
            // $pacienteSeguro = $_pacienteSeguro->where('paciente_id', '=', $paciente->paciente_id)->where('seguro_id', '=', $citaSeguro->seguro_id)->getFirst();

            // if ($data['monto_consulta_usd'] > $pacienteSeguro->saldo_disponible) {
            //     $respuesta = new Response(false, 'Saldo insuficiente para cubrir la consulta');
            //     $respuesta->setData("Error al procesar al paciente id $pacienteSeguro->paciente_id con saldo $pacienteSeguro->saldo_disponible");
            //     return $respuesta->json(400);
            // }

            $data['monto_consulta_bs'] = 0;
            if ($cita->tipo_servicio == 1) {
                $data['monto_consulta_usd'] = 0;
            }

            $data['cobertura_seguro'] = $cita->monto_aprobado;

            $id = $_consultaSeguroModel->insert($data);
            $data['factura_id'] = $id;
            $mensaje = ($id > 0);

            if (!$mensaje) {
                $respuesta = new Response(false, 'Error insertando la factura de la consulta');
                return $respuesta->json(400);
            }

            // ya insertada la factura, modificamos el estatus de la consulta a pagada
            $Consulta = new stdClass();
            $Consulta->consulta_id = $data['consulta_id'];
            $lista_test = array( $Consulta );

            $consulta = ConsultaSeguroHelpers::obtenerInformacionCompleta($lista_test);
            if ( isset( $consulta['consulta_emergencia'] ) ) {
                $consulta = $consulta[0];

            } else {
                $consulta[0]['monto_consulta_usd'] = $_POST['monto_consulta_usd'];
                $consulta = array_merge($consulta[0], FacturaConsultaHelpers::obtenerMontoTotal($consulta[0]));
            }

            $_consultaCitaModel = new ConsultaCitaModel();

            $consulta_cita = $_consultaCitaModel->where('consulta_id', '=', $consulta['consulta_id'])->getFirst();
            if ( !is_null($consulta_cita) ) {
                $_citaModel = new CitaModel();
                $cita = $_citaModel->where('cita_id', '=', $consulta_cita->cita_id)->getFirst();

                if ( !is_null($cita) ) {
                    $estatus = $consulta['monto_total_usd'] > $cita->monto_aprobado ? 4 : 3;
                }
            } else {
                $estatus = 3;
            }

            ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id'], $estatus);
            $respuesta = new Response('CORRECTO');
            $respuesta->setData($data);
            return $respuesta->json(200);

            // $montoActualizado = $pacienteSeguro->saldo_disponible - $data['monto_consulta_usd'];
            // PacienteSeguroService::actualizarSaldoPaciente($montoActualizado, $_pacienteSeguro);
        }
    }

    public function listarConsultaSeguro(){

        $_consultaSeguroModel = new ConsultaSeguroModel();

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {

                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_consultaSeguroModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_consultaSeguroModel->where('CONCAT(consulta_id, consulta_seguro_id)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_consultaSeguroModel->where('CONCAT(consulta_id, consulta_seguro_id)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $consultasSeguros = $_consultaSeguroModel->where('estatus_con', '!=', 2)->getAll();
        $consultas_seguros = ConsultaSeguroService::listarconsultasSeguros($consultasSeguros);
        $_consultaSeguroModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_consultaSeguroModel->setSelect('COUNT(*) AS total')->where('CONCAT(consulta_id, consulta_seguro_id)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_consultaSeguroModel->setSelect('COUNT(*) AS total')->where('CONCAT(consulta_id, consulta_seguro_id)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_consultaSeguroModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_consultaSeguroModel->setSelect('COUNT(*) AS total');
        }

        // if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
        //     $_consultaSeguroModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        // } else {
        //     $_consultaSeguroModel->setSelect('COUNT(*) AS total');
        // }

        $total_registros = $_consultaSeguroModel->where('estatus_con', '!=', '2')->getAll();
        // Comprobamos que haya una lista
        $hayResultados = count($consultasSeguros) > 0;
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $consultasSeguros);
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

    public function listarConsultaSeguroPorPaciente($paciente_id) {

        $_citaModel = new CitaModel();
        $citas = $_citaModel->where('paciente_id', '=', $paciente_id)->where('estatus_cit','!=', 2)->where('tipo_cita', '=', 2)->getAll();
        $consultas_citas = [];
        
        if (!is_null($citas)) {
            foreach ($citas as $cita) {
                
                $_consultaCitaModel = new ConsultaCitaModel();
                $inners = $_consultaCitaModel->listInner(['consulta' => 'consulta_cita'], ['consulta_seguro', 'consulta', 'consulta'], false);
                $select = ['consulta.consulta_id', 'consulta_seguro.consulta_seguro_id'];
                $consulta_cita = $_consultaCitaModel->where('consulta_cita.cita_id', '=', $cita->cita_id)
                                                    ->where('consulta.estatus_con', '=', 4)
                                                    ->innerJoin($select, $inners, 'consulta_cita');
                                                    
                if (!is_null($consulta_cita) && count($consulta_cita) > 0) {
                    $consultas_citas[] = $consulta_cita[0];
                }
            }

            $_consultaEmergenciaModel = new ConsultaEmergenciaModel();
            $consultas_emergencias = $_consultaEmergenciaModel->where('paciente_id', '=', $paciente_id)->getAll();
            $consultas_citas = array_merge($consultas_emergencias, $consultas_citas);
            
            if (count($consultas_citas) > 0) {
                $consultas_seguros = ConsultaSeguroHelpers::obtenerInformacionCompleta($consultas_citas);
                $factura = FacturaConsultaHelpers::obtenerMontoTotal($consultas_seguros[0]);
                Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($consultas_seguros), $factura);
            } else {

                $respuesta = new Response(false, 'El paciente seleccionado no tiene consultas aseguradas facturadas');
                echo $respuesta->json(400);
                exit();    
            }

        } else {
            $respuesta = new Response(false, 'El paciente seleccionado no tiene consultas aseguradas facturadas');
            echo $respuesta->json(400);
            exit();
        }
    }

    public function listarConsultaSeguroPorConsulta($consulta_id) {
        $factura = ConsultaSeguroService::listarConsultaSeguroPorConsultaId($consulta_id);
        $siExiste = count($factura) > 0;
        $respuesta = new Response($siExiste ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($factura[0]);
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
