<?php

include_once './services/cuenta/CuentaValidaciones.php';
include_once './services/cuenta/CuentaHelpers.php';
include_once './services/cuenta/CuentaService.php';

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

    public function formActualizarUsuarios($usuario_id){
        
        return $this->view('usuarios/actualizarUsuario', ['usuario_id' => $usuario_id]);
    } 

    public function insertarUsuario(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'usuarios';

        $_POST = json_decode(file_get_contents('php://input'), true);
        CuentaValidaciones::validarNuevoUsuario($_POST);

        $id = CuentaService::insertarNuevoUsuario($_POST);
        $preguntasSeguridad = $_POST['preguntas'];

        if ($id) {
            
            CuentaHelpers::insertarPreguntaSeguridad($preguntasSeguridad, $id);
            
            $respuesta = new Response('INSERCION_EXITOSA');
            return $respuesta->json(201);

        } else {

            $respuesta = new Response('INSERCION_FALLIDA');
            return $respuesta->json(400);
        }
    }

    public function listarUsuarios(){

        $_usuarioModel = new UsuarioModel();
        
        $lista = $_usuarioModel->where('estatus_usu', '=', '1')->getAll();
        $mensaje = (count($lista) > 0);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarUsuarioPorId($usuario_id){

        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('usuario_id','=',$usuario_id)->where('estatus_usu', '=', '1')->getFirst();
        $mensaje = ($usuario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($usuario);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarUsuario($usuario_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        // Creando los strings para las validaciones
        $camposNumericos = array("rol");
        $validarUsuario = new Validate;

        switch($_POST) {
            case ($validarUsuario->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
        
            case $validarUsuario->isEliminated("usuario", 'estatus_usu', $usuario_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case $validarUsuario->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case array_key_exists('nombre', $_POST):
                if ($validarUsuario->isDuplicated('usuario', 'nombre', $_POST["nombre"])) {
                    $respuesta = new Response(false, 'Ese nombre de usuario ya existe');
                    return $respuesta->json(400);
                }
            default: 
            $data = $validarUsuario->dataScape($_POST);

            $_usuarioModel = new UsuarioModel();

            $actualizado = $_usuarioModel->where('usuario_id','=',$usuario_id)->update($data);
            $mensaje = ($actualizado > 0);
    
            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
    
            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarUsuario($usuario_id){

        $_usuarioModel = new UsuarioModel();

        $data = array(
            "estatus_usu" => "2"
        );

        $eliminado = $_usuarioModel->where('usuario_id','=',$usuario_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
