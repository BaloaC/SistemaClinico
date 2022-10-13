<?php

class CitaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('citas/index');
    }

    public function formRegistrarCitas(){

        return $this->view('citas/registrarCitas');
    }

    public function formActualizarCita($idCita){
        
        return $this->view('citas/actualizarCitas', ['idCita' => $idCita]);
    } 

    public function insertarCitas(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_citaModel = new CitaModel();
        $id = $_citaModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarCitas(){

        $_citaModel = new CitaModel();
        $lista = $_citaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarCitasPorId($idCita){

        $_citaModel = new CitaModel();
        $cita = $_citaModel->where('cita_id','=',$idCita)->getFirst();
        $mensaje = ($cita != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($cita);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarCita(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_citaModel = new CitaModel();

        $actualizado = $_citaModel->where('cita_id','=',$_POST['idCita'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarCita($idCita){

        $_citaModel = new CitaModel();

        $eliminado = $_citaModel->where('cita_id','=',$idCita)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>