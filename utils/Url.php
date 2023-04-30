<?php

class Url{

    //Método para obtener la ruta base del proyecto
    public static function base(){

        $base_dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
        $baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://{$_SERVER['HTTP_HOST']}{$base_dir}";

        return trim($baseUrl, '/');
    }

    //Método para usar la ruta base + otra ruta
    public static function to($url){

        $url = trim($url, '/');
        return Url::base() . "/{$url}";
    }

    //Método para obtener toda la ruta, pero orientada para producción
    public static function getFull(){

        return (isset($_SERVER['HTTPS']) ? 'https' : 'http') . "://{$_SERVER['HTTPS_HOST']}{$_SERVER['REQUEST_URI']}";
    }
}



?>