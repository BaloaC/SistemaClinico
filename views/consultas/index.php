<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Consultar Usuarios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Consultas</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> consulta</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Consultas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="consultas" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Cédula Paciente</th>
                                            <th>Nombre Paciente</th>
                                            <th>Nombre Médico</th>
                                            <th>Especialidad</th>
                                            <th>Cédula Titular</th>
                                            <th>Fecha Consulta</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-consulta" class="form-reg p-3 px-4">
                            <div class="row">
                                <div class="row ">
                                    <h5>Información de la cita</h5>
                                    <div class="col-12 col-md-6 emergenciaContainer">
                                        <label for="input-radios-container" class="">¿La consulta es por emergencia?</label>
                                        <div class="input-radios-container">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultaPorEmergencia" id="consultaEmergenciaSi" onchange="consultaEmergencia(this)" value="1" required>
                                                <label class="form-check-label" for="inlineRadio1">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultaPorEmergencia" id="consultaEmergenciaNo" onchange="consultaEmergencia(this)" value="0" checked required>
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 sinCitaContainer">
                                        <label for="input-radios-container" class="">¿La consulta es sin cita previa?</label>
                                        <div class="input-radios-container">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultaSinCitaPrevia" id="consultaCitaSi" onchange="consultaSinCita(this)" value="1" required>
                                                <label class="form-check-label" for="inlineRadio1">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="consultaSinCitaPrevia" id="consultaCitaNo" onchange="consultaSinCita(this)" value="0" checked required>
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 info-cita">
                                        <label for="cita">Cita</label>
                                        <select name="cita_id" id="s-cita" class="form-control" data-active="0" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4 info-paciente" style="display: none;">
                                    <h5>Información del Paciente</h5>
                                    <div class="col-12 col-md-6">
                                        <label for="nombres">Paciente</label>
                                        <select name="paciente_id" id="s-paciente" class="form-control" data-active="0" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="cedula" id="cedula_beneficiado-label" style="display: none;">Cédula beneificado</label>
                                        <input type="number" name="cedula_beneficiado" id="cedula_beneficiado" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" style="display: none;" data-bs-toggle="popover" disabled required>
                                        <small class="form-text" id="cedulaBeneficiadoSmall">La cédula debe contener entre 6 o 8 números</small>
                                    </div>
                                </div>

                                <div class="row mt-4 info-medico" style="display: none;">
                                    <h5>Información del médico</h2>
                                        <div class="col-12 col-md-6">
                                            <label for="medico_id">Médico</label>
                                            <select name="medico_id" id="s-medico" class="form-control" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="especialidad_id">Especialidad</label>
                                            <select name="especialidad_id" id="s-especialidad" class="form-control" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                </div>

                                <div class="row mt-4">
                                    <h5>Información de la Consulta</h5>
                                    <div class="col-12 col-md-6">
                                        <label for="peso">Peso</label>
                                        <input type="number" step="any" name="peso" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6">
                                        <small class="form-text">No se permiten números negativos</small>

                                        <label for="estatura">Estatura</label>
                                        <input type="number" step="any" name="altura" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6">
                                        <small class="form-text">No se permiten números negativos</small>

                                        <label for="observaciones">Observaciones</label>
                                        <input type="text" name="observaciones" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255">
                                        <small class="form-text">Solo puede contener letras</small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="examenes">Exámenes llevados a la consulta</label>
                                        <select name="examenes[]" id="s-examen" class="form-control mb-3" data-active="0" multiple="multiple">
                                            <option></option>
                                        </select>

                                        <label for="fecha_consulta">Fecha consulta</label>
                                        <input type="date" name="fecha_consulta" class="form-control mb-3" data-validate="true" data-type="date" required>
                                    </div>
                                </div>

                                <div class="row mt-4 info-consulta-emergencia" style="display: none;">
                                    <h5>Información de la consulta de emergencia</h5>
                                    <h6>Nota: todos los montos ingresados deben ser en dólares.</h6>
                                    <div class="col-12 col-md-6">
                                        <label for="monto-consulta">Enfermería</label>
                                        <input type="number" step="any" name="enfermeria" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="monto-consulta">Laboratorio</label>
                                        <input type="number" step="any" name="laboratorios" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="monto-consulta">Medicamentos</label>
                                        <input type="number" step="any" name="medicamentos" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="monto-consulta">Monto consulta</label>
                                        <input type="number" step="any" name="consultas_medicas" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="forRegistrarFactura">¿Desea registrar la factura directamente?</label>
                                        <div class="input-radios-container">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registrarFacturaBool" id="registrarFacturaSi" value="1" required disabled>
                                                <label class="form-check-label" for="inlineRadio1">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registrarFacturaBool" id="registrarFacturaNo" value="0" checked required disabled>
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="cedula">Area de observación</label>
                                        <input type="number" name="area_observacion" class="form-control mb-3" data-validate="true" data-type="number" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="cedula">Total insumos</label>
                                        <input type="number" name="total_insumos" class="form-control mb-3" data-validate="true" data-type="number" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="cedula">Total exámenes</label>
                                        <input type="number" name="total_examenes" class="form-control mb-3" data-validate="true" data-type="number" data-max-length="6" value="0" disabled required>
                                        <small class="form-text">No se permiten números negativos</small>
                                        <label for="seguro">Seguro</label>
                                        <select id="s-seguro-emergencia" name="seguro_id" class="form-control seguro-emergencia" data-active="0" disabled required>
                                            <option></option>
                                        </select>
                                        <label for="forRegistrarPagoMedico" id="registrarPagoMedicoLabel">¿Desea registrar el pago de algún médico?</label>
                                        <div class="input-radios-container inputRadioPagoMedico">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registrarPagoMedicoBool" id="RegistrarPagoMedicoSi" value="1" onchange="pagoMedicosInput(this.value)" required disabled>
                                                <label class="form-check-label" for="inlineRadio1">Sí</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="registrarPagoMedicoBool" id="RegistrarPagoMedicoNo" value="0" onchange="pagoMedicosInput(this.value)" checked required disabled>
                                                <label class="form-check-label" for="inlineRadio2">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-4 info-pago-medico" style="display: none;">
                                <h5>Pago médico</h5>
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5">
                                        <label for="medico">Médico</label>
                                        <select id="s-medico-pago" class="form-control medico-pago-id" data-active="0" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="monto" class="p-0">Monto</label>
                                        <input type="number" name="monto_pago" step="any" class="form-control monto-pago" data-validate="true" data-type="price" disabled>
                                        <small class="form-text">No se permiten números negativos</small>
                                    </div>
                                    <div class="col-3 col-md-1 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.medico-pago-id')"><i class="fas fa-times m-0"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" style="display: none;" id="addMedicoPago" onclick="addMedicoPagoInput()">Añadir otro médico</button>
                            </div>

                            <div class="row mt-4">
                                <h5>Insumos utilizados en la Consulta (Opcional)</h5>
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5">
                                        <label for="insumo">Insumo</label>
                                        <select id="s-insumo" class="form-control insumo-id" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="cantidad" class="p-0">Cantidad utilizada</label>
                                        <input type="number" step="any" data-validate="true" data-type="number" class="form-control insumo-cant">
                                        <small class="form-text col-12">Solo se permiten números</small>
                                    </div>
                                    <div class="col-3 col-md-1 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.insumo-id')"><i class="fas fa-times m-0"></i></button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" class="btn btn-primary mt-3" id="addInsumo" onclick="addInsumoInput()">Añadir otro insumo</button>

                            <div class="row mt-4">
                                <h5>Recipes otorgados en la Consulta (Opcional)</h5>
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5">
                                        <label for="medicamento">Medicamento</label>
                                        <select id="s-medicamento" class="form-control medicamento-id" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="uso" class="p-0">Uso</label>
                                        <input type="text" data-validate="true" data-type="address" class="form-control uso-medicamento">
                                        <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
                                    </div>
                                    <div class="col-3 col-md-1 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.medicamento-id')"><i class="fas fa-times m-0"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addRecipe" onclick="addRecipeInput()">Añadir otro medicamento</button>

                            <div class="row mt-4">
                                <h5>Indicaciones mencionadas en la Consulta (Opcional)</h5>
                                <div class="row align-items-center">
                                    <div class="col-12 col-md-5">
                                        <label for="indicacion" class="p-0">Indicación</label>
                                        <input type="text" data-validate="true" data-type="address" class="form-control indicaciones">
                                        <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
                                    </div>
                                    <div class="col-3 col-md-1 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.indicaciones')"><i class="fas fa-times m-0"></i></button>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addIndicacion" onclick="addIndicacionInput()">Añadir otra indicación</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addConsulta()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal info -->
        <div class="modal fade" id="modalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalInfoLabel">Información paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-4 paciente-info">
                                    <img src="<?php echo Url::to('assets/img/ficha.png'); ?>" alt="">
                                    <p>Nombres y Apellidos: <span id="nombre_paciente"></span></p>
                                    <p>Género: <span id="genero">Static</span></p>
                                    <p>Fecha de nacimiento: <span id="fecha"></span></p>
                                    <p>Edad: <span id="edad"></span></p>
                                    <p>Alergías: <span id="alergias">Static</span></p>
                                    <p>Observación: <span id="observacion"> Lorem ipsum dolor sit amet consectetur adipisicing elit. Architecto tempore excepturi voluptatem sapiente. Soluta ex fugiat quidem qui consequuntur, eius eveniet cum! Illo nisi sit perspiciatis adipisci maiores a dolor!</span></p>
                                    <button class="btn btn-white">Agregar consulta</button>
                                </div>
                                <div class="col-12 col-md-8 paciente-consulta">
                                    <ul class="pt-3">
                                        <li>
                                            <p>Consulta: <span id="fecha-consulta">Static</span> <br> Especialidad: <span id="especilidad">Static</span></p>
                                        </li>
                                        <li>
                                            <p>Consulta: <span id="fecha-consulta">Static</span> <br> Especialidad: <span id="especilidad">Static</span></p>
                                        </li>
                                        <li>
                                            <p>Consulta: <span id="fecha-consulta">Static</span> <br> Especialidad: <span id="especilidad">Static</span></p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-paciente" class="p-3 px-4">
                            <div class="two-inputs">
                                <!-- Labels -->
                                <div class="row">
                                    <label for="nombres">Nombres</label>
                                    <label for="apellidos">Apellidos</label>
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <input type="text" name="nombres" class="form-control mb-3">
                                    <input type="text" name="apellidos" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="two-inputs">
                                <!-- Labels -->
                                <div class="row">
                                    <label for="cedula">Cédula</label>
                                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <input type="number" name="cedula" class="form-control mb-3">
                                    <input type="date" name="fecha_nacimiento" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="two-inputs">
                                <!-- Labels -->
                                <div class="row">
                                    <label for="telefono">Teléfono</label>
                                    <label for="direccion">Dirección</label>
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <div class="input-group mb-3">
                                        <select name="cod_tel" id="cod-tel" class="me-2">
                                            <option value="0412">0412</option>
                                            <option value="0414">0414</option>
                                            <option value="0424">0424</option>
                                            <option value="0416">0416</option>
                                            <option value="0426">0426</option>
                                        </select>
                                        <input type="text" name="telefono" class="form-control">
                                    </div>
                                    <input type="text" name="direccion" class="form-control mb-3">
                                </div>
                            </div>
                            <div class="two-inputs">
                                <!-- Labels -->
                                <div class="row">
                                    <label for="tipo_paciente">Tipo de paciente</label>
                                    <!-- <label for="seguro">Seguro</label> -->
                                </div>
                                <!-- Inputs -->
                                <div class="row">
                                    <select name="tipo_paciente" id="tipo_paciente" class="form-control mb-3" requried>
                                        <option value="1">Natural</option>
                                        <option value="2">Asegurado</option>
                                        <option value="3">Beneficiado</option>
                                    </select>
                                    <!-- <select name="seguro_id" id="seguro_id" class="form-control mb-3">
                                        <option value="">Seleccione un seguro</option>
                                    </select> -->
                                </div>
                            </div>
                            <!-- <div class="two-inputs">
                               
                                <div class="row">
                                    <label for="empresa">Empresa</label>
                                    <label for="tipo_seguro">Tipo de seguro</label>
                                </div>
                              
                                <div class="row">
                                    <select name="empresa_id" id="empresa_id" class="form-control mb-3">
                                        <option value="">Consultar empresas</option>
                                    </select>
                                    <select name="tipo_seguro" class="form-control mb-3" >
                                        <option value="">Seleccione el tipo de seguro</option>
                                        <option value="1">Acumulativo</option>
                                        <option value="2">Normal</option>
                                    </select>
                                </div>
                            </div>
                            <div class="two-inputs">
                                
                                <div class="row">
                                    <label for="fecha_contra">Fecha de Contratación</label>
                                    <label for="cobertura_general">Cobertura General</label>
                                </div>
                                
                                <div class="row">
                                    <input type="date" name="fecha_contra" class="form-control mb-3" disabled>
                                    <input type="number" name="saldo_disponible" class="form-control mb-3" disabled>
                                </div>
                            </div>
                            <div class="two-inputs">
                               
                                <div class="row">
                                    <label for="saldo_disponible">Saldo disponible</label>
                                </div>
                                
                                <div class="row">
                                    <input type="number" name="saldo_disponible" class="form-control mb-3" disabled>
                                </div>
                            </div> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este paciente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro Factura Consulta -->
        <div class="modal fade" id="modalRegNormal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegNormalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegNormalLabel">Registrar factura consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alertConsulta d-none" role="alert"></div>
                        <form action="" id="info-fconsulta" class="p-3 px-4">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="paciente_id">Paciente</label>
                                    <select name="paciente_id" id="s-paciente-consulta" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                    <label for="monto_sin_iva">Monto</label>
                                    <input type="number" name="monto_consulta_usd" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8">
                                    <!-- <input type="number" name="monto_sin_iva" oninput="calcularIva(this)" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8"> -->

                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="consulta_id">Consulta</label>
                                    <select name="consulta_id" id="s-consulta-normal" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                    <label for="monto_con_iva">Método de pago</label>
                                    <select name="metodo_pago" id="s-metodo-pago" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFConsulta()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro Factura Consulta Seguro-->
        <div class="modal fade" id="modalRegAsegurada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegAseguradaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegAseguradaLabel">Registrar factura seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alertConsultaSeguro d-none" role="alert"></div>
                        <form action="" id="info-fseguro" class="p-3 px-4">

                            <label for="consulta_id">Consulta</label>
                            <select name="consulta_id" id="s-consulta-seguro" class="form-control mb-3" data-active="0" required>
                                <option></option>
                            </select>
                            <label for="tipo_servico">Tipo de servicio</label>
                            <select name="tipo_servicio" id="s-tipo-servicio" class="form-control mb-3" data-active="0" required>
                                <option></option>
                            </select>
                            <label for="monto">Monto</label>
                            <input type="number" name="monto" id="monto" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El precio de ser mayor o igual a 0</small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFSeguro()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/mostrarConsultas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/registrarConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/eliminarConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addInsumoInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addIndicacionInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addRecipeInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addMedicoPagoInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/deleteInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-consulta/registrarFConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/registrarConsultaSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/consultaEmergencia.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/consultaSinCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/pagoMedicosInput.js'); ?>"></script>
</body>

</html>