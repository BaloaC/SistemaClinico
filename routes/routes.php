<?php

//Auditoria - API
Router::get('/auditoria/consulta', AuditoriaController::class . '@listarAuditoria', 1);
Router::post('/auditoria/fecha', AuditoriaController::class . '@listarAuditoriaPorFecha', 1);
Router::post('/auditoria/accion', AuditoriaController::class . '@listarAuditoriaPorAccion', 1);
Router::get('/auditoria/:id', AuditoriaController::class . '@listarAuditoriaPorUsuario', 1);

//Auditoria - Vista
Router::get("/auditoria", AuditoriaController::class . '@index');

// PDF - Vista
Router::get("/pdf/seguros", PdfController::class . '@pdf_seguro');
Router::get("/pdf/facturacompra/:id", PdfController::class . '@pdf_facturaCompra', -1);
Router::get("/pdf/facturaconsulta/:id", PdfController::class . '@pdf_facturaConsulta', -1);
Router::get("/pdf/facturaseguro/:id", PdfController::class . '@pdf_facturaSeguro', -1);
Router::get("/pdf/facturamedico/:id", PdfController::class . '@pdf_facturaMedico', -1);
Router::get("/pdf/consulta/:id", PdfController::class . '@pdf_consulta', -1);
Router::get("/pdf/insumosfaltantes", PdfController::class . '@pdf_InsumosFaltantes', -1);
Router::get("/pdf/historialmedico/:id", PdfController::class . '@pdf_historialMedico', -1);
Router::get("/pdf/cita/:id", PdfController::class . '@pdf_citas', -1);

//Login - vista
Router::get('/login', LoginController::class . '@index');
Router::get('/login/recuperarusuario', LoginController::class . '@recuperarUsuarioView');

//Login - API
Router::post('/login', LoginController::class . '@entrar', -1);
Router::post('/login/:id', LoginController::class . '@recuperarUsuario', -1);

//Preguntas - API
Router::get('/preguntas/consulta', PreguntaSeguridadController::class . '@listarPreguntas', -1);
Router::get('/preguntas/:id', PreguntaSeguridadController::class . '@listarPreguntasPorId', -1);
Router::get('/preguntas/usuario/:id', PreguntaSeguridadController::class . '@listarPreguntasPorUsuarioId', -1);
Router::post('/pregunta/:id', PreguntaSeguridadController::class . '@insertarPregunta', -1);
Router::post('/respuesta/:id', PreguntaSeguridadController::class . '@comprobarPregunta', -1);

//Ruta principal
Router::get('/', LoginController::class . '@index');

//Home - Vista
Router::get('/home', homepageController::class . '@index');

//Usuario - Vistas
Router::get('/usuarios', UsuarioController::class . '@index');
Router::get('/usuarios/registrar', UsuarioController::class . '@formRegistrarUsuario');
Router::get('/usuarios/actualizar/:id', UsuarioController::class . '@formActualizarUsuarios');

//Usuario - API
Router::get('/usuarios/consulta', UsuarioController::class . '@listarUsuarios', '1');
Router::get('/usuarios/:id', UsuarioController::class . '@listarUsuarioPorId', '1');
Router::post('/usuarios', UsuarioController::class . '@insertarUsuario', -1);
Router::put('/usuarios/:id', UsuarioController::class . '@actualizarUsuario', -1);
Router::delete('/usuarios/:id', UsuarioController::class . '@eliminarUsuario', '1');

//Pacientes - Vistas
Router::get('/pacientes', PacienteController::class . '@index');
Router::get('/pacientes/registrar', PacienteController::class . '@formRegistrarPaciente');
Router::get('/pacientes/actualizar/:id', PacienteController::class . '@formActualizarPaciente');

//Pacientes - API
Router::get('/pacientes/consulta', PacienteController::class . '@listarPacientes', '1,2,4,5');
Router::get('/pacientes/:id', PacienteController::class . '@listarPacientePorId', '1,2,4,5');
Router::post('/pacientes', PacienteController::class . '@insertarPaciente', '1,2,5');
Router::put('/pacientes/:id', PacienteController::class . '@actualizarPaciente', '1,2,5');
Router::delete('/pacientes/:id', PacienteController::class . '@eliminarPaciente', '1,2,5');

//PacienteSeguro - API
Router::delete('/paciente/seguro/:id', PacienteSeguroController::class . '@eliminarPacienteSeguro', '1,2,5');

//Paciente Beneficiado - API
Router::get('/beneficiado/consulta', PacienteBeneficiadoController::class . '@listarPacienteBeneficiadoId', '1,2,4,5');
Router::delete('/beneficiado/:id', PacienteBeneficiadoController::class . '@eliminarPacienteBeneficiado', '1,2,4,5');

//Titular - API
Router::post('/titular/:id', TitularBeneficiadoController::class . '@insertarTitularBeneficiado', '1,2,5');
Router::get('/titulares/:id', TitularBeneficiadoController::class . '@listarTitularesDePacienteBeneficiadoId', '1,2,4,5');
Router::get('/titularesBeneficiado/:id', TitularBeneficiadoController::class . '@listarPacienteBeneficiadoDeTitularId', '1,2,4,5');
Router::delete('/titular/:id', TitularBeneficiadoController::class . '@eliminarTitularBeneficiado', '1,2,5');

//Paciente Beneficiado - API
Router::delete('/pacienteBeneficiado/:id', PacienteBeneficiadoController::class . '@eliminarPacienteBeneficiado', '1,2,5');

//Medicos - Vistas
Router::get('/medicos', MedicoController::class . '@index');
Router::get('/medicos/registrar', MedicoController::class . '@formRegistrarMedico');
Router::get('/medicos/actualizar/:id', MedicoController::class . '@formActualizarMedico');

//Medicos - API
Router::get('/medicos/consulta', MedicoController::class . '@listarmedicos', '1,2,4');
Router::get('/medicos/:id', MedicoController::class . '@listarMedicoPorId', '1,2,4');
Router::get('/medicos/cedula/:ci', MedicoController::class . '@listarMedicoPorCI', '1,2,4');
Router::post('/medicos', MedicoController::class . '@insertarMedico', '1,2');
Router::put('/medicos/:id', MedicoController::class . '@actualizarMedico', '1,2');
Router::delete('/medicos/:id', MedicoController::class . '@eliminarMedico', '1,2');

//Medicos_especialidad - API
Router::delete('/medicos/especialidad/:id', MedicoEspecialidadController::class . '@eliminarMedicoEspecialidad', '1,2');

//Especialidad - Vistas
Router::get('/especialidades', EspecialidadController::class . '@index');
Router::get('/especialidades/registrar', EspecialidadController::class . '@formRegistrarEspecialidad');
Router::get('/especialidades/actualizar/:id', EspecialidadController::class . '@formActualizarEspecialidad');

//Especialidad - API
Router::get('/especialidades/consulta', EspecialidadController::class . '@listarEspecialidades', '1,2,4,5');
Router::get('/especialidades/:id', EspecialidadController::class . '@listarEspecialidadPorId', '1,2,4,5');
Router::post('/especialidades', EspecialidadController::class . '@insertarEspecialidad', '1,2');
Router::put('/especialidades/:id', EspecialidadController::class . '@actualizarEspecialidad', '1,2');
Router::delete('/especialidades/:id', EspecialidadController::class . '@eliminarEspecialidad', '1,2');

//Horarios - Vistas
Router::get('/horarios', HorarioController::class . '@index');
Router::get('/horarios/registrar', HorarioController::class . '@formRegistrarHorario');
Router::get('/horarios/actualizar/:id', HorarioController::class . '@formActualizarHorario');

//Horarios - API
Router::get('/horarios/consulta', HorarioController::class . '@listarHorarios', '1,2,4,5');
Router::get('/horarios/:id', HorarioController::class . '@listarHorarioPorId', '1,2,4,5');
Router::delete('/horarios/:id', HorarioController::class . '@eliminarHorario', '1,2,5');

//Seguros - Vistas
Router::get('/seguros', SeguroController::class . '@index');
Router::get('/seguros/registrar', SeguroController::class . '@formRegistrarSeguro');
Router::get('/seguros/actualizar/:id', SeguroController::class . '@formActualizarSeguro');

//Seguros - API
Router::get('/seguros/consulta', SeguroController::class . '@listarSeguros', '1,2,4');
Router::get('/seguros/:id', SeguroController::class . '@listarSeguroPorId', '1,2,4');
Router::post('/seguros', SeguroController::class . '@insertarSeguro', '1,2');
Router::put('/seguros/:id', SeguroController::class . '@actualizarSeguro', '1,2');
Router::delete('/seguros/:id', SeguroController::class . '@eliminarSeguro', '1,2');

//Empresa - Vistas
Router::get('/empresas', EmpresaController::class . '@index');
Router::get('/empresas/registrar', EmpresaController::class . '@formRegistrarEmpresa');
Router::get('/empresas/actualizar/:id', EmpresaController::class . '@formActualizarEmpresa');

//Empresa - API
Router::get('/empresas/consulta', EmpresaController::class . '@listarEmpresas', '1,2,4,5');
Router::get('/empresas/:id', EmpresaController::class . '@listarEmpresaPorId', '1,2,4,5');
Router::post('/empresas', EmpresaController::class . '@insertarEmpresa', '1,2');
Router::put('/empresas/:id', EmpresaController::class . '@actualizarEmpresa', '1,2');
Router::delete('/empresas/:id', EmpresaController::class . '@eliminarEmpresa', '1,2');

// SeguroEmpresa
Router::delete("/seguroempresa/:id", SeguroEmpresaController::class . '@eliminarSeguroEmpresa', '1,2');

//Cita - Vistas
Router::get('/citas', CitaController::class . '@index');
Router::get('/citas/registrar', CitaController::class . '@formRegistrarCita');
Router::get('/citas/actualizar/:id', CitaController::class . '@formActualizarCita');

//Cita - API
Router::get('/citas/consulta', CitaController::class . '@listarCitas',  '1,2,4,5');
Router::get('/citas/:id', CitaController::class . '@listarCitaPorId',  '1,2,4,5');
Router::get('/citas/paciente/:id', CitaController::class . '@listarCitaPorPacienteId',  '1,2,4,5');
Router::post('/citas', CitaController::class . '@insertarCita',  '1,2,5');
Router::put('/citas/:id', CitaController::class . '@actualizarCita',  '1,2,4,5');
Router::delete('/citas/:id', CitaController::class . '@eliminarCita',  '1,2,5');

//Consulta - Vistas
Router::get('/consultas', ConsultaController::class . '@index');
Router::get('/consultas/registrar', ConsultaController::class . '@formRegistrarConsulta');
Router::get('/consultas/actualizar/:id', ConsultaController::class . '@formActualizarConsulta');

//Consulta - API
Router::get('/consultas/consulta', ConsultaController::class . '@listarConsultas',  '1,2,4,5');
Router::get('/consultas/:id', ConsultaController::class . '@listarConsultaPorId',  '1,2,4,5');
Router::post('/consultas', ConsultaController::class . '@insertarConsulta',  '1,2,4,5');
Router::put('/consultas/:id', ConsultaController::class . '@actualizarConsulta',  '1,2,4,5');
Router::delete('/consultas/:id', ConsultaController::class . '@eliminarConsulta',  '1,2');

//Exámenes - Vistas
Router::get('/examenes', ExamenController::class . '@index');
Router::get('/examenes/registrar', ExamenController::class . '@formRegistrarExamen');
Router::get('/examenes/actualizar/:id', ExamenController::class . '@formActualizarExamen');

//Exámenes - API
Router::get('/examenes/consulta', ExamenController::class . '@listarExamen',  '1,2,4,5');
Router::get('/examenes/:id', ExamenController::class . '@listarExamenPorId',  '1,2,4,5');
Router::post('/examenes', ExamenController::class . '@insertarExamen',  '1,2');
Router::put('/examenes/:id', ExamenController::class . '@actualizarExamen',  '1,2');
Router::delete('/examenes/:id', ExamenController::class . '@eliminarExamen',  '1,2');

//Proveedor - Vistas
Router::get('/proveedores', ProveedorController::class . '@index');
Router::get('/proveedores/registrar', ProveedorController::class . '@formRegistrarProveedor');
Router::get('/proveedores/actualizar/:id', ProveedorController::class . '@formActualizarProveedor');

//Proveedor - API
Router::get('/proveedores/consulta', ProveedorController::class . '@listarProveedor',  '1,2');
Router::get('/proveedores/:id', ProveedorController::class . '@listarProveedorPorId',  '1,2');
Router::post('/proveedores', ProveedorController::class . '@insertarProveedor', '1,2');
Router::put('/proveedores/:id', ProveedorController::class . '@actualizarProveedor', '1,2');
Router::delete('/proveedores/:id', ProveedorController::class . '@eliminarProveedor', '1,2');

//Insumo - Vistas
Router::get('/insumos', InsumoController::class . '@index');
Router::get('/insumos/registrar', InsumoController::class . '@formRegistrarInsumo');
Router::get('/insumos/actualizar/:id', InsumoController::class . '@formActualizarInsumo');

//Insumo - API
Router::get('/insumos/consulta', InsumoController::class . '@listarInsumo', '1,2');
Router::get('/insumos/:id', InsumoController::class . '@listarInsumoPorId', '1,2');
Router::post('/insumos', InsumoController::class . '@insertarInsumo', '1,2');
Router::put('/insumos/:id', InsumoController::class . '@actualizarInsumo', '1,2');
Router::delete('/insumos/:id', InsumoController::class . '@eliminarInsumo', '1,2');

//Factura_Compra - Vistas
Router::get('/factura/compra', FacturaCompraController::class . '@index');
Router::get('/factura/compra/registrar', FacturaCompraController::class . '@formRegistrarFacturaCompra');
Router::get('/factura/compra/actualizar/:id', FacturaCompraController::class . '@formActualizarFacturaCompra');

//Factura_Compra - API
Router::get('/factura/compra/consulta', FacturaCompraController::class . '@listarFacturaCompra', '1.2,3');
Router::get('/factura/compra/:id', FacturaCompraController::class . '@listarFacturaCompraPorId', '1,2,3');
Router::post('/factura/compra', FacturaCompraController::class . '@insertarFacturaCompra', '1,2,3');
Router::put('/factura/compra/:id', FacturaCompraController::class . '@actualizarFacturaCompra', '1,2,3');
Router::delete('/factura/compra/:id', FacturaCompraController::class . '@eliminarFacturaCompra', '1,2,3');

//Compra_Insumo - API
Router::get('/factura/insumos/:id', CompraInsumoController::class . '@listarCompraInsumoPorFactura');

//Factura_Seguro - Vistas
Router::get('/factura/seguro', FacturaSeguroController::class . '@index');
Router::get('/factura/seguro/registrar', FacturaSeguroController::class . '@formRegistrarFacturaSeguro');
Router::get('/factura/seguro/actualizar/:id', FacturaSeguroController::class . '@formActualizarFacturaSeguro');

//Factura_Seguro - API
Router::get('/factura/seguro/consulta', FacturaSeguroController::class . '@listarFacturaSeguro', '1,2,3');
Router::get('/factura/seguro/:id', FacturaSeguroController::class . '@listarFacturaSeguroPorId', '1,2,3');
Router::post('/factura/seguro', FacturaSeguroController::class . '@insertarFacturaSeguro', '1,2,3');
Router::put('/factura/seguro/:id', FacturaSeguroController::class . '@actualizarFacturaSeguro', '1,2,3');
Router::delete('/factura/seguro/:id', FacturaSeguroController::class . '@eliminarFacturaSeguro', '1,2,3');

//Factura_Consulta - Vistas
Router::get('/factura/consulta', FacturaConsultaController::class . '@index');
Router::get('/factura/consulta/registrar', FacturaConsultaController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/consulta/actualizar/:id', FacturaConsultaController::class . '@formActualizarFacturaConsulta');

//Factura_Consulta - API
Router::get('/factura/consulta/consulta', FacturaConsultaController::class . '@listarFacturaConsulta', '1,2,3');
Router::get('/factura/consulta/:id', FacturaConsultaController::class . '@listarFacturaConsultaPorId', '1,2,3');
Router::post('/factura/consulta', FacturaConsultaController::class . '@insertarFacturaConsulta', '1,2,3');
Router::put('/factura/consulta/:id', FacturaConsultaController::class . '@actualizarFacturaConsulta', '1,2,3');
Router::delete('/factura/consulta/:id', FacturaConsultaController::class . '@eliminarFacturaConsulta', '1,2,3');

//Factura_Medico - Vistas
Router::get('/factura/medico', FacturaMedicoController::class . '@index');
Router::get('/factura/medico/registrar', FacturaMedicoController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/medico/actualizar/:id', FacturaMedicoController::class . '@formActualizarFacturaConsulta');

//Factura_Medico - API
Router::get('/factura/medico/consulta', FacturaMedicoController::class . '@listarFacturaMedico', '1,2,3');
Router::get('/factura/medico/:id', FacturaMedicoController::class . '@listarFacturaMedicoPorId', '1,2,3');
Router::get('/factura/medico/medico/:id', FacturaMedicoController::class . '@listarFacturaPorMedico', '1,2,3');
Router::get('/factura/fecha/', FacturaMedicoController::class . '@listarFacturaPorFecha', '1,2,3');
Router::post('/factura/medico', FacturaMedicoController::class . '@solicitarFacturaMedico', '1,2,3');
Router::put('/factura/medico/:id', FacturaMedicoController::class . '@actualizarFacturaMedico', '1,2,3');
Router::delete('/factura/medico/:id', FacturaMedicoController::class . '@eliminarFacturaMedico', '1,2,3');
