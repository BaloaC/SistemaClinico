<?php

require_once 'middleware/middlewareBase.php';

class Router
{

    private static $get = array();
    private static $post = array();
    private static $put = array();
    private static $delete = array();

    //Método para agregar el método HTTP
    public static function add($method, $uri, $function = null)
    {

        // Router::$uris[$uri] = new Uri(self::parseUri($uri),$method,$function);
        // return;
    }

    public static function get($uri,  $function = null, $nivel = 0)
    {

        Router::$get[$uri] = new Uri(self::parseUri($uri), 'GET', $nivel, $function);
        return;
    }

    public static function post($uri, $function = null,  $nivel = 0)
    {
        Router::$post[$uri] = new Uri(self::parseUri($uri), 'POST', $nivel, $function);
        return;
        // return Router::add('POST', $uri, $function);
    }

    public static function put($uri, $function = null, $nivel = 0)
    {

        Router::$put[$uri] = new Uri(self::parseUri($uri), 'PUT', $nivel, $function);
        return;
    }

    public static function delete($uri, $function = null, $nivel = 0)
    {

        Router::$delete[$uri] = new Uri(self::parseUri($uri), 'DELETE', $nivel, $function);
        return;
    }

    public static function any($uri, $function = null)
    {

        return Router::add('ANY', $uri, $function);
    }

    //Método para parsear la uri
    public static function parseUri($uri)
    {

        $uri = trim($uri, '/');
        $uri = (strlen($uri) > 0) ? $uri : '/';
        return $uri;
    }

    //Método para ejectuar método HTTP
    public static function submit(){
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
        $uri = self::parseUri($uri);

        // $permission = MiddlewareBase::verifyPermissions(Router::$get["/".$uri]->nivel);

        if ($method == 'POST') {

            if (is_numeric(substr($uri, -1))) {
                
                $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\/\s]+/u', '', $uri);
                $nivel = Router::$post["/" . $uri2 . ":id"]->nivel;

                if ($nivel != -1) {
                    Router::comprobacionDeSeguridad(); // Comprobamos el token
                    $permission = MiddlewareBase::verifyPermissions($nivel);
                    if (!$permission) {
                        return Router::retornarMensaje($permission);
                    }
                }

                $ruta = Router::$post["/" . $uri2 . ":id"];
                if ($ruta->match($uri)) {
                    return $ruta->call();
                }

            }else {

                $nivel = Router::$post["/" . $uri]->nivel;
                if ($nivel != -1) {
                    Router::comprobacionDeSeguridad(); // Comprobamos el token
                    $permission = MiddlewareBase::verifyPermissions($nivel);
                    if (!$permission) {
                        return Router::retornarMensaje($permission);
                    }
                }

                $uris = Router::$post["/" . $uri]->uri;
                $nivel = Router::$post["/" . $uri]->nivel;

                if ($uris === $uri) {
                    return Router::$post["/" . $uri]->call();
                }

            }
        } else if ($method == 'PUT') {

            Router::comprobacionDeSeguridad(); // Comprobamos el token

            $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\/\s]+/u', '', $uri);
            $ruta = Router::$put["/" . $uri2 . ":id"];
            $permission = MiddlewareBase::verifyPermissions(Router::$put["/" . $uri2 . ":id"]->nivel);
            if (!$permission) {
                return Router::retornarMensaje($permission);
            }

            if ($ruta->match($uri)) {
                return $ruta->call();
            }
        } else if ($method == 'DELETE') {
            Router::comprobacionDeSeguridad(); // Comprobamos el token

            $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\/\s]+/u', '', $uri);
            $ruta = Router::$delete["/" . $uri2 . ":id"];
            $permission = MiddlewareBase::verifyPermissions(Router::$delete["/" . $uri2 . ":id"]->nivel);
            if (!$permission) {
                return Router::retornarMensaje($permission);
            }

            if ($ruta->match($uri)) {
                return $ruta->call();
            }
        } else if ($method == 'GET') {

            if (is_numeric(substr($uri, -1))) {

                $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\/\s]+/u', '', $uri);
                $nivel = Router::$get["/" . $uri2 . ":id"]->nivel;

                if ($nivel != -1) {
                    Router::comprobacionDeSeguridad(); // Comprobamos el token
                    $permission = MiddlewareBase::verifyPermissions($nivel);
                    if (!$permission) {
                        return Router::retornarMensaje($permission);
                    }
                }

                $ruta = Router::$get["/" . $uri2 . ":id"];
                if ($ruta->match($uri)) {
                    return $ruta->call();
                }
            } else {
                // $permission = MiddlewareBase::verifyPermissions(Router::$get["/".$uri]->nivel);
                // if (!$permission) { return Router::retornarMensaje($permission); }

                if ($uri === "/") {
                    return Router::$get[$uri]->call();
                }

                if(strpos($uri, "preguntas/usuario/") !== false){
                    
                    $uri2 = preg_replace('/\/\w+$/', '', $uri);
                    $ruta = Router::$get["/" . $uri2 . "/:id"];
                    if($ruta->match($uri)){
                        return $ruta->call();
                    }
                }

                $uris = Router::$get["/" . $uri]->uri;
                if ($uris === $uri) {
                    return Router::$get["/" . $uri]->call();
                }
            }
        }

        // Muestra el mensaje de error 404
        header('Content-Type: text/html; charset=utf-8');
        echo 'La uri (<a href="' . $uri . '"> ' . $uri . '</a>)no se encuentra registrada en el metodo: ' . $method;
    }
    public static function retornarMensaje($boolean)
    {
        if (!$boolean) {
            http_response_code(401);
            echo json_encode([
                "code" => false,
                "message" => "No posee los permisos necesarios para acceder a este recurso"
            ]);
            return;
        }
    }

    public static function comprobacionDeSeguridad()
    {
        if (!isset(apache_request_headers()['Authorization'])) {
            return Router::mensajeDeSeguridad(true);
        } else {
            $token = MiddlewareBase::verifyToken(apache_request_headers()['Authorization']);
            if (!$token) {
                return Router::mensajeDeSeguridad(false);
            }
        }
    }

    public static function mensajeDeSeguridad($bool)
    {
        $mensaje = $bool ? "Es necesario el token de seguridad" : "Token de seguridad inválido";
        http_response_code(401);
        echo json_encode([
            "code" => false,
            "message" => $mensaje
        ]);
        exit();
    }
}
