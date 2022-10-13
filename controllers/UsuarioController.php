<?php

class UsuarioController extends Controller{

    public function __construct(){

    }

    //Método index (vista principal)
    public function index(){

        return $this->view('usuarios/index');
    }

    public function formRegistrarUsuario(){

        return $this->view('usuarios/registrarUsuario');
    }

    public function formActualizarUsuarios($idUsuario){
        
        return $this->view('usuarios/actualizarUsuario', ['idUsuario' => $idUsuario]);
    } 

    public function insertarUsuario(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_usuarioModel = new UsuarioModel();
        $id = $_usuarioModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarUsuarios(){

        $_usuarioModel = new UsuarioModel();
        $lista = $_usuarioModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarUsuarioPorId($idUsuario){

        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('usuarios_id','=',$idUsuario)->getFirst();
        $mensaje = ($usuario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($usuario);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarUsuario(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_usuarioModel = new UsuarioModel();

        $actualizado = $_usuarioModel->where('usuarios_id','=',$_POST['idUsuario'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarUsuario($idUsuario){

        $_usuarioModel = new UsuarioModel();

        $eliminado = $_usuarioModel->where('usuarios_id','=',$idUsuario)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>