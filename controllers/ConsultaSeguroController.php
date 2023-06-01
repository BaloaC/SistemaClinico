<?php

class ConsultaSeguroController extends Controller{

    protected $arrayInner = array(
        "consulta" => "consulta_seguro",
        "paciente" => "consulta",
        "especialidad" => "consulta",
        "cita" => "consulta"
    );

    protected $arraySelect = array(
        "cita.cita_id",
        "consulta.consulta_id",
        "consulta.fecha_consulta",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "consulta_seguro.consulta_seguro_id",
        "consulta_seguro.tipo_servicio",
        "consulta_seguro.fecha_ocurrencia",
        "consulta_seguro.monto",
        "consulta_seguro.estatus_con",
        "paciente.paciente_id",
        "paciente.cedula AS paciente_cedula",
        "paciente.apellidos AS paciente_apellido",
        "paciente.nombre AS paciente_nombre",
        "cita.cedula_titular"
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

            // case !$validarConsulta->existsInDB($_POST, $camposId):
            //     $respuesta = new Response('NOT_FOUND');
            //     return $respuesta->json(200);

            case $validarConsulta->isDuplicated('consulta', 'estatus_con', '3'):
                $respuesta = new Response(false, 'Esa consulta ya está relacionada a una factura');
                return $respuesta->json(400);
            
            default:
            
                $data = $validarConsulta->dataScape($_POST);
                $_consultaSeguroModel = new ConsultaSeguroModel();

                // Obtengo la consulta para extraer el paciente y buscarlo en paciente_seguro
                $_consulta = new ConsultaModel();
                $consulta = $_consulta->where('consulta_id', '=', $data['consulta_id'])->getFirst();
                $_paciente = new PacienteSeguroModel();
                $paciente = $_paciente->where('paciente_id', '=', $consulta->paciente_id)->getFirst();
                
                if ($data['monto'] > $paciente->saldo_disponible) {
                    $respuesta = new Response(false, 'Saldo insuficiente para cubrir la consulta');
                    $respuesta->setData("Error al procesar al paciente id $paciente->paciente_id con saldo $paciente->saldo_disponible");
                    return $respuesta->json(400);
                }

                // Obtengo la cita para insertar el seguro
                $_cita = new CitaModel();
                $cita = $_cita->where('cita_id', '=', $consulta->cita_id)->getFirst();
                $data['seguro_id'] = $cita->seguro_id;

                // Insertamos la consulta_seguro
                $header = apache_request_headers();
                $token = substr($header['Authorization'], 7) ;
                $_consultaSeguroModel->byUser($token);
                $id = $_consultaSeguroModel->insert($data);
                $mensaje = ($id > 0);

                // ya insertada la factura, modificamos el estatus de la consulta a pagada
                $update = $_consulta->update(['estatus_con' => 3]);
                $isUpdate = ($update > 0);

                if (!$isUpdate) {
                    // Si hubo un error cambiando el estatus de la consulta, borramos la factura relacionada a ella
                    $_consultaSeguroModel = new ConsultaSeguroModel();
                    $_consultaSeguroModel->where('consulta_seguro_id', '=', $id)->delete();

                    $respuesta = new Response(false, 'Hubo un error actualizando el estatus de la consulta');
                    $respuesta->setData('Error al colocar la consulta' + $data['consulta_id'] + 'como cancelada');
                    return $respuesta->json(400);
                }

                if ($mensaje) {
                    
                    $montoActualizado = $paciente->saldo_disponible - $data['monto'];
                    $respuesta = $_paciente->update([ 'saldo_disponible' => $montoActualizado ]);
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
        $inners = $_consultaSeguroModel->listInner($this->arrayInner);
        $ConsultasSeguros = $_consultaSeguroModel
            ->where('consulta.estatus_con', '=', '1')->where('especialidad.estatus_esp', '=', '1')
            ->where('paciente.estatus_pac', '=', '1')->where('consulta_seguro.estatus_con', '!=', '3')
            ->innerJoin($this->arraySelect, $inners, "consulta_seguro");
        $consultaSeguroList = [];
        
        if (count($ConsultasSeguros)) {
            foreach ($ConsultasSeguros as $consultaSeguro) {
                $_citaModel = new CitaModel();
                $cita = $_citaModel->where("cita_id", "=", $consultaSeguro->cita_id)->where("estatus_cit", "!=", "2")->getFirst();
    
                $_pacienteModel = new PacienteModel();
                $titular = $_pacienteModel->where("cedula", "=", $consultaSeguro->cedula_titular)
                    ->where("estatus_pac", "!=", "2")
                    ->where("tipo_paciente", "=", "3")->getFirst();
                
                $consultaSeguro->nombre_titular = $titular->nombre;
                $consultaSeguro->apellido_titular = $titular->apellidos;
                $consultaSeguro->id_titular = $titular->paciente_id;
                $consultaSeguroList[] = $consultaSeguro;
            }

        } else {
            $respuesta = new Response(false, 'No hay consultas por seguros registradas por los momentos');
            return $respuesta->json(200);
        }

        if (count($consultaSeguroList) > 0) {    
            $respuesta = new Response('CORRECTO');
            $respuesta->setData($consultaSeguroList);
            return $respuesta->json(200);
        
        } else {
            $respuesta = new Response('ERROR');
            $respuesta->setData($consultaSeguroList);
            return $respuesta->json(400);
        }
    }

    public function listarConsultaSeguroPorId($consulta_seguro_id){

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $id = $_consultaSeguroModel->where('consulta_seguro_id', '=', $consulta_seguro_id)->getFirst();
        return $this->retornarMensaje($id, $id);
    }

    public function eliminarConsultaSeguro($consulta_seguro_id){

        $validarConsulta = new Validate;
        $token = $validarConsulta->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        $_consultaSeguroModel = new ConsultaSeguroModel();
        $_consultaSeguroModel->byUser($token);
        $data = array(
            'estatus_con' => '2'
        );

        $eliminado = $_consultaSeguroModel->where('consulta_seguro_id','=',$consulta_seguro_id)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones
    public function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json(200);
    }
}
