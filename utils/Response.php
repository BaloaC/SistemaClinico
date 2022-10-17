<?php

class Response{

    public $code;
    public $message;
    public $data;

    public function __construct($code = null, $message = null, $data = null){
        
        //Validamos si se envía el código y no un mensaje para asignar el mensaje por defecto
        if(isset($code) && empty($message)){

            $response = self::getDefaultMessage($code);

            $this->code = $response[0];
            $this->message = $response[1];
            $this->data = $data;
            return;
        }

        //Validamos por si se envia un código por defecto
        if(is_string($code)){
            
            $response = self::getDefaultMessage($code);
            $code = $response[0];
        }

        $this->code = $code;
        $this->message = $message;
        $this->data = $data;
    }

    //Método para enviar la respuesta en formato JSON
    public function json($status, $obj = null){

        header('Content-Type: application/json; charset=utf-8');
        http_response_code($status);

        //Validamos si se envía un objeto/array y lo retornamos en caso de true
        if(is_array($obj) || is_object($obj)){
            return json_encode($obj);
        }

        return json_encode($this);
    }

    //Método para obtener el mensaje por defecto, en caos de querer añadir alguno simplemente crear un 'case'
    private static function getDefaultMessage($code){

        switch($code){

            case 'CORRECTO':
                return [true, 'Se ha realizado la operación de manera exitosa!'];

            case 'INSERCION_EXITOSA':
                return [true,'201, Se ha insertado el registro correctamente!'];

            case 'ACTUALIZACION_EXITOSA':
                return [true, '201, Se ha actualizado el registro correctamente!'];

            case 'ELIMINACION_EXITOSA':
                return [true, 'Se ha eliminado el registro correctamente!'];

            case 'ERROR':
                return [false, 'Se ha producido un error al realizar la operación']; 

            case 'INSERCION_FALLIDA':
                return [false, '400, No se ha insertado correctamente el registro'];

            case 'ACTUALIZACION_FALLIDA':
                return [false, 'No se ha actualizado correctamente el registro'];

            case 'ELIMINACION_FALLIDA':
                return [false, 'No se ha eliminado correctamente el registro'];

            case 'DATOS_INVALIDOS':
                    return [false, '400, Faltan datos o los datos son inválidos'];
            
            case 'DATOS_DUPLICADOS':
                return [false, '400, Ya existe un registro con la misma información'];

            default: 
                return [false, 'No se ha establecido ningún mensaje'];
        }
    }

    /* Getters */
    public function getCode(){return $this->code;}
    public function getMessage(){return $this->message;}
    public function getData(){return $this->data;}
    
    /* Setters */
    public function setCode($code){$this->code = $code;}
    public function setMessage($message){$this->message = $message;}
    public function setData($data){$this->data = $data;}

}




?>