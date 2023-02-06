<?php

class LoginController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('login/index');
    }

    public function recuperarUsuarioView(){

        return $this->view('login/recuperarUsuario.php');
    }

    public function entrar(){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposKey = array("nombre", "clave");

        $validarLogin = new Validate;
        switch ($_POST) {
            case $validarLogin->isEmpty($_POST):
                return $respuesta = new Response('DATOS_INVALIDOS');
            
            case $validarLogin->isDuplicated('usuario', 'nombre', $_POST["nombre"]):

                $_UsuarioModel = new UsuarioModel();
                $usuario = $_UsuarioModel->where('nombre','=',$_POST["nombre"])->getFirst();
                $claveEncriptada = $usuario->clave;
                $clave = $_POST["clave"];


                if(password_verify($clave, $claveEncriptada)){
                    $code = bin2hex(random_bytes(5));
                    $tokken = array( 'tokken' => $code);   

                    $_UsuarioModel = new UsuarioModel();

                    $actualizado = $_UsuarioModel->where('nombre','=',$_POST['nombre'])->update($tokken);
                    $mensaje = ($actualizado > 0);
                    
                    $tokken['usuario_id'] = $usuario->usuario_id;
                    $tokken['rol'] = $usuario->rol;

                    $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
                    $respuesta->setData($tokken);

                    return $respuesta->json(200);

                } else {
                    return $respuesta = new Response('DATOS_INVALIDOS');
                }

            default:
                return $respuesta = new Response('DATOS_INVALIDOS');
        }
    }
    
    public function recuperarUsuario($usuario_id) {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if ($_POST['tipo_auth'] > 2) {
            
            $respuesta = new Response(false, 'Método de autenticación incorrecto');
            return $respuesta->json(400);

        } else if ($_POST['tipo_auth'] == 1) {

            if ( !($_POST['auth']) ) {
                
                $respuesta = new Response(false, 'El pin debe estar compuesto únicamente por números');
                return $respuesta->json(400);

            } else {

                $_UsuarioModel = new UsuarioModel();
                $usuario = $_UsuarioModel->where('usuario_id','=',$usuario_id)->getFirst();
                $pinEncriptada = $usuario->pin;
                $clave = $_POST['auth'];
                
                if (password_verify($clave, $pinEncriptada)) {
                    
                    $actualizado['clave'] = password_hash($_POST['nueva_clave'], PASSWORD_DEFAULT);
                    $_UsuarioModel = new UsuarioModel();
                    $cambio = $_UsuarioModel->where('usuario_id','=',$usuario_id)->update($actualizado);

                    $respuesta = new Response($cambio ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                    return $respuesta->json(200);

                } else {
                    
                    $respuesta = new Response(false, 'Pin incorrecto');
                    return $respuesta->json(400);
                }
            }

        } else if ($_POST['tipo_auth'] == 2) {

            return 'pq cae aki';
        }   
    }

    public function insertarPregunta($usuario_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarUsuario = new Validate;

        switch($_POST) {
            case ($validarUsuario->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
        
            case !$validarUsuario->isDuplicated("usuario", 'usuario_id', $usuario_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            default: 

                foreach ($_POST as $posts) {
                    
                    $data = $validarUsuario->dataScape($posts);
                    $data['usuario_id'] = $usuario_id;

                    $_preguntaSeguridadModel = new PreguntaSeguridadModel();
                    $actualizado = $_preguntaSeguridadModel->insert($data);
                    $mensaje = ($actualizado > 0);
            
                    if (!$mensaje) {

                        $respuesta = new Response('INSERCION_FALLIDA');
                        $respuesta->setData($posts['pregunta']);
                        return $respuesta->json(404);
                    }
                }

            $respuesta = new Response('INSERCION_EXITOSA');
            return $respuesta->json(201);
        }
    }

    public function comprobarPregunta($usuario_id) {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarUsuario = new Validate;
        
        switch($_POST) {
        
            case !$validarUsuario->isDuplicated("usuario", "usuario_id", $usuario_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            default: 
   
                $usuario_id = $usuario_id;
                $pregunta = $_POST['preguntas'];

                foreach ($pregunta as $preguntas) {
                    
                    $_preguntaSeguridadModel = new PreguntaSeguridadModel();
                    $select = $_preguntaSeguridadModel->where('pregunta', '=', $preguntas['pregunta'])->getFirst();
                    $respuesta = $select->respuesta;
                    
                    if ($preguntas['respuesta'] != $respuesta) {
                        
                        $respuesta = new Response(false, 'Respuesta de seguridad incorrecta');
                        $respuesta->setData($preguntas['pregunta']);
                        return $respuesta->json(400);
                    }
                }
                
                $insert['clave'] = password_hash($_POST['nueva_clave'], PASSWORD_DEFAULT);
                
                $_usuarioModel = new UsuarioModel();
                $mensaje = $_usuarioModel->where('usuario_id', '=', $usuario_id)->update($insert);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }
}
?>