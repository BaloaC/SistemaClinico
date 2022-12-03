<?php

class PacienteController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('pacientes/index');
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
        $camposString = array("nombres", "apellidos");

        $validarPaciente = new Validate;
        
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

            case $validarPaciente->isDuplicated('paciente', 'cedula', $_POST["cedula"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarPaciente->isDate($_POST['fecha_nacimiento']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarPaciente->isToday($_POST['fecha_nacimiento'], false):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            default: 
            $data = $validarPaciente->dataScape($_POST);
            $_pacienteModel = new PacienteModel();

            if ( $data['tipo_paciente'] != 1 ) {
                
                $newForm = array(
                    'seguro_id' => $data['seguro_id'],
                    'empresa_id' => $data['empresa_id'],
                    'tipo_seguro' => $data['tipo_seguro'],
                    'cobertura_general' => $data['cobertura_general'],
                    'fecha_contra' => $data['fecha_contra'],
                    'saldo_disponible' => $data['saldo_disponible']
                );

                $id = $_pacienteModel->insert($data);
                
                if ( $id > 0 ) {
                    $insertarPacienteSeguro = new PacienteSeguroController;
                    $mensaje = $insertarPacienteSeguro->insertarPacienteSeguro($data);
                    
                    if ($mensaje == true) {
                        return $mensaje;
                    } else {
                      
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }
                }

            } else {
             
                $id = $_pacienteModel->insert($data);
                $mensaje = ($id > 0);
                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
            }
        }
    }

    public function listarPacientes(){

        $arrayInner = array(
            "paciente" => "paciente_seguro",
            "seguro" => "paciente_seguro",
            "empresa" => "paciente_seguro"
        );

        $arraySelect = array(
            "paciente.paciente_id",
            "paciente.cedula",
            "paciente.nombres AS nombre_paciente",
            "paciente.apellidos",
            "paciente.fecha_nacimiento",
            "paciente.edad",
            "paciente.telefono",
            "paciente.direccion",
            "paciente.tipo_paciente",
            "paciente_seguro.tipo_seguro",
            "paciente_seguro.cobertura_general",
            "paciente_seguro.fecha_contra",
            "paciente_seguro.saldo_disponible",
            "empresa.nombre AS nombre_empresa",
            "seguro.nombre AS nombre_seguro"
        );
        $newArray = array();
        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('tipo_paciente','=',1)->getAll();
        
        $_pacienteModel = new PacienteModel();
        $inners = $_pacienteModel->listInner($arrayInner);
        $inner = $_pacienteModel->innerJoin($arraySelect, $inners, "paciente_seguro");
                
        if ( !empty($inner) ) {
            $paciente2 = $inner;    
        }      
        
        $resultado = array_merge($paciente, $paciente2);
        $mensaje = ($resultado != null);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarPacientePorId($paciente_id){
        $arrayInner = array(
            "paciente" => "paciente_seguro",
            "seguro" => "paciente_seguro",
            "empresa" => "paciente_seguro"
        );

        $arraySelect = array(
            "paciente.paciente_id",
            "paciente.cedula",
            "paciente.nombres AS nombre_paciente",
            "paciente.apellidos",
            "paciente.fecha_nacimiento",
            "paciente.edad",
            "paciente.telefono",
            "paciente.direccion",
            "paciente.tipo_paciente",
            "paciente_seguro.tipo_seguro",
            "paciente_seguro.cobertura_general",
            "paciente_seguro.fecha_contra",
            "paciente_seguro.saldo_disponible",
            "empresa.nombre AS nombre_empresa",
            "seguro.nombre AS nombre_seguro"
        );

        $_pacienteModel = new PacienteModel();
        $inners = $_pacienteModel->listInner($arrayInner);
        
        $paciente = $_pacienteModel->where('paciente.paciente_id','=',$paciente_id)->innerJoin($arraySelect, $inners, "paciente_seguro");
        
        $mensaje = ($paciente != null);

        if ( $mensaje ) {
            
            $respuesta = new Response('CORRECTO');
            $respuesta->setData($paciente);
            return $respuesta->json(200);

        } else {

            $_pacienteModel = new PacienteModel();
            $paciente = $_pacienteModel->where('paciente_id','=',$paciente_id)->getFirst();
            
            $mensaje = ($paciente != null);

            $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($paciente);
            return $respuesta->json($mensaje ? 200 : 404);
        }
    }

    public function actualizarPaciente($paciente_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "edad", "telefono", "tipo_paciente");
        $camposString = array("nombres", "apellidos");
        $camposKey = array("paciente_id"); // Esta variable es el array que se pasara por existInDB

        $validarPaciente = new Validate;
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
                
            case $validarPaciente->existsInDB($_POST, $camposKey):   
                $respuesta = new Response('NOT_FOUND');         
                return $respuesta->json(404);

            case array_key_exists('cedula', $_POST):
                if ( $validarPaciente->isDuplicated('paciente', 'cedula', $_POST["cedula"]) ) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);
                }

            case array_key_exists('fecha_nacimiento', $_POST):
                if ( $validarPaciente->isDate($_POST['fecha_nacimiento']) ) {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                }
                
            case array_key_exists('fecha_nacimiento', $_POST):
                if ( $validarPaciente->isToday($_POST['fecha_nacimiento'], false) ) {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                }
            
            default: 
                $data = $validarPaciente->dataScape($_POST);
                $_pacienteModel = new PacienteModel();

                
                
                $actualizado = $_pacienteModel->where('paciente_id','=',$paciente_id)->update($data);
                $mensaje = ($actualizado > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);

                return $respuesta->json($mensaje ? 200 : 400);
            }
    }

    public function eliminarPaciente($paciente_id){

        $_pacienteModel = new PacienteModel();

        $eliminado = $_pacienteModel->where('paciente_id','=',$paciente_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function RetornarID($cedula){

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('cedula','=',$cedula)->getFirst();
        $mensaje = ($paciente != null);
        $respuesta = $mensaje ? $paciente->paciente_id : false;
        return $respuesta;
        
    }

    
    public function RetornarTipo($paciente_id){

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('paciente_id','=',$paciente_id)->getFirst();
        $mensaje = ($paciente != null);
        $respuesta = $mensaje ? $paciente->tipo_paciente : false;
        return $respuesta;
        
    }
}



?>