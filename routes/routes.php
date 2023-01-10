<?php

//Login - vista
Router::get('/login',LoginController::class . '@index');

//Login - API
Router::post('/login',LoginController::class . '@entrar');

//Ruta principal
Router::get('/',homepageController::class);

//Home - Vista
Router::get('/home',homepageController::class . '@index');

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

//PacienteSeguro - API
Router::put('/paciente/seguro/:id', PacienteSeguroController::class . '@actualizarPacienteSeguro');

//Medicos - Vistas
Router::get('/medicos',MedicoController::class . '@index');
Router::get('/medicos/registrar', MedicoController::class . '@formRegistrarMedico');
Router::get('/medicos/actualizar/:id', MedicoController::class . '@formActualizarMedico');

//Medicos - API
Router::get('/medicos/consulta',MedicoController::class . '@listarmedicos');
Router::get('/medicos/:id',MedicoController::class . '@listarMedicoPorId');
Router::get('/medicos/cedula/:ci',MedicoController::class . '@listarMedicoPorCI');
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

//Meidco-Especialidad - API
Router::get('/medico_especialidades/consulta',EspecialidadController::class . '@listarMedicosEspecialidades');
Router::get('/medico_especialidades/:id',EspecialidadController::class . '@listarMedicosEspecialidadPorId');
Router::post('/medico_especialidades/:post', EspecialidadController::class . '@insertarMedicoEspecialidad');
Router::put('/medico_especialidades/:id', EspecialidadController::class . '@actualizarMedicoEspecialidad');
Router::delete('/medico_especialidades/:id', EspecialidadController::class . '@eliminarMedicoEspecialidad');


//Horarios - Vistas
Router::get('/horarios',HorarioController::class . '@index');
Router::get('/horarios/registrar', HorarioController::class . '@formRegistrarHorario');
Router::get('/horarios/actualizar/:id', HorarioController::class . '@formActualizarHorario');

//Horarios - API
Router::get('/horarios/consulta',HorarioController::class . '@listarHorarios');
Router::get('/horarios/:id',HorarioController::class . '@listarHorarioPorId');
Router::post('/horarios', HorarioController::class . '@insertarHorario');
Router::put('/horarios/:id', HorarioController::class . '@actualizarHorario');
Router::delete('/horarios/:id', HorarioController::class . '@eliminarHorario');

//Seguros - Vistas
Router::get('/seguros',SeguroController::class . '@index');
Router::get('/seguros/registrar', SeguroController::class . '@formRegistrarSeguro');
Router::get('/seguros/actualizar/:id', SeguroController::class . '@formActualizarSeguro');

//Seguros - API
Router::get('/seguros/consulta',SeguroController::class . '@listarSeguros');
Router::get('/seguros/:id',SeguroController::class . '@listarSeguroPorId');
Router::post('/seguros', SeguroController::class . '@insertarSeguro');
Router::put('/seguros/:id', SeguroController::class . '@actualizarSeguro');
Router::delete('/seguros/:id', SeguroController::class . '@eliminarSeguro');

//Empresa - Vistas
Router::get('/empresas',EmpresaController::class . '@index');
Router::get('/empresas/registrar', EmpresaController::class . '@formRegistrarEmpresa');
Router::get('/empresas/actualizar/:id', EmpresaController::class . '@formActualizarEmpresa');

//Empresa - API
Router::get('/empresas/consulta',EmpresaController::class . '@listarEmpresas');
Router::get('/empresas/:id',EmpresaController::class . '@listarEmpresaPorId');
Router::post('/empresas', EmpresaController::class . '@insertarEmpresa');
Router::put('/empresas/:id', EmpresaController::class . '@actualizarEmpresa');
Router::delete('/empresas/:id', EmpresaController::class . '@eliminarEmpresa');

//Cita - Vistas
Router::get('/citas',CitaController::class . '@index');
Router::get('/citas/registrar', CitaController::class . '@formRegistrarCita');
Router::get('/citas/actualizar/:id', CitaController::class . '@formActualizarCita');

//Cita - API
Router::get('/citas/consulta',CitaController::class . '@listarCitas');
Router::get('/citas/:id',CitaController::class . '@listarCitaPorId');
Router::get('/citas/paciente/:id',CitaController::class . '@listarCitaPorPacienteId');
Router::post('/citas', CitaController::class . '@insertarCita');
Router::put('/citas/:id', CitaController::class . '@actualizarCita');
Router::delete('/citas/:id', CitaController::class . '@eliminarCita');

//Consulta - Vistas
Router::get('/consultas',ConsultaController::class . '@index');
Router::get('/consultas/registrar', ConsultaController::class . '@formRegistrarConsulta');
Router::get('/consultas/actualizar/:id', ConsultaController::class . '@formActualizarConsulta');

//Consulta - API
Router::get('/consultas/consulta',ConsultaController::class . '@listarConsultas');
Router::get('/consultas/:id',ConsultaController::class . '@listarConsultaPorId');
Router::post('/consultas', ConsultaController::class . '@insertarConsulta');
Router::put('/consultas/:id', ConsultaController::class . '@actualizarConsulta');
Router::delete('/consultas/:id', ConsultaController::class . '@eliminarConsulta');

//Consulta - Vistas
Router::get('/examenes',ExamenController::class . '@index');
Router::get('/examenes/registrar', ExamenController::class . '@formRegistrarExamen');
Router::get('/examenes/actualizar/:id', ExamenController::class . '@formActualizarExamen');

//Consulta - API
Router::get('/examenes/consulta',ExamenController::class . '@listarExamen');
Router::get('/examenes/:id',ExamenController::class . '@listarExamenPorId');
Router::post('/examenes', ExamenController::class . '@insertarExamen');
Router::put('/examenes/:id', ExamenController::class . '@actualizarExamen');
Router::delete('/examenes/:id', ExamenController::class . '@eliminarExamen');

//Proveedor - Vistas
Router::get('/proveedores',ProveedorController::class . '@index');
Router::get('/proveedores/registrar', ProveedorController::class . '@formRegistrarProveedor');
Router::get('/proveedores/actualizar/:id', ProveedorController::class . '@formActualizarProveedor');

//Proveedor - API
Router::get('/proveedores/consulta',ProveedorController::class . '@listarProveedor');
Router::get('/proveedores/:id',ProveedorController::class . '@listarProveedorPorId');
Router::post('/proveedores', ProveedorController::class . '@insertarProveedor');
Router::put('/proveedores/:id', ProveedorController::class . '@actualizarProveedor');
Router::delete('/proveedores/:id', ProveedorController::class . '@eliminarProveedor');

//Insumo - Vistas
Router::get('/insumos',InsumoController::class . '@index');
Router::get('/insumos/registrar', InsumoController::class . '@formRegistrarInsumo');
Router::get('/insumos/actualizar/:id', InsumoController::class . '@formActualizarInsumo');

//Insumo - API
Router::get('/insumos/consulta',InsumoController::class . '@listarInsumo');
Router::get('/insumos/:id',InsumoController::class . '@listarInsumoPorId');
Router::post('/insumos', InsumoController::class . '@insertarInsumo');
Router::put('/insumos/:id', InsumoController::class . '@actualizarInsumo');
Router::delete('/insumos/:id', InsumoController::class . '@eliminarInsumo');

//Factura_Compra - Vistas
Router::get('/factura/compra',FacturaCompraController::class . '@index');
Router::get('/factura/compra/registrar', FacturaCompraController::class . '@formRegistrarFacturaCompra');
Router::get('/factura/compra/actualizar/:id', FacturaCompraController::class . '@formActualizarFacturaCompra');

//Factura_Compra - API
Router::get('/factura/compra/consulta',FacturaCompraController::class . '@listarFacturaCompra');
Router::get('/factura/compra/:id',FacturaCompraController::class . '@listarFacturaCompraPorId');
Router::post('/factura/compra', FacturaCompraController::class . '@insertarFacturaCompra');
Router::put('/factura/compra/:id', FacturaCompraController::class . '@actualizarFacturaCompra');
Router::delete('/factura/compra/:id', FacturaCompraController::class . '@eliminarFacturaCompra');

//Compra_Insumo - API
Router::get('/factura/insumos/:id',CompraInsumoController::class . '@listarCompraInsumoPorFactura');

//Factura_Seguro - Vistas
Router::get('/factura/seguro',FacturaSeguroController::class . '@index');
Router::get('/factura/seguro/registrar', FacturaSeguroController::class . '@formRegistrarFacturaSeguro');
Router::get('/factura/seguro/actualizar/:id', FacturaSeguroController::class . '@formActualizarFacturaSeguro');

//Factura_Seguro - API
Router::get('/factura/seguro/consulta',FacturaSeguroController::class . '@listarFacturaSeguro');
Router::get('/factura/seguro/:id',FacturaSeguroController::class . '@listarFacturaSeguroPorId');
Router::post('/factura/seguro', FacturaSeguroController::class . '@insertarFacturaSeguro');
Router::put('/factura/seguro/:id', FacturaSeguroController::class . '@actualizarFacturaSeguro');
Router::delete('/factura/seguro/:id', FacturaSeguroController::class . '@eliminarFacturaSeguro');

//Factura_Consulta - Vistas
Router::get('/factura/consulta',FacturaConsultaController::class . '@index');
Router::get('/factura/consulta/registrar', FacturaConsultaController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/consulta/actualizar/:id', FacturaConsultaController::class . '@formActualizarFacturaConsulta');

//Factura_Consulta - API
Router::get('/factura/consulta/consulta',FacturaConsultaController::class . '@listarFacturaConsulta');
Router::get('/factura/consulta/:id',FacturaConsultaController::class . '@listarFacturaConsultaPorId');
Router::post('/factura/consulta', FacturaConsultaController::class . '@insertarFacturaConsulta');
Router::put('/factura/consulta/:id', FacturaConsultaController::class . '@actualizarFacturaConsulta');
Router::delete('/factura/consulta/:id', FacturaConsultaController::class . '@eliminarFacturaConsulta');

//Factura_Medico - Vistas
Router::get('/factura/medico',FacturaConsultaController::class . '@index');
Router::get('/factura/medico/registrar', FacturaConsultaController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/medico/actualizar/:id', FacturaConsultaController::class . '@formActualizarFacturaConsulta');

//Factura_Medico - API
Router::get('/factura/medico/consulta',FacturaMedicoController::class . '@listarFacturaMedico');
Router::get('/factura/medico/:id',FacturaMedicoController::class . '@listarFacturaMedicoPorId');
Router::get('/factura/medico/medico/:id',FacturaMedicoController::class . '@listarFacturaPorMedico');
Router::get('/factura/fecha/',FacturaMedicoController::class . '@listarFacturaPorFecha');
Router::post('/factura/medico', FacturaMedicoController::class . '@solicitarFacturaMedico');
Router::put('/factura/medico/:id', FacturaMedicoController::class . '@actualizarFacturaMedico');
Router::delete('/factura/medico/:id', FacturaMedicoController::class . '@eliminarFacturaMedico');

?>