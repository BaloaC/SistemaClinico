<?php

class Router {
    private static $routes = array();

    //Método para agregar el método HTTP
    public static function add($method, $uri, $function = null) {
        // Router::$uris[$uri] = new Uri(self::parseUri($uri),$method,$function);
        // return;
    }

    public static function get($uri,  $function = null, $middlewares = null) {
        Router::$routes['GET'][$uri] = new Uri(self::parseUri($uri), 'GET', $function, $middlewares, $middlewares);
        return;
    }

    public static function post($uri, $function = null, $middlewares = null) {
        Router::$routes['POST'][$uri] = new Uri(self::parseUri($uri), 'POST', $function, $middlewares);
        return;
    }

    public static function put($uri, $function = null, $middlewares = null) {
        Router::$routes['PUT'][$uri] = new Uri(self::parseUri($uri), 'PUT', $function, $middlewares);
        return;
    }

    public static function delete($uri, $function = null, $middlewares = null) {
        Router::$routes['DELETE'][$uri] = new Uri(self::parseUri($uri), 'DELETE', $function, $middlewares);
        return;
    }

    public static function any($uri, $function = null){

        return Router::add('ANY', $uri, $function);
    }

    //Método para parsear la uri
    public static function parseUri($uri){

        $uri = trim($uri, '/');
        $uri = (strlen($uri) > 0) ? $uri : '';
        return $uri;
    }

    //Método para ejectuar método HTTP
    public static function submit(){
        $method = $_SERVER['REQUEST_METHOD'];

        $uri = isset($_GET['uri']) ? $_GET['uri'] : '';
        $uri = self::parseUri($uri);
        
        // try {
            
            // verificando si es una ruta '/:id'
            if (is_numeric(substr($uri, -1))) { 
                
                // Verificando que la ruta esté registrada
                $uri2 = preg_replace('/[^a-zA-ZáéíóúüÁÉÍÓÚÜñÑ\/\s]+/u', '', $uri);

                if (isset(Router::$routes[$method]["/" . $uri2 . ":id"])) {
                    $ruta = Router::$routes[$method]["/" . $uri2 . ":id"];

                    if ( $ruta->middlewares ) { // Ejecutando middleware
                        foreach ($ruta->middlewares as $middleware) {
                            $middleware->handleRequest( $ruta );
                        }   
                    }
                    
                    if ($ruta->match($uri)) {
                        return $ruta->call();
                    }

                } else {
                    throw new Exception();
                }

            } else {
                
                if (isset(Router::$routes[$method]["/" . $uri])) {

                    // Verificando que la ruta esté registrada
                    $uris = Router::$routes[$method]["/" . $uri]; 
                    
                    if ( !is_null(Router::$routes[$method]["/" . $uri]->middlewares) ) { // Ejecutando middleware
                        foreach (Router::$routes[$method]["/" . $uri]->middlewares as $middleware) {
                            $middleware->handleRequest( Router::$routes[$method]["/" . $uri] );
                        }
                    }
                    
                    if ($uris->uri === $uri) { // Llamando a la ruta
                        return Router::$routes[$method]["/" . $uri]->call();
                    }
                
                } else {
                    throw new Exception();
                }
            }

        // } catch (\Throwable $th) {
            
        //     // Muestra el mensaje de error 404
        //     header('Content-Type: text/html; charset=utf-8');
        //     echo 'La uri (<a href="' . $uri . '"> ' . $uri . '</a>)no se encuentra registrada en el metodo: ' . $method;
        // }
    }

}
