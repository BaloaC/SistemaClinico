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

        if ($validarLogin->isEmpty($_POST)) {
            return $respuesta = new Response('DATOS_INVALIDOS');
        }

        $_UsuarioModel = new UsuarioModel();
        $usuario = $_UsuarioModel->where('nombre','=',$_POST["nombre"])->getFirst();
        date_default_timezone_set('America/Caracas');

        if (!is_null($usuario)) {
            if ($usuario->estatus_usu == 2) {
                // validación del usuario deshabilitado
                $respuesta = new Response('DATOS_INVALIDOS');
                echo $respuesta->json(400);
                exit();
            } else {
                
                $claveEncriptada = $usuario->clave;
                $clave = $_POST["clave"];
    
                if(password_verify($clave, $claveEncriptada)){
                    if (!is_null($usuario->intentos) && $usuario->intentos[0] == 3) {

                        $fecha = new DateTime();
                        $hora = $fecha->format('H:i');

                        $intentos = explode('|', $usuario->intentos);
                        $hora_limite = DateTime::createFromFormat('H:i', $intentos[1]);
                        $interval = new DateInterval('PT30M');
                        $hora_limite->add($interval);
                        $nueva_hora = $hora_limite->format('H:i');
                        
                        if ($hora < $nueva_hora) {
                            $respuesta = new Response(false, 'Máximos intentos de inicio de sesión alcanzados, intente más tarde');
                            echo $respuesta->json(400);
                            exit();
                        }
                    }

                    $code = bin2hex(random_bytes(5));
                    $intentos = null;
                    $tokken = array( 'tokken' => $code, 'intentos' => $intentos);
    
                    $_UsuarioModel = new UsuarioModel();
                    $actualizado = $_UsuarioModel->where('nombre','=',$_POST['nombre'])->update($tokken);
                    $mensaje = ($actualizado > 0);
                    
                    $tokken['usuario_id'] = $usuario->usuario_id;
                    $tokken['nombres'] = $usuario->nombres;
                    $tokken['apellidos'] = $usuario->apellidos;
                    $tokken['rol'] = $usuario->rol;
    
                    // Automatización de facturas_seguro
                    $_facturaSeguro = new FacturaSeguroController();
                    // $_facturaSeguro->insertarFacturaSeguro();
    
                    $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
                    $respuesta->setData($tokken);
    
                    return $respuesta->json(200);
    
                } else {

                    $fecha = new DateTime();
                    $hora = $fecha->format('H:i');

                    $intento = "";
                    $intentos = is_null($usuario->intentos) ? null : explode('|', $usuario->intentos);
                                        
                    if ( !is_null($intentos) && $intentos[0] == 3) {

                        $hora_limite = DateTime::createFromFormat('H:i', $intentos[1]);
                        $interval = new DateInterval('PT30M');
                        $hora_limite->add($interval);
                        $nueva_hora = $hora_limite->format('H:i');

                        if ($hora < $nueva_hora) {
                            $respuesta = new Response(false, 'Máximos intentos de inicio de sesión alcanzados, intente más tarde');
                            echo $respuesta->json(400);
                            exit();
                        } else {
                            $intento = "1|".$hora;
                        }
                    }

                    if ( !is_null($intentos) && $intentos[0] < 3) {
                        $intento = ($intentos[0] + 1) . "|" . $hora;
                    }

                    if ( is_null($usuario->intentos) || $intentos[1] > $hora ) {
                        $intento = "1|".$hora;
                    }
                    
                    $_UsuarioModel->where('nombre','=',$_POST["nombre"])->update(['intentos' => $intento]);
                    $respuesta = new Response('DATOS_INVALIDOS');
                    echo $respuesta->json(400);
                    exit();
                }
            }
        }
        
        return $respuesta = new Response('DATOS_INVALIDOS');
    }

    public function validarUsuario() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposKey = array("nombre", "clave");
        
        $validarLogin = new Validate;

        if ($validarLogin->isEmpty($_POST)) {
            return $respuesta = new Response('DATOS_INVALIDOS');
        }

        $_UsuarioModel = new UsuarioModel();
        $usuario = $_UsuarioModel->where('nombre','=',$_POST["nombre"])->getFirst();

        if (!is_null($usuario)) {
            if ($usuario->estatus_usu == 2) {
                $respuesta = new Response('DATOS_INVALIDOS');
                echo $respuesta->json(400);
                exit();
                
            } else {
                
                $claveEncriptada = $usuario->clave;
                $clave = $_POST["clave"];
    
                if(password_verify($clave, $claveEncriptada)){   
                    $respuesta = new Response('CORRECTO');    
                    echo $respuesta->json(200);
                    exit();
    
                } else {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    echo $respuesta->json(400);
                    exit();
                }
            }
        }
        
        $respuesta = new Response('DATOS_INVALIDOS');
        echo $respuesta->json(400);
        exit();
    }
    
    public function recuperarUsuario($usuario_id) {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // if ($_POST['tipo_auth'] > 2) {
            
        //     $respuesta = new Response(false, 'Método de autenticación incorrecto');
        //     return $respuesta->json(400);

        // } else if ($_POST['tipo_auth'] == 1) {

            // if ( !($_POST['auth']) ) {
                
            //     $respuesta = new Response(false, 'El pin debe estar compuesto únicamente por números');
            //     return $respuesta->json(400);

            // } else {

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
            // }
        // } else if ($_POST['tipo_auth'] == 2) {

        //     return 'pq cae aki';
        // }   
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
                return $respuesta->json(200);

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
                return $respuesta->json(200);

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
