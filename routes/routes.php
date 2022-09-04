<?php

//Ruta principal
Router::get('/',homepageController::class);

//Usuario - Vistas
Router::get('/usuarios',UsuarioController::class . '@index');
Router::get('/usuarios/registrar', UsuarioController::class . '@formRegistrarUsuario');
Router::get('/usuarios/actualizar/:id', UsuarioController::class . '@formActualizarUsuarios');

//Usuario - API
Router::get('/usuarios/consulta',UsuarioController::class . '@listarUsuarios');
Router::get('/usuarios/consulta/:id',UsuarioController::class . '@listarUsuarioPorId');
Router::post('/usuarios/registrar', UsuarioController::class . '@insertarUsuario');
Router::put('/usuarios/actualizar', UsuarioController::class . '@actualizarUsuario');
Router::delete('/usuarios/eliminar/:id', UsuarioController::class . '@eliminarUsuario')



?>