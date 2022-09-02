<?php

class Controller{

    protected $request;
    private $view;

    public function __construct(){
        
    }

    //Método para renderizar una vista 
    public function view($file, $variables = null){

        if(empty($this->view)){

            $this->view = new View();
        }

        return $this->view->render($file, $variables);
    }

    /* GETTER */
    public function getRequest(){return $this->request;}

    /* SETTER */
    public function setRequest($request){$this->request = $request;}
}


?>