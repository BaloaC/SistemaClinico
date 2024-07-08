<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Consultas</title>
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
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Consulta</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Consultas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="consultas" data-code-false-ajax="null" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Item</th>
                                            <th>Cédula Paciente</th>
                                            <th>Nombre Paciente</th>
                                            <th>Nombre Médico</th>
                                            <th>Especialidad</th>
                                            <th>Cédula Titular</th>
                                            <th>Fecha Consulta</th>
                                            <!-- <th>Acciones</th> -->
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
                                <h5>Información del servicio</h5>
                                <div class="col-12 col-md-6">
                                    <label for="tipoConsulta">Tipo de consulta</label>
                                    <select name="es_emergencia" id="s-tipo_consulta" class="form-control my-3">
                                        <option value="1">Por emergencia</option>
                                        <option value="2">Normal</option>
                                        <option value="0" selected>Con cita previa</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tipoServicio" style="display: none;">Tipo de servicio</label>
                                    <select id="tipoConsultas" name="tipoConsulta" class="form-control my-3 " onchange="tipoConsultaSelect(this)" style="display: none;">
                                        <option value="examen">Exámen</option>
                                        <option value="consultaSinExamen" selected>Consulta sin exámenes</option>
                                        <option value="consulta" selected>Consulta con exámenes</option>
                                    </select>
                                </div>
                            </div>

                            <div class="info-examenes mt-3" style="display: none;">
                                <h5>Información del Paciente</h5>
                                <div class="col-12 col-md-6">
                                    <label for="nombres">Paciente Titular</label>
                                    <select name="paciente_id" id="s-paciente-sinConsulta" class="form-control" data-active="0" required disabled>
                                        <option></option>
                                    </select>
                                </div>
                                <h5>Información del médico</h2>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label for="especialidad_id">Especialidad</label>
                                            <select name="especialidad_id" id="s-especialidad-sinConsulta" class="form-control" data-active="0" disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="medico_id">Médico</label>
                                            <select name="medico_id" id="s-medico-sinConsulta" class="form-control" data-active="0" disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                    <h5>Información de la Consulta</h5>
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <label for="examenes">Exámenes realizados en la consulta</label>
                                            <select name="examenes[]" id="s-examen-sinConsulta" class="form-control mb-3" data-active="0" multiple="multiple" disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="observaciones">Observaciones</label>
                                            <input type="text" name="observaciones" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" disabled>
                                            <small class="form-text">El campo debe contener al menos 3 letras y solo se permiten los siguientes simbolos "@#+_,-"</small>
                                        </div>
                                    </div>
                            </div>

                            <div class="info-consultaSinExamenes">
                                <div class="row">
                                    <div class="row ">
                                        <h5 class="info-cita-label">Información de la cita</h5>
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
                                            <label for="nombres">Paciente Titular</label>
                                            <select name="paciente_id" id="s-paciente" class="form-control" data-active="0" required>
                                                <option></option>
                                            </select>

                                            <div class="inputCedulaBeneficiado" style="display: none;">
                                                <label for="cedula" id="cedula_beneficiado-label" style="display: none;">Cédula beneficiado</label>
                                                <select name="cedula_beneficiado" id="cedula_beneficiado" class="form-control mb-3" style="display: none;" disabled required>
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">

                                            <label for="forRegistrarFactura" id="pacienteBeneficiadoEmergenciaLabel">¿La consulta es para un paciente beneficiado?</label>
                                            <div class="input-radios-container inputPacienteBeneficiadoEmergencia">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pacienteBeneficiadoEmergencia" id="pacienteBeneficiadoEmergenciaSi" value="1" onchange="pacienteBeneficiadoEmergenciaInput(this.value)" required disabled>
                                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="pacienteBeneficiadoEmergencia" id="pacienteBeneficiadoEmergenciaNo" value="0" onchange="pacienteBeneficiadoEmergenciaInput(this.value)" checked required disabled>
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-4 info-medico" style="display: none;">
                                        <h5>Información del médico</h2>
                                            <div class="col-12 col-md-6">
                                                <label for="especialidad_id">Especialidad</label>
                                                <select name="especialidad_id" id="s-especialidad" class="form-control" data-active="0">
                                                    <option></option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="medico_id">Médico</label>
                                                <select name="medico_id" id="s-medico" class="form-control" data-active="0">
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

                                            <label for="fecha_consulta" style="display: none;">Fecha consulta</label>
                                            <input type="date" name="fecha_consulta" id="fecha_consulta_input" class="form-control mb-3" style="display: none;" data-validate="true" data-type="date" disabled required>
                                            <input type="hidden" name="fecha_consulta" id="fecha_consulta_cita">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <div class="examenSelect">
                                                <label for="examenes">Exámenes realizados en la consulta</label>
                                                <select name="examenes[]" id="s-examen" class="form-control mb-3" data-active="0" multiple="multiple">
                                                    <option></option>
                                                </select>
                                            </div>

                                            <label for="observaciones">Observaciones</label>
                                            <input type="text" name="observaciones" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255">
                                            <small class="form-text">El campo debe contener al menos 3 letras y solo se permiten los siguientes simbolos "@#+_,-"</small>
                                        </div>
                                    </div>

                                    <div class="row mt-4 info-consulta-emergencia" style="display: none;">
                                        <h5>Información de la consulta de emergencia</h5>
                                        <h6>Nota: todos los montos ingresados deben ser en dólares.</h6>
                                        <div class="col-12 col-md-6">
                                            <label for="monto-consulta">Enfermería</label>
                                            <input type="number" step="any" name="enfermeria" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                            <small class="form-text">No se permiten números negativos</small>
                                            <label for="monto-consulta">Monto consulta</label>
                                            <input type="number" step="any" name="consultas_medicas" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" value="0" disabled required>
                                            <small class="form-text">No se permiten números negativos</small>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="cedula">Area de observación</label>
                                            <input type="number" name="area_observacion" class="form-control mb-3" data-validate="true" data-type="number" data-max-length="6" value="0" disabled required>
                                            <small class="form-text">No se permiten números negativos</small>
                                            <!-- <label for="cedula">Total insumos</label>
                                            <input type="number" name="total_insumos" class="form-control mb-3" data-validate="true" data-type="number" data-max-length="6" value="0" disabled required>
                                            <small class="form-text">No se permiten números negativos</small> -->
                                            <label for="seguro">Seguro</label>
                                            <select id="s-seguro-emergencia" name="seguro_id" class="form-control seguro-emergencia" data-active="0" disabled required>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <!-- <label for="forRegistrarFactura">¿Desea registrar la factura directamente?</label>
                                            <div class="input-radios-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="registrarFacturaBool" id="registrarFacturaSi" value="1" required disabled>
                                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="registrarFacturaBool" id="registrarFacturaNo" value="0" checked required disabled>
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div> -->
                                            <!-- <label for="forRegistrarPagoMedico" id="registrarPagoMedicoLabel">¿Desea registrar el pago de algún médico?</label>
                                            <div class="input-radios-container inputRadioPagoMedico">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="registrarPagoMedicoBool" id="RegistrarPagoMedicoSi" value="1" onchange="pagoMedicosInput(this.value)" required disabled>
                                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="registrarPagoMedicoBool" id="RegistrarPagoMedicoNo" value="0" onchange="pagoMedicosInput(this.value)" checked required disabled>
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div> -->
                                        </div>
                                        <div class="col-12 col-md-6">

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
                                            <input type="number" name="monto_pago" step="any" class="form-control mb-3 monto-pago" data-validate="true" data-type="price" disabled>
                                            <small class="form-text">No se permiten números negativos</small>
                                        </div>
                                        <div class="col-3 col-md-1 d-none align-selft-start">
                                            <button type="button" class="btn" onclick="deleteInput(this,'.medico-pago-id')"><i class="fas fa-times m-0"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3 w-25" style="display: none;" id="addMedicoPago" onclick="addMedicoPagoInput()">Añadir otro médico</button>
                                </div>

                                <div class="row mt-4 info-insumos-emergencia" style="display: none;">
                                    <h5>Insumos utilizados en la Consulta (Opcional)</h5>
                                    <div class="row align-items-start">
                                        <div class="col-12 col-md-5">
                                            <label for="insumo">Insumo</label>
                                            <select id="s-insumo" class="form-control insumo-id" data-active="0" disabled>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="cantidad">Cantidad utilizada</label>
                                            <input type="number" step="any" data-validate="true" data-type="price" class="form-control mb-3 insumo-cant" disabled>
                                            <small class="form-text col-12">Solo se permiten números</small>
                                            <small class="text-secondary mensaje-medida"></small>
                                        </div>
                                        <div class="col-3 col-md-1 d-none align-self-start">
                                            <button type="button" class="btn" onclick="deleteInput(this,'.insumo-id')"><i class="fas fa-times m-0"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-primary mt-3 w-25" style="display: none;" id="addInsumo" onclick="addInsumoInput()">Añadir otro insumo</button>
                                </div>

                                <div class="row mt-4">
                                    <h5>Recipes otorgados en la Consulta (Opcional)</h5>
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-5">
                                            <label for="medicamento">Filtrar por especialidad</label>
                                            <select id="s-especialidadm" class="form-control especialidad-id" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="medicamento">Medicamento</label>
                                            <select id="s-medicamento" class="form-control medicamento-id" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="uso">Uso</label>
                                            <input type="text" data-validate="true" data-type="address" class="form-control uso-medicamento">
                                            <small class="form-text">El campo debe contener al menos 3 letras y solo se permiten los siguientes simbolos "@#+_,-"</small>
                                        </div>
                                        <div class="col-3 col-md-1 d-none align-self-start">
                                            <button type="button" class="btn" onclick="deleteInput(this,'.medicamento-id')"><i class="fas fa-times m-0"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="addRecipe" onclick="addRecipeInput()">Añadir otro recipe</button>

                                <div class="row mt-4">
                                    <h5>Indicaciones mencionadas en la Consulta (Opcional)</h5>
                                    <div class="row align-items-end">
                                        <div class="col-12 col-md-5">
                                            <label for="indicacion">Descripción de la indicación</label>
                                            <input type="text" data-validate="true" data-type="address" class="form-control indicaciones">
                                            <small class="form-text">El campo debe contener al menos 3 letras y solo se permiten los siguientes simbolos "@#+_,-"</small>
                                        </div>
                                        <!-- <div class="col-3 col-md-1 pt-4-5 d-none">
                                        <button type="button" class="btn" onclick="deleteInput(this,'.indicaciones')"><i class="fas fa-times m-0"></i></button>
                                    </div> -->
                                    </div>
                                </div>
                                <button type="button" class="btn btn-primary mt-3" id="addIndicacion" onclick="addIndicacionInput()">Añadir otra indicación</button>

                                <div class="row mt-4">
                                    <h5>Referir a otra especialidad (Opcional)</h5>
                                    <div class="row align-items-start">
                                        <div class="col-12 col-md-5">
                                            <label for="referidos">Especialidad</label>
                                            <select id="s-referidos" name="referidos[]" multiple="multiple" class="form-control" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <i class="fas fa-eraser cursor-pointer" onclick="cleanForm('info-consulta')"></i>
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-consulta" class="p-3 px-4">
                            <p for="monto-consulta"><b>Monto total de la consulta: <span id="montoTotalConsulta"></span></b></p>
                            
                            <label for="clave">Clave</label>
                            <input type="text" name="autorizacion" id="clave" class="form-control mb-3">
                            <label for="monto" class="">Monto aprobado</label>
                            <input type="number" step="any" name="monto_aprobado" data-validate="true" data-type="price" class="form-control" required>
                            <small class="form-text">No se permiten números negativos</small>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <i class="fas fa-eraser cursor-pointer" onclick="cleanForm('act-consulta')"></i>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar esta consulta?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro Factura Consulta -->
        <div class="modal fade" id="modalRegNormal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegNormalLabel" aria-hidden="true">
            <div class="modal-dialog modal-md modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegNormalLabel">Generar factura consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alertConsulta alert d-none" role="alert"></div>
                        <form action="" id="info-fconsulta" class="form-reg p-3 px-4">
                            <h6>Nota: Al introducir el monto de la consulta el sistema calculará el total con los exámenes e insumos. Adicionalmente el monto debe ser ingresado en dólares. </h6>
                            <div class="row">
                                <div class="col-12">
                                    <label for="paciente_id">Paciente</label>
                                    <select name="paciente_id" id="s-paciente-consulta" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                    <label for="consulta_id">Consulta</label>
                                    <select name="consulta_id" id="s-consulta-normal" class="form-control" data-active="0" required disabled>
                                        <option></option>
                                    </select>
                                    <label for="monto_con_iva">Método de pago</label>
                                    <select name="metodo_pago" id="s-metodo-pago" class="form-control" data-active="0" required>
                                        <option></option>
                                    </select>
                                    <label for="monto_sin_iva">Monto</label>
                                    <input type="number" step="any" name="monto_consulta_usd" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8">
                                    <small class="form-text">No se permiten números negativos</small>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFConsulta()">Generar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registro Factura Consulta Seguro-->
        <div class="modal fade" id="modalRegAsegurada" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegAseguradaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegAseguradaLabel">Generar factura seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alertConsultaSeguro d-none" role="alert"></div>
                        <form action="" id="info-fseguro" class="p-3 px-4">
                            <h6>Nota: Al introducir el monto de la consulta el sistema calculará el total con los exámenes e insumos. Adicionalmente el monto debe ser ingresado en dólares. </h6>
                            <label for="consulta_id">Consulta</label>
                            <select name="consulta_id" id="s-consulta-seguro" class="form-control mb-3" data-active="0" required>
                                <option></option>
                            </select>
                            <label for="tipo_servico">Tipo de servicio</label>
                            <select name="tipo_servicio" id="s-tipo-servicio" class="form-control mb-3" data-active="0" required>
                                <option></option>
                            </select>
                            <label for="monto">Monto</label>
                            <input type="number" name="monto_consulta_usd" id="monto" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El precio de ser mayor o igual a 0</small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFSeguro()">Generar</button>
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
    <script type="module" src="<?php echo Url::to('assets/js/facturas-consulta/mostrarFConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/registrarConsultaSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/consultaEmergencia.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/consultaSinCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/pagoMedicosInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/pacienteBeneficiadoEmergenciaInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/pagarConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/tipoConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas/updateConsulta.js'); ?>"></script>
    <script>
        document.addEventListener('DOMContentLoaded', (e) => {
            document.getElementsByName("fecha_consulta")[0].max = new Date().toISOString().split('T')[0];
        })
    </script>
</body>

</html>