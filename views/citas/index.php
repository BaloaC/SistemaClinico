<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/calendario.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/flatpickr/flatpickr.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/flatpickr-custom.css'); ?>">
    <title>Proyecto 4 | Citas</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Citas</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <!-- <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Citas</button> -->
                </div>
                <hr class="border-white">
            </div>
            <!-- Citas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div id="calendar"></div>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Cita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div id="alertAddCita" class="alert d-none" role="alert"></div>
                        <form action="" id="info-cita" class="form-reg p-3 px-4">
                            <div class="row">
                                <div class="row">
                                    <h5>Información del Paciente</h5>
                                    <div class="col-12 col-md-6">
                                        <label for="paciente_id">Paciente</label>
                                        <select name="paciente_id" id="s-paciente" class="form-control" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="input-radios-container" class="d-none">Tipo de paciente</label>
                                        <div class="input-radios-container d-none">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipoPacienteRadio" id="tipoPacienteTitular" onchange="tipoTitular(this)" value="titular" checked required>
                                                <label class="form-check-label" for="inlineRadio1">Titular</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipoPacienteRadio" id="tipoPacienteBeneficiado" onchange="tipoTitular(this)" value="beneficiado" required>
                                                <label class="form-check-label" for="inlineRadio2">Beneficiado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <h5>Información de la Cita</h4>
                                        <div class="col-12 col-md-6">

                                            <label for="tipo_cita">Tipo de cita</label>
                                            <select name="tipo_cita" id="s-tipo_cita" class="form-control mb-3" disabled>
                                                <option value="default" disabled selected>Debe seleccionar un paciente</option>
                                                <option value="1">Normal</option>
                                                <option value="2">Asegurada</option>
                                            </select>

                                            <label for="seguro" class="d-none">Seguro</label>
                                            <select name="seguro_id" id="s-seguro" class="form-control mb-3 d-none" data-active="0" data-create="0">
                                                <option></option>
                                            </select>

                                            <label for="titular_id" class="d-none">Titular</label>
                                            <select name="titular_id" id="s-titular" class="form-control d-none" data-active="0" data-create="0">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="motivo_cita">Motivo cita</label>
                                            <input type="text" name="motivo_cita" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="45">
                                            <small class="form-text">Solo se permiten letras y números</small>

                                        </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="input-radios-container" class="">Tipo de servicio</label>

                                        <select name="tipo_servicio" id="s-tipo-servicio" onchange="tipoServicio(this)" class="form-control mb-3" required>
                                            <option value="1">Solo exámenes</option>
                                            <option value="3">Consulta con exámenes</option>
                                            <option value="2" selected>Consulta sin exámenes</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <h5>Información del médico</h2>
                                        <div class="col-12 col-md-6">
                                            <label for="especialidad_id">Especialidad</label>
                                            <select name="especialidad_id" id="s-especialidad" class="form-control" data-active="0">
                                                <option></option>
                                            </select>
                                            <div class="examenInput" style="display: none;">
                                                <label for="examenes">Exámenes a realizar (Opcional)</label>
                                                <select name="examenes[]" id="s-examen" class="form-control mb-3" data-active="0" multiple="multiple" disabled>
                                                    <option></option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="medico_id">Médico</label>
                                            <select name="medico_id" id="s-medico" class="form-control" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                </div>
                                <div class="row mt-4">
                                    <h5>Horario de la cita</h2>
                                        <div class="col-12 col-md-6">
                                            <label for="fecha_cita">Fecha cita</label>
                                            <input type="date" name="fecha_cita" id="fecha_cita" data-validate="true" data-type="date" disabled class="form-control mb-3 flatpickr-input-readonly fecha_cita">
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <p style="padding-top: 10px">Leyenda:</p>
                                            <ul class="leyenda">
                                                <li>Horario del médico disponible</li>
                                                <li>Horario del médico ocupado</li>
                                                <li>Días fueras del horario del médico</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-md-6 contact-medico" style="display: none;">
                                            <p>Para asignar citas fuera del horario del médico puede comunicarse con él a través del siguiente número telefónico: <br> <b id="numeroTelefonicoMedico">Seleccione el médico para mostrar su número de contacto</b></p>
                                            <label for="input-radios-container">¿El médico autorizó la asignación de la cita fuera de su horario establecido?</label>
                                            <div class="input-radios-container">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="forzar_hora" id="forzar_cita_si" value="true">
                                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="forzar_hora" id="forzar_cita_no" value="false" checked>
                                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="horarios-tableNotFound"><b>El médico no tiene horarios asignados</b></div>
                                        <table id="horarios-table" class="table table-borderless" style="display: none;">
                                            <h6 class="my-3 fw-bolder medicoScheduleLabel" style="display: none;">Horario del médico</h6>
                                            <thead>
                                                <tr>
                                                    <th>Día</th>
                                                    <th>Hora Entrada</th>
                                                    <th>Hora Salida</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Día</td>
                                                    <td>Hora Entrada</td>
                                                    <td>Hora Salida</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-12 col-md-6">
                                        <label for="hora_entrada">Hora entrada</label>
                                        <input type="time" name="hora_entrada" id="hora_entrada" step="1" disabled class="form-control hora_entrada flatpickr-input-readonly mb-3">
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="hora_salida">Hora salida</label>
                                        <input type="time" name="hora_salida" id="hora_salida" step="1" disabled class="form-control hora_salida flatpickr-input-readonly mb-3">
                                    </div>
                                    <div class="col-12">
                                        <h6 class="my-3 fw-bolder citaScheduleLabel" style="display: none;">Citas asigandas del día</h6>
                                        <h6 class="withoutCitas" style="display: none;">No hay citas asiganadas para este día</h6>
                                        <table id="citas-table" class="table table-borderless" style="display: none;">
                                            <thead>
                                                <tr>
                                                    <th>Hora Entrada</th>
                                                    <th>Hora Salida</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addCita()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualización de la Cita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-cita" class="p-3 px-4">
                            <div class="col-12 col-md-8 d-flex align-items-center">
                                <i class="fas fa-info-circle text-secondary me-3"></i>
                                <p class="text-secondary m-0">Las citas se mantendrán como pendientes hasta que la clave otorgada por el seguro sea insertada.</p>
                            </div>
                            <div class="col-12 col-md-8 d-flex align-items-center mt-3">
                                <i class="fas fa-exclamation-circle text-warning me-3"></i>
                                <p class="m-0">Importante: Los exámenes que no se puedan cubrir por el seguro, automáticamente serán cubiertos por el paciente, de no querer cubrirlos, deberá eliminarlos.</p>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="clave">Clave</label>
                                    <input type="text" name="clave" id="clave" class="form-control mb-3">

                                    <div class="d-flex align-items-center justify-content-start">
                                        <input type="checkbox" class="form-check-input me-3" onclick="return false;" checked >
                                        <p class="m-0 form-check-label">Cubrir costo consulta: <span id="costoConsulta"></span></p>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="monto" class="">Monto aprobado</label>
                                    <input type="number" step="any" name="monto_aprobado" data-validate="true" data-type="price" class="form-control" oninput="montoAprobadoHandler(this)" required>
                                    <small class="form-text">No se permiten números negativos</small>
                                </div>
                            </div>

                            <div class="row examenesCitaContainer mt-3">
                                <h5>Exámenes</h5>
                                <div class="table-responsive">
                                    <table class="table table-borderless">
                                        <thead>
                                            <tr>
                                                <th>Eliminar</th>
                                                <th>Cubierto Por Seguro</th>
                                                <!-- <th>Cubierto Por Paciente</th> -->
                                                <th>Precio</th>
                                                <th>Nombre</th>
                                            </tr>
                                        </thead>
                                        <tbody class="examenesCitaTbody">
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <h6 id="sinExamenesCita" class="mt-4" style="display: none;">No hay exámenes por cubrir</h6>

                        </form>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <p id="montoDisponible"></p>
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Reprogramar -->
        <div class="modal fade" id="modalReprogramar" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalReprogramarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalReprogramarLabel">Reprogramación de citas</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBodyReprogramar">
                        <div id="reprogramacionAlert" class="alert reprogramacionAlert d-none" role="alert"></div>
                        <form action="" id="reprogramacion-cita" class="p-3 px-4">
                            <p class="text-secondary">Las citas se mantendrán como pendientes hasta que la clave otorgada por el seguro sea insertada</p>
                            <label for="clave">Nueva fecha</label>
                            <input type="date" name="fecha_cita" id="fecha_cita_reprogramada" data-validate="true" data-type="date" class="form-control fecha_cita_reprogramada mb-3 flatpickr-input-readonly" required>
                            <p style="padding-top: 10px">Leyenda:</p>
                            <ul class="leyenda">
                                <li>Horario del médico disponible</li>
                                <li>Horario del médico ocupado</li>
                                <li>Días fueras del horario del médico</li>
                            </ul>
                            <table id="horarios-table-reschedule" class="table table-borderless" style="display: none;">
                                <h6 class="my-3 fw-bolder medicoRescheduleLabel" style="display: none;">Horario del médico</h6>
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Día</td>
                                        <td>Hora Entrada</td>
                                        <td>Hora Salida</td>
                                    </tr>
                                </tbody>
                            </table>
                            <label for="hora_entrada">Hora entrada</label>
                            <input type="time" name="hora_entrada" id="hora_entrada2" data-type="timeAppointment" step="1" class="form-control hora_entrada2 flatpickr-input-readonly mb-3" disabled>
                            <label for="hora_salida">Hora salida</label>
                            <input type="time" name="hora_salida" id="hora_salida2" data-type="timeAppointment" step="1" class="form-control hora_salida2 flatpickr-input-readonly mb-3" disabled>
                            <h6 class="my-3 fw-bolder citaRescheduleLabel">Citas asigandas del día</h6>
                            <h6 class="withoutCitasReschedule" style="display: none;">No hay citas asiganadas para este día</h6>
                            <table id="citas-table-reschedule" class="table table-borderless" style="display: none;">
                                <thead>
                                    <tr>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmReprogramation()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold">Paciente: <span id="paciente"></span></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <p class="fw-bold" id="cedula-titular"></p>
                            <p><span>Detalles cita:</span></p>
                            <p>Médico: <span id="nombreMedico"></span></p>
                            <p>Especialidad: <span id="nombreEspecialidad"></span></p>
                            <p>Tipo de cita: <span id="tipoCita"></span></p>
                            <p>Exámenes: <span id="examenesCita"></span></p>
                            <p>Estatus: <span id="estatusCita"></span></p>
                            <p>Clave cita: <span id="claveCita"></span></p>
                            <p>Fecha cita: <input type="date" id="fechaCita" class="form-control w-50" disabled></p>
                            <p>Hora entrada: <input type="time" id="horaEntradaCita" class="form-control w-50" disabled></p>
                            <p>Hora salida: <input type="time" id="horaSalidaCita" class="form-control w-50" disabled></p>
                            <p>Motivo cita: <span id="motivoCita"></span></p>
                            <button type="button" id="btn-reprogramar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalReprogramar">Reprogramar Cita</button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a class="btn btn-sm btn-add" href="#" id="export-cita"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a>
                        <!-- <a href="#" id="export-cita"><i class="fas fa-file-export"></i></a> -->
                        <button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Registrar Clave</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal alert -->
        <div class="modal fade" id="modalAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAlertLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAlertLabel">Advertencia</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="alertMessage" class="alert alert-warning d-none" role="alert"></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script src="<?php echo Url::to('assets/libs/flatpickr/flatpickr.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/flatpickr/es.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/fullcalendar/index.global.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/fullcalendar/es.global.min.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/calendarioCitas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/addCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/confirmUpdateCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/updateCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/reprogramationCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/confirmReprogramation.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/calendarioCitas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/tipoServicio.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/montoAprobadoHandler.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/checkExamenHandler.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/deleteExamenCoberture.js'); ?>"></script>
</body>

</html>