<?php

//Requerimos todos los archivos necesarios para ejectuar el autoloader
require 'config/config.php';
require 'autoloader/Autoloader.php';

//Ejecutamos el autoloader
Autoloader::register();

$routes = scandir(PATH_ROUTES);

//Requerimos todos los archivos de la carpeta routes
foreach($routes as $file){

    $pathFile = realpath(PATH_ROUTES . $file);
    
    if(is_file($pathFile)){

        require $pathFile;
    }
}

//Ejecutamos el enrutador
Router::submit();
?>