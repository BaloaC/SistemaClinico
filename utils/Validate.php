<?php

require_once 'models/BaseModel.php';

class Validate extends BaseModel{

    public function __construct(){

        parent::__construct();
    }

    //Validar que ningun dato se encuentre vacio
    public static function isEmpty($data, $exclude = null){
        
        foreach($data as $key => $value){

            if ($exclude != null) {
            
                if(is_numeric(array_search($key,$exclude))){

                    continue;
                }
            }
            if(empty($value)){
                
                return true;
            }
        }
    }

    //Validar que existan ciertas fk en la bd
    public function existsInDB($data, $validate){

        foreach($data as $key => $value){
            
            if(is_numeric(array_search($key,$validate))){
                
                $table = rtrim($key,'_id');
                $sql = "SELECT $key FROM $table WHERE $key = $value";
                $query = $this->connection->prepare($sql);
                $query->execute();
                
                if(empty($query->rowCount() > 0)){

                    return true;
                }
            }
        }
    }

    //Validar los datos ante posible inyección de código
    public function dataScape($data){

        $newData = [];

        foreach($data as $key => $value){

            $newData[$key] = trim(strip_tags($value),'\ \"\;\.\,\/\-\<\>\(\)\'');
        }

        return $newData;
    }

    //Validar que un registro no se encuentre duplicado
    public function isDuplicated($table, $column, $value){

        $sql = "SELECT $column FROM $table WHERE $column = $value";
        $query = $this->connection->prepare($sql);
        $query->execute();
                
        if($query->rowCount() > 0){

            return true;
        }
    }

    //Validar que ciertos datos sean números
    public function isNumber($data, $validate){

        foreach($data as $key => $value){
            
            if(is_numeric(array_search($key,$validate))){
                
                if(!is_numeric($value)){

                    return true;
                }
            }
        }
    }
    
    //Validar que ciertos datos sean únicamente texto
    public function isString($data, $validate){

        foreach($data as $key => $value){
            
            if(is_numeric(array_search($key,$validate))){
                
                if(!preg_match('/^[A-Za-zÁáÉéÍíÓóÚúÑñÜü\s]+$/',$value)){

                    return true;
                }
            }
        }
    }

    //Validar que una fecha sea válida
    public function isDate($date, $format = 'Y-m-d'){

        $d = DateTime::createFromFormat($format,$date);
        return $d && $d->format($format) === $date;
    }

    //Validar cédula de identidad
    public function isCedula($cedula){

        if(!is_numeric($cedula) || !(strlen($cedula) >= 6  && strlen($cedula) <= 9)){

            return true;
        }
    }
}



?>