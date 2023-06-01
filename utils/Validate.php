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
                
                $length = strlen($key)-3;
                $table = substr($key, 0, $length);
                $estatus = 'estatus_' . substr($key, 0, 3);
                $sql = "SELECT $key FROM $table WHERE $key = '$value' AND $estatus != 2";
                
                $query = $this->connection->prepare($sql);
                $query->execute();
                
                if(!$query->rowCount() > 0){
                    
                    return true;
                }
            }
        }
        
        return false;
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

        $status = 'estatus_' . substr($table,0, 3);
        $sql = "SELECT $column FROM $table WHERE $column = '$value' AND $status != '2'";
        // $sql = "SELECT $column FROM $table WHERE $column = '$value'";
        $query = $this->connection->prepare($sql);
        $query->execute();
        
        if($query->rowCount() > 0){

            return true;
        }
    }

    // validar que una relación foránea o un campo no esté duplicado
    public function isDuplicatedId($id1, $id2, $value1, $value2, $table) {
       
        $status = 'estatus_' . substr($table,0, 3);
        $sql = "SELECT * FROM $table WHERE $id1 = '$value1' AND $id2 = '$value2' AND $status != '2'";
        $query = $this->connection->prepare($sql);
        $query->execute();
        // $result = $query->fetchAll(PDO::FETCH_OBJ);

        if ( $query->rowCount() > 0 ) {
            return true;
        } else {
            return false;
        }
        
    }

    // validar que un registro no esta eliminado
    public function isEliminated($table, $valueID){

        $var2 = '_id';
        $id = $table . $var2;
        $status = 'estatus_' . substr($table,0, 3);

        $sql = "SELECT * FROM $table WHERE $id = '$valueID' AND $status = '2'";
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
    
    /**
     * @access protected
     * Este método determina si la fecha es anterior o posterior a hoy
     *
     * @param date $date es la fecha
     * @param bool $bool es true si la fecha tiene que ser anterior al día de hoy y false en caso contrario
     * @return bool
     **/
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

    //Validar que una fecha con hora sea válida
    public function isDataTime($date, $format = 'Y-m-d H:i'){

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

    //Validar token
    public function validateToken($header) {
        if (!isset($header['Authorization']) || empty($header['Authorization'])) {

            return false;
        } else {

            $token = $header['Authorization'];
            return substr($token, 7);
        }
    }
}
?>