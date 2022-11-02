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
                $sql = "SELECT $key FROM $table WHERE $key = '$value'";
                $query = $this->connection->prepare($sql);
                $query->execute();
                
                if($query->rowCount() > 0){
                    
                    return true;
                } else {
                    return false;
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

        $sql = "SELECT $column FROM $table WHERE $column = '$value'";
        $query = $this->connection->prepare($sql);
        $query->execute();
                
        if($query->rowCount() > 0){

            return true;
        }
    }

    public function isDuplicatedId($id1, $id2, $value1, $value2, $table) {
       
        $sql = "SELECT * FROM $table WHERE $id1 = '$value1' AND $id2 = '$value2'";
        $query = $this->connection->prepare($sql);
        $query->execute();
        // $result = $query->fetchAll(PDO::FETCH_OBJ);
        
        if ( $query->rowCount() > 0 ) {
            
            return true;
        } else {
            
            return false;
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

    // Para verificar si la fecha es anterior a hoy se tiene que pasar true por $bool, para evaluar que sea posterior a hoy se pasa false por $bool
    public function isToday($date, $bool, $format = 'Y-m-d') {
        $hoy = date($format);
        $menor = $date < $hoy;
        
        if ($bool == true) {
            $resultado = $menor ? true : false;
            return $resultado;
        } else {
            $resultado = $menor ? false : true;
            return $resultado;
        }
    }

    //Validar que una fecha sea válida
    public function isDate($date, $format = 'Y-m-d'){

        $d = DateTime::createFromFormat($format,$date);

        $bool = $d && $d->format($format) === $date;
        $resultado = $bool ? false : true;
        return $resultado;
    }

    //Validar cédula de identidad
    public function isCedula($cedula){

        if(!is_numeric($cedula) || !(strlen($cedula) >= 6  && strlen($cedula) <= 9)){

            return true;
        }
    }
}



?>