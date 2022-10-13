<?php

class MedicoController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('medicos/index');
    }

    public function formRegistrarMedicos(){

        return $this->view('medicos/registrarMedicos');
    }

    public function formActualizarMedico($idMedico){
        
        return $this->view('medicos/actualizarMedicos', ['idMedico' => $idMedico]);
    } 

    public function insertarMedicos(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_medicoModel = new MedicoModel();
        $id = $_medicoModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarMedico(){

        $_medicoModel = new MedicoModel();
        $lista = $_medicoModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarMedicosPorId($idMedico){

        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id','=',$idMedico)->getFirst();
        $mensaje = ($medico != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($medico);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarMedico(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_medicoModel = new MedicoModel();

        $actualizado = $_medicoModel->where('medico_id','=',$_POST['idMedico'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarMedico($idMedico){

        $_medicoModel = new MedicoModel();

        $eliminado = $_medicoModel->where('medico_id','=',$idMedico)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>