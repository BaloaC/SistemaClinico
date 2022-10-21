<?php

//Login - vista
Router::get('/login',LoginController::class . '@index');

//Login - API
Router::post('/login',LoginController::class . '@entrar');

//Ruta principal
Router::get('/',homepageController::class);

//Usuario - Vistas
Router::get('/usuarios',UsuarioController::class . '@index');
Router::get('/usuarios/registrar', UsuarioController::class . '@formRegistrarUsuario');
Router::get('/usuarios/actualizar/:id', UsuarioController::class . '@formActualizarUsuarios');

//Usuario - API
Router::get('/usuarios/consulta',UsuarioController::class . '@listarUsuarios');
Router::get('/usuarios/:id',UsuarioController::class . '@listarUsuarioPorId');
Router::post('/usuarios', UsuarioController::class . '@insertarUsuario');
Router::put('/usuarios/:id', UsuarioController::class . '@actualizarUsuario');
Router::delete('/usuarios/:id', UsuarioController::class . '@eliminarUsuario');

//Pacientes - Vistas
Router::get('/pacientes',PacienteController::class . '@index');
Router::get('/pacientes/registrar', PacienteController::class . '@formRegistrarPaciente');
Router::get('/pacientes/actualizar/:id', PacienteController::class . '@formActualizarPaciente');

//Pacientes - API
Router::get('/pacientes/consulta',PacienteController::class . '@listarPacientes');
Router::get('/pacientes/:id',PacienteController::class . '@listarPacientePorId');
Router::post('/pacientes', PacienteController::class . '@insertarPaciente');
Router::put('/pacientes/:id', PacienteController::class . '@actualizarPaciente');
Router::delete('/pacientes/:id', PacienteController::class . '@eliminarPaciente');

//Medicos - Vistas
Router::get('/medicos',MedicoController::class . '@index');
Router::get('/medicos/registrar', MedicoController::class . '@formRegistrarMedico');
Router::get('/medicos/actualizar/:id', MedicoController::class . '@formActualizarMedico');

//Medicos - API
Router::get('/medicos/consulta',MedicoController::class . '@listarmedicos');
Router::get('/medicos/:id',MedicoController::class . '@listarMedicoPorId');
Router::post('/medicos', MedicoController::class . '@insertarMedico');
Router::put('/medicos/:id', MedicoController::class . '@actualizarMedico');
Router::delete('/medicos/:id', MedicoController::class . '@eliminarMedico');

//Especialidad - Vistas
Router::get('/especialidades',EspecialidadController::class . '@index');
Router::get('/especialidades/registrar', EspecialidadController::class . '@formRegistrarEspecialidad');
Router::get('/especialidades/actualizar/:id', EspecialidadController::class . '@formActualizarEspecialidad');

//Especialidad - API
Router::get('/especialidades/consulta',EspecialidadController::class . '@listarEspecialidades');
Router::get('/especialidades/:id',EspecialidadController::class . '@listarEspecialidadPorId');
Router::post('/especialidades', EspecialidadController::class . '@insertarEspecialidad');
Router::put('/especialidades/:id', EspecialidadController::class . '@actualizarEspecialidad');
Router::delete('/especialidades/:id', EspecialidadController::class . '@eliminarEspecialidad');
?>