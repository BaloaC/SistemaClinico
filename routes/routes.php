<?php

//Ruta principal
Router::get('/',UsuarioController::class);

Router::get('/listarusuarios',UsuarioController::class . '@listarUsuarios');
Router::get('/registrarusuario', UsuarioController::class . '@formRegistrarUsuario');

Router::post('/registrarusuario/registrar', UsuarioController::class . '@insertarUsuario');


Router::get('/hola',function(Request $hola){
    return 'hola' . $hola->hola;
});

Router::get('/hola/:id', function($id,Request $hola){
    echo $id;
});

Router::patch('/patch', function(Request $hola){
    return 'esto es un patch';
});




?>