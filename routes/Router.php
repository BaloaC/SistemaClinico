<?php

require_once 'middleware/middlewareBase.php';

class Router{
    
    private static $get = array();
    private static $post = array();
    private static $put = array();
    private static $delete = array();

    //Método para agregar el método HTTP
    public static function add($method, $uri, $function = null){
        
        // Router::$uris[$uri] = new Uri(self::parseUri($uri),$method,$function);
        // return;
    }

    public static function get($uri,  $function = null, $nivel = 0){
    
        Router::$get[$uri] = new Uri(self::parseUri($uri) , 'GET', $nivel, $function);
        return;
    }

    public static function post($uri, $function = null,  $nivel = 0){
        Router::$post[$uri] = new Uri(self::parseUri($uri), 'POST', $nivel, $function);
        return;
        // return Router::add('POST', $uri, $function);
    }

    public static function put($uri, $nivel = 0, $function = null){
        
        Router::$put[$uri] = new Uri(self::parseUri($uri), 'PUT', $nivel, $function);
        return;
    }

    public static function delete($uri, $nivel = 0, $function = null){
        
        Router::$delete[$uri] = new Uri(self::parseUri($uri), 'DELETE', $nivel, $function);
        return;
    }

    public static function any($uri, $function = null){
        
        return Router::add('ANY', $uri, $function);
    }

    //Método para parsear la uri
    public static function parseUri($uri){

        $uri = trim($uri,'/');
        $uri = (strlen($uri) > 0) ? $uri : '/';
        return $uri;
    }

    //Método para ejectuar método HTTP
    public static function submit(){
        // var_dump('<pre>');

        // Verificando Token Bearer
        if (!isset(apache_request_headers()['Authorization'])) {
            http_response_code(401);                    
            echo json_encode([
                "code" => false,
                "message" => "Es necesario el token de seguridad"
            ]);
            return;
        }

        $token = MiddlewareBase::verifyToken(apache_request_headers()['Authorization']);
        
        if (!$token) {
            http_response_code(401);                    
            echo json_encode([
                "code" => false,
                "message" => "Token de seguridad inválido"
            ]);
            return;
        }

        $method = $_SERVER['REQUEST_METHOD'];
        
        $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
        $uri = self::parseUri($uri);

        // $permission = MiddlewareBase::verifyPermissions(Router::$get["/".$uri]->nivel);
        
        if ($method == 'POST') {
            
            $uris = Router::$post["/".$uri]->uri;
            $permission = MiddlewareBase::verifyPermissions(Router::$post["/".$uri]->nivel);
            if (!$permission) { return Router::retornarMensaje($permission); }

            if ($uris === $uri) {
                return Router::$post["/".$uri]->call();
            }

        } else if ($method == 'PUT') {

            $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '',$uri);
            $ruta =Router::$put["/".$uri2."/:id"];
            $permission = MiddlewareBase::verifyPermissions(Router::$put["/".$uri2."/:id"]->nivel);
            if (!$permission) { return Router::retornarMensaje($permission); }

            if ( $ruta->match($uri)) {
                return $ruta->call();
            }

        } else if ($method == 'GET') {

            if ( is_numeric(substr($uri, -1)) ) {
                $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\s]+/u', '',$uri);
                $ruta =Router::$get["/".$uri2."/:id"];
                $permission = MiddlewareBase::verifyPermissions(Router::$get["/".$uri2."/:id"]->nivel);
                if (!$permission) { return Router::retornarMensaje($permission); }

                if ( $ruta->match($uri)) {    
                    return $ruta->call();
                }

            } else {
                $permission = MiddlewareBase::verifyPermissions(Router::$get["/".$uri]->nivel);
                if (!$permission) { return Router::retornarMensaje($permission); }
                
                    $uris = Router::$get["/".$uri]->uri;
                    if ($uris === $uri) {
                        return Router::$get["/".$uri]->call();
                    }
            }
        }

        //Verifica si la uri que está solicitando el usuario se encuentra registrada...
        

        // var_dump('o');var_dump('o');
        // foreach (Router::$put as $key => $recordUri){
        //     var_dump($recordUri);
        //     var_dump($recordUri->match($uri));
        //     if($recordUri->match($uri)){
        //         var_dump('o');
        //         var_dump($uri);
        //         // var_dump('a');
        //         // var_dump($recordUri);
        //         //     var_dump(Router::$put["/".$uri2."/:id"]);
        //         //     var_dump(Router::$put["/".$uri2."/:id"]->matches);
        //         // 
                    
        //         // } else {
        //             return $recordUri->call();    
        //         // }
        //     }
        // }

        // Muestra el mensaje de error 404
        header('Content-Type: text/html; charset=utf-8');
        echo 'La uri (<a href="' . $uri . '"> '. $uri .'</a>)no se encuentra registrada en el metodo: ' . $method;
    }
    public static function retornarMensaje($boolean) {
        if (!$boolean) {
            http_response_code(401);                    
            echo json_encode([
                "code" => false,
                "message" => "No posee los permisos necesarios para acceder a este recurso"
            ]);
            return;
        }      
    }
}


?>