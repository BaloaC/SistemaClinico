<?php

require_once 'BaseModel.php';

class GenericModel extends BaseModel{

    private $className;

    //Atributo para excluir los nombres de la clases de otros atributos
    private $exclude = ['className','table','connection','sql','wheres','exclude'];

    public function __construct($table, $className, $properties = null){
        
        parent::__construct($table);
        $this->className = $className;

        //Validamos que el parámetro no se envíe vacío
        if(empty($properties)){

            return;
        }

        foreach($properties as $key => $value){

            $this->{$key} = $value;
        }
    }

    //Obtenemos los atributos de la clase que heredará esta
    public function getAttributes(){

        $variables = get_class_vars('UsuarioModel');
        $atributos = array();
        

        foreach($variables as $llave => $valor){

            if(!in_array($llave, $this->exclude)){
                
                $atributos[] = $llave;
            }
        }
        return $atributos;
    }

    //Método para asignar los atributos del objeto que heradará esta clase o el que se envíe como parámetro
    public function parse($obj = null){

        try {
            
            $atributos = $this->getAttributes();
            
            $objetoFinal = array();

            //Obtenemos el objeto desde el modelo
            if($obj == null){

                foreach ($atributos as $indice => $llave) {

                    if(isset($this->{$llave})){

                        $objetoFinal[$llave] = $this->{$llave};
                    }
                }  

                return $objetoFinal;
            }

            //Corregir el objeto que recibimos con los atributos del modelo
            foreach ($atributos as $indice => $llave) {

                if(isset($obj[$llave])){

                    $objetoFinal[$llave] = $obj[$llave];
                }
            }

            return $objetoFinal;

        } catch (PDOException $error) {

            throw new PDOException("Error en: $this->className, en el método parse(). {$error->getMessage()}");        
        }
    }

    //Método para establecer los atributos a la clase a partir de un objeto
    public function fill($obj){
        
        try {

            $atributos = $this->getAttributes();
            
            foreach($atributos as $indice => $llave){

                if(isset($obj[$llave])){

                    $this->{$llave} = $obj[$llave];
                }
            }
            
        } catch (PDOException $error) {
            
            throw new PDOException("Error en: $this->className, en el método fill(). {$error->getMessage()}");
        }
    }

    //Método insert redefinido para no tener que pasar el objeto en caso de tener los atributos establecidos
    public function insert($obj = null){

        $obj = $this->parse($obj);

        return parent::insert($obj);
    }

    //Método update redefinido para no tener que pasar el objeto en caso de tener los atributos establecidos
    public function update($obj = null){

        $obj = $this->parse($obj);

        return parent::update($obj);
    }

    public function __get($nombreAtributo){

        return $this->{$nombreAtributo};
    }

    public function __set($nombreAtributo, $valor){

        $this->{$nombreAtributo} = $valor;
    }

}





?>