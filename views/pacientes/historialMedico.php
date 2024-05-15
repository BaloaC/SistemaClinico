<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Historial Médico</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Historial Médico</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end historial-medico-btn">
                    <button class="btn btn-sm btn-add m-1" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalRegAntecedentes"><i class="fa-sm fas fa-plus"></i> Antecedentes</button>
                    <button class="btn btn-sm btn-add m-1" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Agregar consulta</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 paciente-info">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-end">
                                        <a class="btn btn-sm btn-add my-3" id="consulta-pdf" href="#"><i class="fa-sm fas fa-file-export"></i></a>
                                    </div>
                                    <div class="text-center">
                                        <img src="<?php echo Url::to('assets/img/3135715.webp'); ?>" style="height: 10rem;">
                                    </div>
                                    <div class="text-center">
                                        <p class="fw-bold mb-0"><span id="nombre_paciente"></span></p>
                                        <p>Paciente <span id="tipo_paciente"></span></p>
                                    </div>
                                    <p class="text-secondary mb-0">Fecha de nacimiento <span id="fecha"></span></p>
                                    <p class="text-secondary">Edad <span id="edad"></span></p>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <p class="fw-bold">Antecedentes</p>
                                    <div class="antecedente-container">

                                    </div>
                                </div>
                            </div>
                            <div class="card" id="seguroContainer">
                                <div class="card-body">
                                    <p id="seguroLabel" class="d-none"><b>Seguros:</b></p>
                                    <div class="seguro-container">
                                    </div>
                                </div>
                            </div>

                            <div class="card" id="beneficiadosContainer">
                                <div class="card-body">
                                    <p id="beneficiadosLabel" class="d-none"><b>Benecifiado:</b></p>
                                    <div class="beneficiado-container">
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-8 paciente-consulta">
                            <h5 class="pt-5 pb-2 text-grey d-none" id="citasLabel">Citas pendientes</h4>
                                <div class="accordion citas-accordion" id="citaAccordion">

                                </div>
                                <h5 class="pt-5 pb-2 text-grey">Consultas vistas</h5>
                                <div class="accordion consulta-accordion" id="consultaAccordion">

                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="modalRegAntecedentes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Antecedente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alertAntecedentes alert d-none" role="alert"></div>
                        <form id="info-antecedente" class="form-reg p-3 px-4">
                            <label for="tipo_antedecente_id">Tipo de antecedente</label>
                            <select name="tipo_antecedente_id" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de antecedente</option>
                                <option value="1">Antecedentes Patológicos</option>
                                <option value="2">Antecedentes Psicológicos</option>
                                <option value="2">Antecedentes médicos familiares</option>
                                <option value="2">Cirugías o traumatismos</option>
                                <option value="2">Alergias</option>
                                <option value="2">Reacción a medicamentos</option>
                                <option value="2">Enfermedades Padecidas</option>
                                <option value="2">Tratamientos</option>
                                <option value="2">Hábitos de salud</option>
                            </select>
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" class="form-control mb-3" data-max-length="45" required>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addAntecedente()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Antecedente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form method="POST" id="act-antecedente" class="p-3 px-4">
                            <label for="tipo_antecedente_id">Tipo de antecedente</label>
                            <select name="tipo_antecedente_id" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de antecedente</option>
                                <option value="1">Antecedentes Patológicos</option>
                                <option value="2">Antecedentes Psicológicos</option>
                                <option value="2">Antecedentes médicos familiares</option>
                                <option value="2">Cirugías o traumatismos</option>
                                <option value="2">Alergias</option>
                                <option value="2">Reacción a medicamentos</option>
                                <option value="2">Enfermedades Padecidas</option>
                                <option value="2">Tratamientos</option>
                                <option value="2">Hábitos de salud</option>
                            </select>
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" class="form-control mb-3" data-max-length="45" required>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Antecedente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este antecedente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registo Consulta-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alertHistorialMedicoConsulta alert d-none" role="alert"></div>
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
                            <div class="row">
                                <div class="col-12 col-md-6">

                                </div>
                                <div class="col-12 col-md-6">

                                </div>
                            </div>
                            <div class="row mt-4 info-pago-medico" style="display: none;">
                                <h5>Pago médico</h5>
                                <div class="row align-items-start">
                                    <div class="col-12 col-md-5">
                                        <label for="medico">Médico</label>
                                        <select id="s-medico-pago" class="form-control medico-pago-id" data-active="0" disabled>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="monto">Monto</label>
                                        <input type="number" name="monto_pago" step="any" class="form-control monto-pago" data-validate="true" data-type="price" disabled>
                                        <small class="form-text">No se permiten números negativos</small>
                                    </div>
                                    <div class="col-3 col-md-1 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.medico-pago-id')"><i class="fas fa-times m-0"></i></button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3 w-25" style="display: none;" id="addMedicoPago" onclick="addMedicoPagoInput()">Añadir otro médico</button>
                            </div>

                            <div class="row mt-4">
                                <h5>Insumos utilizados en la Consulta (Opcional)</h5>
                                <div class="row align-items-start">
                                    <div class="col-12 col-md-5">
                                        <label for="insumo">Insumo</label>
                                        <select id="s-insumo" class="form-control insumo-id" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="cantidad">Cantidad utilizada</label>
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
                                <div class="row align-items-start">
                                    <div class="col-12 col-md-5">
                                        <label for="medicamento">Medicamento</label>
                                        <select id="s-medicamento" class="form-control medicamento-id" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="uso">Uso</label>
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
                                <div class="row align-items-start">
                                    <div class="col-12 col-md-5">
                                        <label for="indicacion">Indicación</label>
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

        <template id="template-antecedente">
            <div class="antecedente">
                <p><b>Tipo de antecedente:</b> <span id="tipo_antedecente"></span></p>
                <p><b>Descripción</b> <span id="descripcion_antecedente"></span></p>
                <div class="actions text-end">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-antecedente"><i class="fas fa-edit act-antecedente"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-antecedente"><i class="fas fa-trash del-antecedente"></i></a>
                </div>
            </div>
        </template>

        <template id="template-seguro">
            <div class="seguro">
                <p><b>Nombre de la empresa:</b> <span id="nombre_empresa"></span></p>
                <p><b>Nombre del seguro:</b> <span id="nombre_seguro"></span></p>
            </div>
        </template>

        <template id="template-beneficiado">
            <div class="seguro">
                <p><b>Nombres:</b> <span id="nombre"></span></p>
                <p><b>Cédula:</b> <span id="cedula"></span></p>
                <p><b>Edad:</b> <span id="edad"></span></p>
                <p><b>Relación:</b> <span id="relacion"></span></p>
            </div>
        </template>

        <template id="template-cita">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <a class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cita1" aria-expanded="false" aria-controls="cita1">
                        </a>
                    </h2>
                </div>
                <div id="cita1" class="collapse show" data-parent="#citaAccordion">
                    <div class="card-body">
                        <p><b>Item:</b> <span id="cita_id"></span> <br>
                            <b>Nombre médico:</b> <span id="nombre_medico"></span> <br>
                            <b>Especialidad:</b> <span id="especialidad"></span> <br>
                            <b>Fecha cita:</b> <span id="fecha_cita"></span> <br>
                            <b>Motivo cita:</b> <span id="motivo_cita"></span> <br>
                            <b>Hora entrada:</b> <span id="hora_entrada"></span> <br>
                            <b>Hora salida:</b> <span id="hora_salida"></span> <br>
                            <b>Tipo de cita:</b> <span id="tipo_cita"></span> <br>
                            <b>Estatus:</b> <span id="estatus_cit"></span> <br>
                        </p>
                    </div>
                </div>
            </div>
        </template>

        <template id="template-consulta">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <a class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#consulta1" aria-expanded="false" aria-controls="consulta1">
                        </a>
                    </h2>
                </div>
                <div id="consulta1" class="collapse show" data-parent="#consultaAccordion">
                    <div class="card-body">
                        <p><b>Item:</b> <span id="consulta_id"></span> <br>
                            <b>Nombre médico:</b> <span id="nombre_medico"></span> <br>
                            <b>Especialidad:</b> <span id="especialidad"></span> <br>
                            <b>Fecha consulta:</b> <span id="fecha_consulta"></span> <br>
                            <b>Motivo cita:</b> <span id="motivo_cita"></span> <br>
                            <b>Indicaciones:</b> <span id="indicaciones"></span> <br>
                            <b>Observaciones:</b> <span id="observaciones"></span>
                        </p>
                    </div>
                </div>
            </div>
        </template>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/historial-medico/mostrarHistorialMedico.js'); ?>"></script>
    <!-- <script type="module" src="<?php echo Url::to('assets/js/historial-medico/registrarConsulta.js'); ?>"></script> -->
    <script type="module" src="<?php echo Url::to('assets/js/historial-medico/addAntecedente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/historial-medico/updateAntecedente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/historial-medico/deleteAntecedente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addInsumoInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addIndicacionInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/addRecipeInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/deleteInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/registrarConsulta.js'); ?>"></script>
    <!-- <script type="module" src="<?php echo Url::to('assets/js/pacientes/mostrarPacientes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/tipoPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/registrarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/actualizarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/eliminarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/addTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/deleteTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/pacienteMenorDeEdad.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script> -->
</body>