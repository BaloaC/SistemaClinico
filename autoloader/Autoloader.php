<?php

class Autoloader{

    //Método para registrar el autoloader
    public static function register(){

        if(function_exists('__autoload')){

            spl_autoload_register('__autoload');
            return;
        }

        //Si se quiere validar la version del php usar version_compare();
        spl_autoload_register(array('Autoloader','upload'), true, true);
    }

    //Método para determinar las clases que necesitan y requerirlas en el autoloader
    public static function upload($class){

        $fileName = $class . '.php';
        
        $folders = require PATH_CONFIG . 'autoloader.php';

        //Recorremos las carpetas y si encuentra la clase retornamos true para requerirla
        foreach($folders as $folder){
            
            if(self::findFile($folder,$fileName)){

                return true;
            }
        }   
        return false;
    }

    //Método para encotrar las clases y requerirlas
    private static function findFile($folder, $fileName){
        
        //Obtenemos todos los archivos
        $files = scandir($folder);
       
        foreach($files as $file){
            
            $pathFile = realpath($folder.DIRECTORY_SEPARATOR.$file);
            
            //Validamos que la ruta sea un archivo
            if(is_file($pathFile)){

                //Si el nombre del archivo concuerdan, la requerimos
                if($fileName === $file){

                    require_once $pathFile;
                    return true;
                }

            //Si el archivo es distinto del '.' y '..' seguimos buscando
            } elseif($file != '.' && $file != '..'){

                return self::findFile($pathFile,$fileName);
            }
        }
        
        return false;
    }
}


?>