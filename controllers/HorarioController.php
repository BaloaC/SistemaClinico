<?php

class HorarioController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('consultas/index');
    }

    public function formRegistrarHorarios(){

        return $this->view('consultas/registrarHorarios');
    }

    public function formActualizarHorario($idHorario){
        
        return $this->view('consultas/actualizarHorarios', ['idHorario' => $idHorario]);
    } 

    public function insertarHorarios(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_horarioModel = new HorarioModel();
        $id = $_horarioModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarHorarios(){

        $_horarioModel = new HorarioModel();
        $lista = $_horarioModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarHorariosPorId($idHorario){

        $_horarioModel = new HorarioModel();
        $horario = $_horarioModel->where('horario_id','=',$idHorario)->getFirst();
        $mensaje = ($horario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($horario);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarHorario(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_horarioModel = new HorarioModel();

        $actualizado = $_horarioModel->where('horario_id','=',$_POST['idHorario'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarHorario($idHorario){

        $_horarioModel = new HorarioModel();

        $eliminado = $_horarioModel->where('horario_id','=',$idHorario)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>