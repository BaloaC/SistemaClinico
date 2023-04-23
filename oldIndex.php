<?php

// require_once 'database/database.php';
// require_once 'models/BaseModel.php';
// require_once 'models/GenericModel.php';
// require_once 'models/UsuarioModel.php';
// require_once 'controllers/UsuarioController.php';
// require_once 'utils/Response.php';

require_once 'config/config.php';
require_once 'autoloader/Autoloader.php';

Autoloader::register();


$_controller = new UsuarioController();
$request = $_controller->listarUsuarios();

$_baseModel = new UsuarioModel();

// $_baseModel->setNombres('Franciss');
// $_baseModel->where('usuarios_id','=',3)->update();


// echo $resultado = $_baseModel->insert($obj);


// echo $_baseModel->where('usuarios_id','=',3)->update(["nombres" => 'Francis']);

// echo $_baseModel->where('usuarios_id','=',4)->delete();

$datos = $_baseModel->where('usuarios_id','!=',0)
                    ->orWhere('nombres','=','Enrique')
                    ->getAll();
var_dump($request);

echo 'hola';

echo '<pre>';
var_dump($datos);
echo '</pre>';




?>