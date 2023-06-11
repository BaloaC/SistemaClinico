<?php

class PacienteController extends Controller{

    protected $arrayInner = array(
        "seguro" => "paciente_seguro",
        "empresa" => "paciente_seguro"
    );

    protected $arraySelect = array(
        "empresa.nombre AS nombre_empresa",
        "seguro.nombre AS nombre_seguro",
        "seguro.seguro_id",
        "empresa.empresa_id"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('pacientes/index');
    }

    public function historialMedico(){

        return $this->view('pacientes/historialMedico');
    }

    public function formRegistrarPacientes(){

        return $this->view('pacientes/registrarPacientes');
    }

    public function formActualizarPaciente($paciente_id){
        
        return $this->view('pacientes/actualizarPacientes', ['paciente_id' => $paciente_id]);
    } 

    public function insertarPaciente(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "edad", "telefono", "tipo_paciente");
        $camposString = array("nombre", "apellidos");

        $validarPaciente = new Validate;
        $token = $validarPaciente->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        switch($_POST) {
            case ($validarPaciente->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarPaciente->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarPaciente->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarPaciente->isDate($_POST['fecha_nacimiento']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarPaciente->isToday($_POST['fecha_nacimiento'], false):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            default: 
            
            $_pacienteModel = new PacienteModel();

            if ( $_POST['tipo_paciente'] != 4 && $validarPaciente->isDuplicated('paciente', 'cedula', $_POST['cedula']) ) { 
                $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
                $respuesta->setData("Problema al insertar el paciente con la cédula ".$_POST['cedula']);
                return $respuesta->json(400);
            }

            if ( $_POST['tipo_paciente'] == 3 ) {
                
                $pacienteSeguro = $_POST['seguro'];
                unset($_POST['seguro']);

                if ( $validarPaciente->isEmpty($pacienteSeguro) ) {
                    $respuesta = new Response(false, 'Debe introducir los datos de seguro del paciente');
                    return $respuesta->json(400);
                }

                $data = $validarPaciente->dataScape($_POST);
                $id = $_pacienteModel->insert($data);
                $_pacienteModel->byUser($token);
                
                if ( $id > 0 ) {
                    $insertarPacienteSeguro = new PacienteSeguroController;
                    $mensaje = $insertarPacienteSeguro->insertarPacienteSeguro($pacienteSeguro, $id);
                    
                    if ($mensaje == true) { 
                        
                        $_pacienteModel->where('paciente_id', '=', $id)->delete();
                        return $mensaje; 

                    } else {
                      
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }
                }

            } else if( $_POST['tipo_paciente'] == 4 ) {

                $pacienteBeneficiado = $_POST['titular'];
                unset($_POST['titular']);

                if ( $validarPaciente->isEmpty($pacienteBeneficiado) ) {
                    $respuesta = new Response(false, 'Debe introducir los datos del titular del paciente');
                    return $respuesta->json(400);
                }

                $data = $validarPaciente->dataScape($_POST);
                $id = $_pacienteModel->insert($data);
                $_pacienteModel->byUser($token);
                
                if ( $id > 0 ) {
                    $insertarPacienteBeneficiado = new PacienteBeneficiadoController;
                    $mensaje = $insertarPacienteBeneficiado->insertarPacienteBeneficiado($pacienteBeneficiado, $id);
                    
                    if ($mensaje == true) { 
                        $_pacienteModel->where('paciente_id', '=', $id)->delete();
                        return $mensaje; 

                    } else {
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }
                }

            }else {
                
                $data = $validarPaciente->dataScape($_POST);
                $id = $_pacienteModel->insert($data);
                $_pacienteModel->byUser($token);
                $mensaje = ($id > 0);
                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
            }
        }
    }

    public function actualizarPaciente($paciente_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "edad", "telefono", "tipo_paciente");
        $camposString = array("nombres", "apellidos");

        $validarPaciente = new Validate;
        switch($_POST) {

            case ($validarPaciente->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case !$validarPaciente->isDuplicated('paciente', 'paciente_id', $paciente_id):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarPaciente->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarPaciente->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            
            default:
                    
                if ( array_key_exists('fecha_nacimiento', $_POST) ) {

                    if ( $validarPaciente->isDate($_POST['fecha_nacimiento']) ) {
                        $respuesta = new Response('DATOS_INVALIDOS');
                        return $respuesta->json(400);
                    }
                    
                    if ( $validarPaciente->isToday($_POST['fecha_nacimiento'], false) ) {
                        $respuesta = new Response('DATOS_INVALIDOS');
                        return $respuesta->json(400);
                    }   

                }

                if ( !array_key_exists('tipo_paciente', $_POST) && array_key_exists('cedula', $_POST)) {
                    // Primero verificamos si el paciente es tipo beneficiado
                    $_pacienteModel = new PacienteModel();
                    $paciente = $_pacienteModel->where('paciente_id', '=', $paciente_id);
                    $isRepeated = $_pacienteModel->where('cedula', '=', $_POST['cedula']);

                    // Ahora validamos que la cédula no se repita
                    if ($paciente->tipo_paciente != 4 && $isRepeated) {
                        $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
                        $respuesta->setData("Problema al insertar el paciente con la cédula ".$_POST['cedula']);
                        return $respuesta->json(400);
                    }
                    
                }

                if ( array_key_exists('tipo_paciente', $_POST) && array_key_exists('cedula', $_POST) && $_POST['tipo_paciente'] != 4 ) {
                    $_pacienteModel = new PacienteModel();
                    $isRepeated = $_pacienteModel->where('cedula', '=', $_POST['cedula']);
                    if ($isRepeated) {
                        $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
                        $respuesta->setData("Problema al insertar el paciente con la cédula ".$_POST['cedula']);
                        return $respuesta->json(400);
                    }
                }

                if ( array_key_exists('seguro', $_POST) ) {
                    
                    $insertarPacienteSeguro = new PacienteSeguroController;
                    $mensaje = $insertarPacienteSeguro->insertarPacienteSeguro($_POST['seguro'], $paciente_id);
                    unset($_POST['seguro']);
                    if ($mensaje == true) { return $mensaje; }

                }

                if ( !empty($_POST) ) {

                    $data = $validarPaciente->dataScape($_POST);
                    $_pacienteModel = new PacienteModel();
                    
                    $actualizado = $_pacienteModel->where('paciente_id','=',$paciente_id)->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);
                }
        }
    }

    public function listarPacientes(){
        
        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('estatus_pac', '=', '1')->getAll();

        if ($paciente) {
            $resultado = array();

            foreach ($paciente as $pacientes) {
                
                $_medicoModel = new MedicoModel();
                $inners = $_medicoModel->listInner($this->arrayInner);
                $pacienteSeguro = $_medicoModel->where('paciente_seguro.paciente_id','=',$pacientes->paciente_id)->where('paciente_seguro.estatus_pac','=','1')->innerJoin($this->arraySelect, $inners, "paciente_seguro");
                
                if ($pacienteSeguro) { $pacientes->seguro = $pacienteSeguro; }
                $resultado[] = $pacientes;
            }
            return $this->retornarMensaje($resultado);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function listarPacientePorId($paciente_id){
        
        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('estatus_pac', '=', '1')->where('paciente_id', '=', $paciente_id)->getFirst();

        if ($paciente) {

            $_medicoModel = new MedicoModel();
            $inners = $_medicoModel->listInner($this->arrayInner);
            $pacienteSeguro = $_medicoModel->where('paciente_seguro.paciente_id','=',$paciente_id)->where('seguro.estatus_seg','=','1')->where('paciente_seguro.estatus_pac','=','1')->innerJoin($this->arraySelect, $inners, "paciente_seguro");
            
            if ($pacienteSeguro) { $paciente->seguro = $pacienteSeguro; }
            return $this->retornarMensaje($paciente);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function eliminarPaciente($paciente_id){

        $_pacienteModel = new PacienteModel();
        $data = array(
            "estatus_pac" => "2"
        );

        $eliminado = $_pacienteModel->where('paciente_id','=',$paciente_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json(200);
    }
    
    // Funciones
    public function RetornarTipo($paciente_id){

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('paciente_id','=',$paciente_id)->where('estatus_pac', '=', '1')->getFirst();
        $mensaje = ($paciente != null);
        $respuesta = $mensaje ? $paciente->tipo_paciente : false;
        return $respuesta;
        
    }

    public function retornarMensaje($mensaje) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json(200);
    }
}
