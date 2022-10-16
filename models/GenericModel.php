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

        $variables = get_class_vars($this->className);
        $attributes = array();
        

        foreach($variables as $key => $value){

            if(!in_array($key, $this->exclude)){
                
                $attributes[] = $key;
            }
        }
        return $attributes;
    }

    //Método para asignar los atributos del objeto que heradará esta clase o el que se envíe como parámetro
    public function parse($obj = null){

        try {
            
            $attributes = $this->getAttributes();
            
            $finalObject = array();

            //Obtenemos el objeto desde el modelo
            if($obj == null){

                foreach ($attributes as $index => $key) {

                    if(isset($this->{$key})){

                        $finalObject[$key] = $this->{$key};
                    }
                }  

                return $finalObject;
            }

            //Corregir el objeto que recibimos con los atributos del modelo
            foreach ($attributes as $index => $key) {

                if(isset($obj[$key])){

                    $finalObject[$key] = $obj[$key];
                }
            }

            return $finalObject;

        } catch (PDOException $error) {

            throw new PDOException("Error en: $this->className, en el método parse(). {$error->getMessage()}");        
        }
    }

    //Método para establecer los atributos a la clase a partir de un objeto
    public function fill($obj){
        
        try {

            $attributes = $this->getAttributes();
            
            foreach($attributes as $index => $key){

                if(isset($obj[$key])){

                    $this->{$key} = $obj[$key];
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

    public function __get($attributeName){

        return $this->{$attributeName};
    }

    public function __set($attributeName, $value){

        $this->{$attributeName} = $value;
    }

}





?>