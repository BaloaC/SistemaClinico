<?php

class View{

    protected $variables;
    protected $output;

    public function __construct(){
        
    }

    //Método para renderizar las vistas y asignar variables
    public function render($file, $variables = null){

        //Validamos si se pasan variables
        if(isset($variables) && is_array($variables)){

            $this->variables = $variables;
        }

        //Solicitamos la vista y la almacenamos en el búfer
        $file = PATH_VIEWS . $file;
        ob_start();
        $this->includeFile($file);
        $output = ob_get_contents();
        ob_end_clean();
        
        //Retornamos la vista renderizada
        return $output;
    }

    //Método para validar si el archivo de la vista existe
    public function includeFile($file){

        //Creamos las variables en el contexto actual...
        if(isset($this->variables) && is_array($this->variables)){

            foreach($this->variables as $key => $value){

                global ${$key};
                ${$key} = $value;
            }

        }

        //Validamos el nombre del archivo con sus extensiones
        if(file_exists($file)){

            return include $file;

        } elseif(file_exists($file . '.php')){

            return include $file . '.php';

        } elseif(file_exists($file . '.html')){

            return include $file . '.html';

        } else{ 
            
            //Si no existe el archivo podemos mandar el mensaje/vista de error aquí
            echo "<h1>No existe el archivo: $file</h1><br>";
        }

    }
}






?>