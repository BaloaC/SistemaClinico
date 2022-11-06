<?php

//Login - vista
Router::get('/login',LoginController::class . '@index');

//Login - API
Router::post('/login',LoginController::class . '@entrar');

//Ruta principal
Router::get('/',welcomeController::class);

//Ruta de pruebas
Router::get('/test',welcomeController::class . '@test');

//Home - Vista
Router::get('/home',homepageController::class . '@index');

//Usuario - Vistas
Router::get('/usuarios',UsuarioController::class . '@index');
Router::get('/usuarios/registrar', UsuarioController::class . '@formRegistrarUsuario');
Router::get('/usuarios/actualizar/:id', UsuarioController::class . '@formActualizarUsuarios');

//Usuario - API
Router::get('/usuarios/consulta',UsuarioController::class . '@listarUsuarios');
Router::get('/usuarios/consulta/:id',UsuarioController::class . '@listarUsuarioPorId');
Router::post('/usuarios/registrar', UsuarioController::class . '@insertarUsuario');
Router::put('/usuarios/actualizar', UsuarioController::class . '@actualizarUsuario');
Router::delete('/usuarios/eliminar/:id', UsuarioController::class . '@eliminarUsuario');

//Pacientes - API
Router::get('/pacientes/consulta',PacienteController::class . '@listarPacientes');
Router::get('/pacientes/:id',PacienteController::class . '@listarPacientePorId');
Router::post('/pacientes', PacienteController::class . '@insertarPaciente');
Router::put('/pacientes/:id', PacienteController::class . '@actualizarPaciente');
Router::delete('/pacientes/:id', PacienteController::class . '@eliminarPaciente')


?>