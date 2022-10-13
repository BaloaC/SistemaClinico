<?php

class PacienteController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('pacientes/index');
    }

    public function formRegistrarPacientes(){

        return $this->view('pacientes/registrarPacientes');
    }

    public function formActualizarPaciente($idPaciente){
        
        return $this->view('pacientes/actualizarPacientes', ['idPaciente' => $idPaciente]);
    } 

    public function insertarPacientes(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_pacienteModel = new PacienteModel();
        $id = $_pacienteModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarPacientes(){

        $_pacienteModel = new PacienteModel();
        $lista = $_pacienteModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarPacientesPorId($idPaciente){

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('paciente_id','=',$idPaciente)->getFirst();
        $mensaje = ($paciente != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($paciente);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarPaciente(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_pacienteModel = new PacienteModel();

        $actualizado = $_pacienteModel->where('paciente_id','=',$_POST['idPaciente'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarPaciente($idPaciente){

        $_pacienteModel = new PacienteModel();

        $eliminado = $_pacienteModel->where('paciente_id','=',$idPaciente)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>