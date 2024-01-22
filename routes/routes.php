<?php

$AuthenticationMiddleware = new AuthenticationMiddleware();
$AuthorizationMiddleware = new AuthorizationMiddleware();
$AuditMiddleware = new AuditMiddleware();
$auditCita = new AuditCita();

// Prueba front
Router::get("/welcome", welcomeController::class . '@index');

// Router::post('/prueba/:id', UsuarioController::class . '@listarUsuarioPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") ), $auditCita]);
Router::get('/prueba', fakerClass::class . '@usarFaker');

//Auditoria - API
Router::get('/auditoria/consulta', AuditoriaController::class . '@listarAuditoria');
Router::post('/auditoria/fecha', AuditoriaController::class . '@listarAuditoriaPorFecha');
Router::post('/auditoria/accion', AuditoriaController::class . '@listarAuditoriaPorAccion');
Router::get('/auditoria/:id', AuditoriaController::class . '@listarAuditoriaPorUsuario');

// //Auditoria - Vista
// Router::get("/auditoria", AuditoriaController::class . '@index');

// // PDF - Vista
Router::get("/pdf/seguros", PdfController::class . '@pdf_seguro');
Router::get("/pdf/facturacompra/:id", PdfController::class . '@pdf_facturaCompra');
Router::get("/pdf/facturaconsulta/:id", PdfController::class . '@pdf_facturaConsulta');
Router::get("/pdf/facturaseguro/:id", PdfController::class . '@pdf_facturaSeguro');
Router::get("/pdf/facturamedico/:id", PdfController::class . '@pdf_facturaMedico');
Router::get("/pdf/consulta/:id", PdfController::class . '@pdf_consulta');
Router::get("/pdf/insumosfaltantes", PdfController::class . '@pdf_InsumosFaltantes');
Router::get("/pdf/historialmedico/:id", PdfController::class . '@pdf_historialMedico');
Router::get("/pdf/cita/:id", PdfController::class . '@pdf_citas');
Router::get("/pdf/consultaemergencia/:id", PdfController::class . '@pdf_consultasEmergencia');
Router::get("/pdf/cintillo/:id", PdfController::class . '@pdf_cintillo');
Router::get("/pdf/facturamensajeria/:id", PdfController::class . '@pdf_facturaMensajeria');

// //Login - vista
Router::get('/login', LoginController::class . '@index');
Router::get('/login/recuperarusuario', LoginController::class . '@recuperarUsuarioView');

// //Login - API
Router::post('/login', LoginController::class . '@entrar');
Router::post('/login/:id', LoginController::class . '@recuperarUsuario');

// //Preguntas - API
Router::get('/preguntas/consulta', PreguntaSeguridadController::class . '@listarPreguntas', [$AuthenticationMiddleware]);
Router::get('/preguntas/:id', PreguntaSeguridadController::class . '@listarPreguntasPorId', [$AuthenticationMiddleware]);
Router::get('/preguntas/usuario', PreguntaSeguridadController::class . '@listarPreguntasPorUsuarioId');
Router::post('/pregunta/:id', PreguntaSeguridadController::class . '@insertarPregunta', [$AuthenticationMiddleware]);
Router::post('/respuesta/:id', PreguntaSeguridadController::class . '@comprobarPregunta',);

// //Ruta principal
Router::get('/', LoginController::class . '@index');

// //Home - Vista
Router::get('/home', homepageController::class . '@index');

// //Usuario - Vistas
Router::get('/usuarios', UsuarioController::class . '@index');
Router::get('/usuarios/registrar', UsuarioController::class . '@formRegistrarUsuario');
Router::get('/usuarios/actualizar/:id', UsuarioController::class . '@formActualizarUsuarios');

// //Usuario - API
Router::get('/usuarios/consulta', UsuarioController::class . '@listarUsuarios');
Router::get('/usuarios/:id', UsuarioController::class . '@listarUsuarioPorId');
Router::post('/usuarios', UsuarioController::class . '@insertarUsuario');
Router::put('/usuarios/:id', UsuarioController::class . '@actualizarUsuario', [$AuthenticationMiddleware]);
Router::delete('/usuarios/:id', UsuarioController::class . '@eliminarUsuario',);

// //Pacientes - Vistas
Router::get('/pacientes', PacienteController::class . '@index');
Router::get('/pacientes/registrar', PacienteController::class . '@formRegistrarPaciente');
Router::get('/pacientes/actualizar/:id', PacienteController::class . '@formActualizarPaciente');
Router::get('/pacientes/historialmedico/:id', PacienteController::class . '@historialMedico');

// //Pacientes - API
Router::get('/pacientes/consulta', PacienteController::class . '@listarPacientes', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/pacientes/:id', PacienteController::class . '@listarPacientePorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/pacientes', PacienteController::class . '@insertarPaciente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::put('/pacientes/:id', PacienteController::class . '@actualizarPaciente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/pacientes/:id', PacienteController::class . '@eliminarPaciente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);

// //Antecedentes Médicos - Vistas
Router::get('/antecedentes', AntecedenteMedicoController::class . '@index');
Router::get('/antecedentes/registrar', AntecedenteMedicoController::class . '@formRegistrarAntecedente');
Router::get('/antecedentes/actualizar/:id', AntecedenteMedicoController::class . '@formActualizarAntecedente');

// //Antecedentes Médicos - API
Router::get('/antecedentes/consulta', AntecedenteMedicoController::class . '@listarAntecedentes', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/antecedentes/:id', AntecedenteMedicoController::class . '@listarAntecedentePorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/antecedentes/paciente/:id', AntecedenteMedicoController::class . '@listarAntecedentesPorPaciente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/antecedentes', AntecedenteMedicoController::class . '@insertarAntecedente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);
Router::put('/antecedentes/:id', AntecedenteMedicoController::class . '@actualizarAntecedente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);
Router::delete('/antecedentes/:id', AntecedenteMedicoController::class . '@eliminarAntecedente', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //PacienteSeguro - API
Router::delete('/paciente/seguro/:id', PacienteSeguroController::class . '@eliminarPacienteSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //Paciente Beneficiado - API
Router::get('/beneficiado/consulta', PacienteBeneficiadoController::class . '@listarPacienteBeneficiadoId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/beneficiado/:id', PacienteBeneficiadoController::class . '@eliminarPacienteBeneficiado', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);

// //Titular - API
Router::post('/titular/:id', TitularBeneficiadoController::class . '@insertarTitularBeneficiado', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);
Router::get('/titulares/:id', TitularBeneficiadoController::class . '@listarTitularesDePacienteBeneficiadoId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/titularesBeneficiado/:id', TitularBeneficiadoController::class . '@listarPacienteBeneficiadoDeTitularId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/titular/:id', TitularBeneficiadoController::class . '@eliminarTitularBeneficiado', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //Paciente Beneficiado - API
Router::delete('/pacienteBeneficiado/:id', PacienteBeneficiadoController::class . '@eliminarPacienteBeneficiado', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //Medicos - Vistas
Router::get('/medicos', MedicoController::class . '@index');
Router::get('/medicos/registrar', MedicoController::class . '@formRegistrarMedico');
Router::get('/medicos/actualizar/:id', MedicoController::class . '@formActualizarMedico');
Router::get('/medicos/perfilmedico', MedicoController::class . '@perfilMedico');

// //Medicos - API
Router::get('/medicos/consulta', MedicoController::class . '@listarmedicos', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::get('/medicos/:id', MedicoController::class . '@listarMedicoPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::get('/medicos/cedula/:ci', MedicoController::class . '@listarMedicoPorCI', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::post('/medicos', MedicoController::class . '@insertarMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/medicos/:id', MedicoController::class . '@actualizarMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/medicos/:id', MedicoController::class . '@eliminarMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Medicos_especialidad - API
Router::delete('/medicos/especialidad/:id', MedicoEspecialidadController::class . '@eliminarMedicoEspecialidad', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Especialidad - Vistas
Router::get('/especialidades', EspecialidadController::class . '@index');
Router::get('/especialidades/registrar', EspecialidadController::class . '@formRegistrarEspecialidad');
Router::get('/especialidades/actualizar/:id', EspecialidadController::class . '@formActualizarEspecialidad');

// //Especialidad - API
Router::get('/especialidades/consulta', EspecialidadController::class . '@listarEspecialidades', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/especialidades/:id', EspecialidadController::class . '@listarEspecialidadPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/especialidades', EspecialidadController::class . '@insertarEspecialidad', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/especialidades/:id', EspecialidadController::class . '@actualizarEspecialidad', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/especialidades/:id', EspecialidadController::class . '@eliminarEspecialidad', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Horarios - Vistas
Router::get('/horarios', HorarioController::class . '@index');
Router::get('/horarios/registrar', HorarioController::class . '@formRegistrarHorario');
Router::get('/horarios/actualizar/:id', HorarioController::class . '@formActualizarHorario');

// //Horarios - API
Router::get('/horarios/consulta', HorarioController::class . '@listarHorarios', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/horarios/:id', HorarioController::class . '@listarHorarioPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/horarios/:id', HorarioController::class . '@eliminarHorario', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //Seguros - Vistas
Router::get('/seguros', SeguroController::class . '@index');
Router::get('/seguros/registrar', SeguroController::class . '@formRegistrarSeguro');
Router::get('/seguros/actualizar/:id', SeguroController::class . '@formActualizarSeguro');

// //Seguros - API
Router::get('/seguros/consulta', SeguroController::class . '@listarSeguros', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::get('/seguros/:id', SeguroController::class . '@listarSeguroPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::post('/seguros', SeguroController::class . '@insertarSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::post('/seguros/examenes/:id', SeguroController::class . '@insertarSeguroExamen', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/seguros/:id', SeguroController::class . '@actualizarSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/seguros/:id', SeguroController::class . '@eliminarSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/seguros/examen/:id', SeguroController::class . '@eliminarSeguroExamen', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Empresa - Vistas
Router::get('/empresas', EmpresaController::class . '@index');
Router::get('/empresas/registrar', EmpresaController::class . '@formRegistrarEmpresa');
Router::get('/empresas/actualizar/:id', EmpresaController::class . '@formActualizarEmpresa');

// //Empresa - API
Router::get('/empresas/consulta', EmpresaController::class . '@listarEmpresas', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/empresas/:id', EmpresaController::class . '@listarEmpresaPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/empresas', EmpresaController::class . '@insertarEmpresa', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/empresas/:id', EmpresaController::class . '@actualizarEmpresa', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/empresas/:id', EmpresaController::class . '@eliminarEmpresa', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// // SeguroEmpresa
Router::delete("/seguroempresa/:id", SeguroEmpresaController::class . '@eliminarSeguroEmpresa', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Cita - Vistas
Router::get('/citas', CitaController::class . '@index');
Router::get('/citas/registrar', CitaController::class . '@formRegistrarCita');
Router::get('/citas/actualizar/:id', CitaController::class . '@formActualizarCita');

// //Cita - API
Router::get('/citas/consulta', CitaController::class . '@listarCitas',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/citas/:id', CitaController::class . '@listarCitaPorId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/citas/paciente/:id', CitaController::class . '@listarCitaPorPacienteId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/citas/medico/:id', CitaController::class . '@listarCitaPorMedicoId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/citas/:id', CitaController::class . '@reprogramarCita',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4") )]);
Router::post('/citas', CitaController::class . '@insertarCita', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);
Router::put('/citas/:id', CitaController::class . '@actualizarCita',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/citas/:id', CitaController::class . '@eliminarCita', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","5") )]);

// //Consulta - Vistas
Router::get('/consultas', ConsultaController::class . '@index');
Router::get('/consultas/registrar', ConsultaController::class . '@formRegistrarConsulta');
Router::get('/consultas/actualizar/:id', ConsultaController::class . '@formActualizarConsulta');

// //Consulta - API
Router::get('/consultas/consulta', ConsultaController::class . '@listarConsultas',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/consultas/:id', ConsultaController::class . '@listarConsultaPorId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/consultas/paciente/:id', ConsultaController::class . '@listarConsultasPorPaciente',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/consultas', ConsultaController::class . '@insertarConsulta',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::put('/consultas/:id', ConsultaController::class . '@actualizarConsulta',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::delete('/consultas/:id', ConsultaController::class . '@eliminarConsulta',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Medicamento - Vistas
Router::get('/medicamentos', MedicamentoController::class . '@index');
Router::get('/medicamentos/registrar', MedicamentoController::class . '@formRegistrarMedicamento');
Router::get('/medicamentos/actualizar/:id', MedicamentoController::class . '@formActualizarMedicamento');

// //Medicamento - API
Router::get('/medicamento/consulta', MedicamentoController::class . '@listarMedicamentos',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/medicamento/:id', MedicamentoController::class . '@listarMedicamentoPorId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/medicamento/especialidad/:id', MedicamentoController::class . '@listarMedicamentosPorEspecialidad',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/medicamento', MedicamentoController::class . '@insertarMedicamento',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::put('/medicamento/:id', MedicamentoController::class . '@actualizarMedicamento',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("1") )]);
Router::delete('/medicamento/:id', MedicamentoController::class . '@eliminarMedicamento',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("1") )]);

// //Exámenes - Vistas
Router::get('/examenes', ExamenController::class . '@index');
Router::get('/examenes/registrar', ExamenController::class . '@formRegistrarExamen');
Router::get('/examenes/actualizar/:id', ExamenController::class . '@formActualizarExamen');

// //Exámenes - API
Router::get('/examenes/consulta', ExamenController::class . '@listarExamen',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/examenes/:id', ExamenController::class . '@listarExamenPorId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/examenes/laboratorios', ExamenController::class . '@listarExamenDeLaboratorios',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::get('/examenes/clinica', ExamenController::class . '@listarExamenRealizados',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","4","5") )]);
Router::post('/examenes', ExamenController::class . '@insertarExamen',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/examenes/:id', ExamenController::class . '@actualizarExamen',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/examenes/:id', ExamenController::class . '@eliminarExamen',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Proveedor - Vistas
Router::get('/proveedores', ProveedorController::class . '@index');
Router::get('/proveedores/registrar', ProveedorController::class . '@formRegistrarProveedor');
Router::get('/proveedores/actualizar/:id', ProveedorController::class . '@formActualizarProveedor');

// //Proveedor - API
Router::get('/proveedores/consulta', ProveedorController::class . '@listarProveedor',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::get('/proveedores/:id', ProveedorController::class . '@listarProveedorPorId',  [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::post('/proveedores', ProveedorController::class . '@insertarProveedor', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/proveedores/:id', ProveedorController::class . '@actualizarProveedor', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/proveedores/:id', ProveedorController::class . '@eliminarProveedor', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Insumo - Vistas
Router::get('/insumos', InsumoController::class . '@index');
Router::get('/insumos/registrar', InsumoController::class . '@formRegistrarInsumo');
Router::get('/insumos/actualizar/:id', InsumoController::class . '@formActualizarInsumo');

// //Insumo - API
Router::get('/insumos/consulta', InsumoController::class . '@listarInsumo', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::get('/insumos/:id', InsumoController::class . '@listarInsumoPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::post('/insumos', InsumoController::class . '@insertarInsumo', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::put('/insumos/:id', InsumoController::class . '@actualizarInsumo', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);
Router::delete('/insumos/:id', InsumoController::class . '@eliminarInsumo', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2") )]);

// //Factura_Compra - Vistas
Router::get('/factura/compra', FacturaCompraController::class . '@index');
Router::get('/factura/compra/registrar', FacturaCompraController::class . '@formRegistrarFacturaCompra');
Router::get('/factura/compra/actualizar/:id', FacturaCompraController::class . '@formActualizarFacturaCompra');

// //Factura_Compra - API
Router::get('/factura/compra/consulta', FacturaCompraController::class . '@listarFacturaCompra', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/compra/:id', FacturaCompraController::class . '@listarFacturaCompraPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::post('/factura/compra', FacturaCompraController::class . '@insertarFacturaCompra', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/compra/:id', FacturaCompraController::class . '@actualizarFacturaCompra', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::delete('/factura/compra/:id', FacturaCompraController::class . '@eliminarFacturaCompra', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

// //Compra_Insumo - API
// Router::get('/factura/insumos/:id', CompraInsumoController::class . '@listarCompraInsumoPorFactura');

// //Factura consulta_seguro - Vistas
Router::get('/factura/consultaSeguro', ConsultaSeguroController::class . '@index');
Router::get('/factura/consultaSeguro/registrar', ConsultaSeguroController::class . '@formRegistrarConsultaSeguro');
Router::get('/factura/consultaSeguro/actualizar/:id', ConsultaSeguroController::class . '@formActualizarConsultaSeguro');

// //Factura consulta_seguro - API
Router::get('/factura/consultaSeguro/consulta', ConsultaSeguroController::class . '@listarConsultaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/consultaSeguro/:id', ConsultaSeguroController::class . '@listarConsultaSeguroPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/consultaSeguro/seguro/:id', ConsultaSeguroController::class . '@listarConsultaSeguroPorSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::post('/factura/consultaSeguro', ConsultaSeguroController::class . '@insertarConsultaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/consultaSeguro/:id', ConsultaSeguroController::class . '@actualizarConsultaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::delete('/factura/consultaSeguro/:id', ConsultaSeguroController::class . '@eliminarConsultaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
// Router::put('/prueba', ConsultaSeguroController::class . '@probandoalgo');

// //Factura_Seguro - Vistas
Router::get('/factura/seguro', FacturaSeguroController::class . '@index');
Router::get('/factura/seguros/:id', FacturaSeguroController::class . '@index');
Router::get('/factura/seguroAge', FacturaSeguroController::class . '@segurosAge');
Router::get('/factura/seguro/registrar', FacturaSeguroController::class . '@formRegistrarFacturaSeguro');
Router::get('/factura/seguro/actualizar/:id', FacturaSeguroController::class . '@formActualizarFacturaSeguro');

// //Factura_Seguro - API
Router::post('/factura/seguro', FacturaSeguroController::class . '@solicitarFacturaSeguro');
Router::get('/factura/seguro/consulta', FacturaSeguroController::class . '@listarFacturaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/seguro/fecha', FacturaSeguroController::class . '@listarFacturaSeguroPorFecha', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/seguro/:id', FacturaSeguroController::class . '@listarFacturaSeguroPorSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/facturaSeguro/:id', FacturaSeguroController::class . '@listarFacturaPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/seguro/:id', FacturaSeguroController::class . '@actualizarFacturaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::delete('/factura/seguro/:id', FacturaSeguroController::class . '@eliminarFacturaSeguro', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

// //Factura_Consulta - Vistas
Router::get('/factura/consulta', FacturaConsultaController::class . '@index');
Router::get('/factura/consulta/registrar', FacturaConsultaController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/consulta/actualizar/:id', FacturaConsultaController::class . '@formActualizarFacturaConsulta');

// //Factura_Consulta - API
Router::get('/factura/consulta/consulta', FacturaConsultaController::class . '@listarFacturaConsulta', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/consulta/:id', FacturaConsultaController::class . '@listarFacturaConsultaPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::post('/factura/consulta', FacturaConsultaController::class . '@insertarFacturaConsulta', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/consulta/:id', FacturaConsultaController::class . '@actualizarFacturaConsulta', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::delete('/factura/consulta/:id', FacturaConsultaController::class . '@eliminarFacturaConsulta', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

// //Factura_Medico - Vistas
Router::get('/factura/medico', FacturaMedicoController::class . '@index');
Router::get('/factura/medico/registrar', FacturaMedicoController::class . '@formRegistrarFacturaConsulta');
Router::get('/factura/medico/actualizar/:id', FacturaMedicoController::class . '@formActualizarFacturaConsulta');

// //Factura_Medico - API
Router::get('/factura/medico/consulta', FacturaMedicoController::class . '@listarFacturaMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/medico/:id', FacturaMedicoController::class . '@listarFacturaMedicoPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/medico/medico/:id', FacturaMedicoController::class . '@listarFacturaPorMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/fecha/', FacturaMedicoController::class . '@listarFacturaPorFecha', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

Router::get('/facturaMedico/medico', FacturaMedicoController::class . '@calcularFacturaMedicoId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

Router::post('/facturas/all', FacturaMedicoController::class . '@solicitarFacturasMedicos', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::post('/factura/medico', FacturaMedicoController::class . '@insertarFacturaMedicoPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/medico/:id', FacturaMedicoController::class . '@actualizarFacturaMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::delete('/factura/medico/:id', FacturaMedicoController::class . '@eliminarFacturaMedico', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

// //Global
Router::get('/globals', GlobalController::class . '@obtenerGlobals', [$AuthenticationMiddleware]);
Router::put('/porcentajeMedico', GlobalController::class . '@actualizarPorcentaje', [$AuthenticationMiddleware]);
Router::put('/cambioDivisa', GlobalController::class . '@actualizarValorDivisa', [$AuthenticationMiddleware]);

// //Factura_Medico - Vistas
Router::get('/factura/mensajeria', FacturaMensajeriaController::class . '@index');
Router::get('/factura/mensajeria/registrar', FacturaMensajeriaController::class . '@formRegistrarFacturaMensajeria');
Router::get('/factura/mensajeria/actualizar/:id', FacturaMensajeriaController::class . '@formActualizarFacturaConsulta');

// //Factura_Medico - API
Router::get('/factura/mensajeria/consulta', FacturaMensajeriaController::class . '@listarFacturaMensajeria', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::get('/factura/mensajeria/:id', FacturaMensajeriaController::class . '@listarFacturaMensajeriaPorId', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::post('/factura/mensajeria', FacturaMensajeriaController::class . '@insertarFacturaMensajeria', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);
Router::put('/factura/mensajeria/:id', FacturaMensajeriaController::class . '@actualizarFacturaMensajeria', [$AuthenticationMiddleware, new AuthorizationMiddleware( array("2","3") )]);

// Estadísticas - Vistas
Router::get("/estadisticas", EstadisticasController::class . '@index');

// Estadísticas - API
Router::get("/allConsultas", EstadisticasController::class . '@allConsultas');
Router::get("/allConsultasMedicos", EstadisticasController::class . '@allConsultasMedicos');
Router::get("/allConsultasEspecialidades", EstadisticasController::class . '@allConsultasEspecialidades');

// Laboratorios - Vistas
Router::get("/laboratorios", LaboratoriosController::class . '@index');