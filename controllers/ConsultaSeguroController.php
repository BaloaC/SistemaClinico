<?php

use PSpell\Config;

include_once "./services/facturas/consulta seguro/ConsultaSeguroValidaciones.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroService.php";

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
        $validarConsulta = new Validate;
        $camposNumericos = array('monto');
        $camposId = array('consulta_id');
        
        switch ($validarConsulta) {
            case ($validarConsulta->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarConsulta->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarConsulta->existsInDB($_POST, $camposId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case $validarConsulta->isDuplicated('consulta', 'estatus_con', '3'):
                $respuesta = new Response(false, 'Esa consulta ya está relacionada a una factura');
                return $respuesta->json(400);
            
            default:
            
                $data = $validarConsulta->dataScape($_POST);
                $_consultaSeguroModel = new ConsultaSeguroModel();

                // Obtengo la consulta para extraer el paciente y buscarlo en paciente_seguro
                $_consultaCita = new ConsultaCitaModel();
                $consulta = $_consultaCita->where('consulta_id', '=', $data['consulta_id'])->getFirst();
                
                if ( is_null($consulta) ){

                    ConsultaSeguroValidaciones::validarConsultaEmergencia($data);
                    ConsultaSeguroService::insertarConsultaEmergencia($data);
                    ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);
                    
                    $respuesta = new Response('INSERCION_EXITOSA');
                    return $respuesta->json(201);

                } else if ( count($consulta) > 0 ) {

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

                    // ya insertada la factura, modificamos el estatus de la consulta a pagada
                    ConsultaSeguroService::actualizarEstatusConsulta($data['consulta_id']);
                    // $_consulta = new ConsultaModel();
                    // $update = $_consulta->where('consulta_id','=',$data['consulta_id']  )->update(['estatus_con' => 3]);
                    // $isUpdate = ($update > 0);

                    // if (!$isUpdate) {
                    //     // Si hubo un error cambiando el estatus de la consulta, borramos la factura relacionada a ella
                    //     $_consultaSeguroModel = new ConsultaSeguroModel();
                    //     $_consultaSeguroModel->where('consulta_seguro_id', '=', $id)->delete();

                    //     $respuesta = new Response(false, 'Hubo un error actualizando el estatus de la consulta');
                    //     $respuesta->setData('Error al colocar la consulta id '.$data['consulta_id'].' como cancelada');
                    //     return $respuesta->json(400);
                    // }
                    
                    if ($mensaje) {
                        
                        $montoActualizado = $pacienteSeguro->saldo_disponible - $data['monto'];
                        $respuesta = $_pacienteSeguro->update([ 'saldo_disponible' => $montoActualizado ]);
                        if (!$respuesta) {
                            $respuesta = new Response(false, 'Hubo un error manipulando el saldo del paciente');
                            $respuesta->setData('Error al procesar al paciente id ' + $paciente->paciente_id + 'con saldo ' + $paciente->saldo_disponible);
                            return $respuesta->json(400);
                        }

                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);

                    } else {
                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json(400);
                    }

                }
                
                // Restando el monto de la factura al saldo disponible del paciente
                
                //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
                // $consulta_id = $data['consulta_id'];
                
                // $_consultaController = new ConsultaController();
                // $consultaArray = $_consultaController->listarConsultaPorId($consulta_id);
                // $json = json_decode($consultaArray);
                // $consulta = $json->data['0'];
                
                
                // validando que el paciente sea asegurado
                // if (!$validarConsulta->isDuplicated('paciente_seguro', 'paciente_id', $consulta->paciente_id)) {
                //     $respuesta = new Response(false, 'El paciente de la consulta no es asegurado');
                //     return $respuesta->json(400);
                // }

                // ID para obtener el resto de la información
                // $cita = $consulta->cita_id;
                // $_citaModel = new CitaModel();
                // $citaInfo = $_citaModel->where('cita_id','=',$cita)->getFirst();
                
                // //Obtener el nombre del paciente titular por la cita
                // $_pacienteModel = new PacienteModel();
                // $CItitular = $citaInfo->cedula_titular;
                // $pacienteTitular = $_pacienteModel->where('cedula','=',$CItitular)->getFirst();
                
                // //Obtener el id del seguro
                // $_seguroModel = new SeguroModel();
                // $seguroId = $citaInfo->seguro_id;
                // // $seguroInfo = $_seguroModel->where('seguro_id','=',$seguroId)->getFirst();

                // // sacando el límite de la fecha
                // $fecha_limite = strtotime('+30 day', strtotime($consulta->fecha_consulta,));
                // $fecha_limite = date('Y-m-d', $fecha_limite);

                // $insert = array(
                //     'consulta_id' => $data['consulta_id'],
                //     'seguro_id' => $seguroId,
                //     'tipo_servicio' => $data['tipo_servicio'],
                //     'monto' => $data['monto'],
                //     'fecha_ocurrencia'=> $consulta->fecha_consulta,
                //     'especialidad_id' => $consulta->especialidad_id,
                //     'nombre_especialidad' => $consulta->nombre_especialidad,
                //     'nombre_paciente' => $consulta->nombre_paciente,
                //     'nombre_titular' => $pacienteTitular->nombre,
                //     'autorizacion' => $consulta->clave,
                //     'fecha_pago_limite' => $fecha_limite
                // );
                
                // // validando que el paciente pueda cubrir el saldo
                // $_pacienteSeguroModel = new PacienteSeguroModel;
                // $paciente = $_pacienteSeguroModel->where('estatus_pac','=',1)->where('paciente_id', '=',$pacienteTitular->paciente_id)->where('seguro_id','=',$seguroId)->getFirst();
                // $saldo = isset($paciente->saldo_disponible) ? $paciente->saldo_disponible : 0;
                
                // if ($data['monto'] > $saldo) {
                //     $respuesta = new Response('INSUFFICIENT_AMOUNT');
                //     return $respuesta->json(400);
                // }

                // $_consultaSeguroModel = new ConsultaSeguroModel();
                // $_consultaSeguroModel->byUser($token);
                // $id = $_consultaSeguroModel->insert($insert);

                // $mensaje = ($id > 0);
                
                // if ($mensaje) {
                    
                //     // Restando el monto de la factura al saldo disponible del paciente
                //     $montoActualizado = $saldo - $data['monto'];
                //     $update = array('saldo_disponible' => $montoActualizado);
                //     $respuesta = $_pacienteSeguroModel->where('paciente_id', '=',$pacienteTitular->paciente_id)->update($update);

                //     if (!$respuesta) {
                //         $respuesta = new Response(false, 'Hubo un error manipulando el saldo del paciente');
                //         return $respuesta->json(400);
                //     }

                //     $respuesta = new Response('INSERCION_EXITOSA');
                //     return $respuesta->json(201);

                // } else {

                //     $respuesta = new Response('INSERCION_FALLIDA');
                //     return $respuesta->json(400);
                // }
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
