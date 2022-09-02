<?php

class Router{
    
    private static $uris = array();
    
    public function __construct(){
        
    }

    //Método para agregar el método HTTP
    public static function add($method, $uri, $function = null){

        Router::$uris[] = new Uri(self::parseUri($uri),$method,$function);
    
        //retornar a Middleware (opcional)
        return;
    }

    public static function get($uri, $function = null){
        
        return Router::add('GET', $uri, $function);
    }

    public static function post($uri, $function = null){
        
        return Router::add('POST', $uri, $function);
    }

    public static function put($uri, $function = null){
        
        return Router::add('PUT', $uri, $function);
    }

    public static function patch($uri, $function = null){
        
        return Router::add('PATCH', $uri, $function);
    }

    public static function delete($uri, $function = null){
        
        return Router::add('DELETE', $uri, $function);
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

        $method = $_SERVER['REQUEST_METHOD'];
        $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
        $uri = self::parseUri($uri);

        //Verifica si la uri que está solicitando el usuario se encuentra registrada...
        foreach (Router::$uris as $key => $recordUri){

            if($recordUri->match($uri)){

                return $recordUri->call();
            }
        }

        //Muestra el mensaje de error 404
        header('Content-Type: text/html; charset=utf-8');
        echo 'La uri (<a href="' . $uri . '"> '. $uri .'</a>)no se encuentra registrada en el metodo: ' . $method;
    }
}


?>