<?php

class Uri{

    public $uri;
    public $method;
    public $function;
    public $middlewares;
    public $matches;
    protected $request;
    protected $response;

    public function __construct($uri, $method, $function, $middlewares){
    // public function __construct($uri, $function, $nivel){
        
        $this->uri = $uri;
        $this->method = $method;
        $this->function = $function;
        $this->middlewares = $middlewares;
    }

    //Método para validar si una URI existe
    public function match($url){
        echo 'esta enel match';
        $path = preg_replace('#:([\w]+)#', '([^/]+)',$this->uri);
        $regex = "#^$path$#i";

        //Validamos si hay alguna coincidencia
        if(!preg_match($regex, $url, $matches)){
            
            return false;
        }

        //Validamos que el método sea correcto
        if($this->method != $_SERVER['REQUEST_METHOD'] && $this->method != 'ANY'){

            return false;
        }

        array_shift($matches);
        $this->matches = $matches;
        return true;
    }

    //Método para llamar un método del controlador
    public function call(){

        try {
            
            $this->request = $_REQUEST;

            //Validamos que el método sea un string
            if(is_string($this->function)){

                //Ejecutamos el método del controlador
                $this->functionFromController();
            } else{
                
                //Ejecutamos la función que nos envien
                $this->execFunction();
            }

            //Imprimimos la respuesta
            $this->printResponse();

        } catch (PDOException $error) {

            //Mejorar error
            echo 'Ha ocurrido un error: ' . $error->getMessage();
        }
    }

    //Llamar un método desde el controlador
    private function functionFromController(){
        
        $parts = $this->getParts();
        $class = $parts['class'];
        $method = $parts['method'];

        //Importamos el controlador
        if(!$this->importController($class)){

            return;
        }

        //Preparamos la ejecución...
        $this->parseRequest();
        $classInstance = new $class;
        $classInstance->setRequest($this->request);
        
        //Lanzamos el método
        $launch = array($classInstance, $method);

        //Validamos que sea un método
        if(is_callable($launch)){

            $this->response = call_user_func_array($launch, $this->matches);
        } else{

            throw new Exception("El método $class.$method no existe.", -1);
        }
    }

    //Importar un controlador
    public function importController($class){

        $file = PATH_CONTROLLERS . $class . '.php';

        //Validamos que archivo exista
        if(!file_exists($file)){

            throw new Exception("El controlador $file no existe.");
            return false;
        } else{
            
            require_once $file;
            return true;
        }
    }

    //Obtener las partes (la clase y método) a partir del string
    private function getParts(){

        $parts = array();

        //Validamos si se intenta invocar un método con el '@'
        if(strpos($this->function, '@')){
        
            $methodParts = explode('@', $this->function);
            $parts['class'] = $methodParts[0];
            $parts['method'] = $methodParts[1];

        } else{

            $parts['class'] = $this->function;
            $parts['method'] = ($this->uri == '/') ? 'index' : $this->formatCamelCase($this->uri);
        }

        return $parts;
    }

    //Método para para obtener el método a partir de la URI en caso no especificar el '@'
    private function formatCamelCase($string){

        $parts = preg_split('[-|_]', strtolower($string));
        $finalString = '';
        $i = 0;

        foreach($parts as $parts){

            $finalString .= ($i = 0) ? strtolower($parts) : ucfirst($parts);
            $i++;
        }

        return $finalString;
    }

    //Método para ejecutar la función que nos envien
    private function execFunction(){

        $this->parseRequest();
        $this->response = call_user_func_array($this->function, $this->matches);
    }

    //Método para para obtener el request
    private function parseRequest(){

        $this->request = new Request($this->request);
        $this->matches[] = $this->request;
    }

    //Método para imprimir la respuesta
    private function printResponse(){

        //Validamos si es un string o un array/object
        if(is_string($this->response)){

            echo $this->response;

        } elseif(is_object($this->response) || is_array($this->response)){

            $response = new Response();
            echo $response->json(200,$this->response);
        }
    }
}



?>