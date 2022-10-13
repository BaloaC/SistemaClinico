<?php

class ConsultaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas(){

        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($idConsulta){
        
        return $this->view('consultas/actualizarConsultas', ['idConsulta' => $idConsulta]);
    } 

    public function insertarConsultas(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_consultaModel = new ConsultaModel();
        $id = $_consultaModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarConsultas(){

        $_consultaModel = new ConsultaModel();
        $lista = $_consultaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarConsultasPorId($idConsulta){

        $_consultaModel = new ConsultaModel();
        $consulta = $_consultaModel->where('consulta_id','=',$idConsulta)->getFirst();
        $mensaje = ($consulta != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($consulta);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarConsulta(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_consultaModel = new ConsultaModel();

        $actualizado = $_consultaModel->where('consulta_id','=',$_POST['idConsulta'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarConsulta($idConsulta){

        $_consultaModel = new ConsultaModel();

        $eliminado = $_consultaModel->where('consulta_id','=',$idConsulta)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>