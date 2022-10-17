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
Router::put('/usuarios/actualizar/:id', UsuarioController::class . '@actualizarUsuario');
Router::delete('/usuarios/eliminar/:id', UsuarioController::class . '@eliminarUsuario');

//Pacientes - Vistas
Router::get('/pacientes',PacienteController::class . '@index');
Router::get('/pacientes/registrar', PacienteController::class . '@formRegistrarPaciente');
Router::get('/pacientes/actualizar/:id', PacienteController::class . '@formActualizarPaciente');

//Pacientes - API
Router::get('/pacientes/consulta',PacienteController::class . '@listarPacientes');
Router::get('/pacientes/:id',PacienteController::class . '@listarPacientePorId');
Router::post('/pacientes', PacienteController::class . '@insertarPaciente');
Router::put('/pacientes/:id', PacienteController::class . '@actualizarPaciente');
Router::delete('/pacientes/:id', PacienteController::class . '@eliminarPaciente')


?>