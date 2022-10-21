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
        var_dump($_POST);

        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "edad", "telefono");
        $camposString = array("nombres", "apellidos");

        $validarPaciente = new Validate;
        
        switch($_POST) {
            case ($validarPaciente->isEmpty($_POST)):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isNumber($_POST, $camposNumericos):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isString($_POST, $camposString):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isDuplicated('paciente', 'cedula', $_POST["cedula"]):
                return $respuesta = new Response('DATOS_DUPLICADOS');
            case $validarPaciente->isDate($_POST['fecha_nacimiento']):
                return $respuesta = new Response('FECHA_INVALIDA');
            case $validarPaciente->isToday($_POST['fecha_nacimiento'], false):
                return $respuesta = new Response('DATOS_INVALIDOS');
            default: 
            $data = $validarPaciente->dataScape($_POST);

            $_pacienteModel = new PacienteModel();
            $id = $_pacienteModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function listarPacientes(){

        $_pacienteModel = new PacienteModel();
        $lista = $_pacienteModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarPacientePorId($paciente_id){

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('paciente_id','=',$paciente_id)->getFirst();
        $mensaje = ($paciente != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($paciente);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarPaciente($paciente_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "edad", "telefono");
        $camposString = array("nombres", "apellidos");
        $camposKey = array("paciente_id"); // Esta variable es el array que se pasara por existInDB

        $validarPaciente = new Validate;
        switch($_POST) {
            case ($validarPaciente->isEmpty($_POST)):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isNumber($_POST, $camposNumericos):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isString($_POST, $camposString):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->existsInDB($_POST, $camposKey):   
                return $respuesta = new Response('NOT_FOUND');            
            case array_key_exists('cedula', $_POST):
                if ( $validarPaciente->isDuplicated('paciente', 'cedula', $_POST["cedula"]) ) {
                    return $respuesta = new Response('DATOS_DUPLICADOS');
                }
            case $validarPaciente->isDate($_POST['fecha_nacimiento']):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarPaciente->isToday($_POST['fecha_nacimiento'], false):
                return $respuesta = new Response('DATOS_INVALIDOS');
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
}



?>