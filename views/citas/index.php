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
    <title>Proyecto 4 | Consultar Usuarios</title>
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
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Citas</h4>
                        </div>
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
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-cita" class="p-3 px-4">
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
                                                <input class="form-check-input" type="radio" name="tipoPacienteRadio" id="tipoPacienteTitular" onchange="tipoPaciente(this)" value="titular" checked required>
                                                <label class="form-check-label" for="inlineRadio1">Titular</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="tipoPacienteRadio" id="tipoPacienteBeneficiado" onchange="tipoPaciente(this)" value="beneficiado" required>
                                                <label class="form-check-label" for="inlineRadio2">Beneficiado</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <h5>Información de la Cita</h4>
                                    <div class="col-12 col-md-6">
                                        <label for="fecha_cita">Fecha cita</label>
                                        <input type="datetime-local" name="fecha_cita" id="fecha_cita" class="form-control mb-3">

                                        <label for="tipo_cita">Tipo de cita</label>
                                        <select name="tipo_cita" id="s-tipo_cita" class="form-control mb-3">
                                            <option></option>
                                        </select>

                                        <label for="titular_id" class="d-none">Titular</label>
                                        <select name="titular_id" id="s-titular" class="form-control d-none" data-active="0" data-create="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <!-- <label for="cedula_titular">Cédula Titular</label>
                                        <input type="number" name="cedula_titular" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" required> -->
                                        <!-- <small class="form-text">La cédula debe contener entre 6 o 8 números</small> -->
                                        <label for="motivo_cita">Motivo cita</label>
                                        <input type="text" name="motivo_cita" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="45">
                                        <small class="form-text">Solo se permiten letras y números</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <label for="seguro" class="d-none">Seguro</label>
                                        <select name="seguro_id" id="s-seguro" class="form-control mb-3" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-4">
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Cita</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-cita" class="p-3 px-4">
                            <label for="clave">Clave</label>
                            <input type="number" name="clave" id="clave" class="form-control">

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5 fw-bold" id="paciente"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <p class="fw-bold" id="cedula-titular"></p>
                            <p><span>Detalles cita:</span></p>
                            <p>Médico: <span id="nombreMedico"></span></p>
                            <p>Especialidad: <span id="nombreEspecialidad"></span></p>
                            <p>Tipo de cita: <span id="tipoCita"></span></p>
                            <p>Estatus: <span id="estatusCita"></span></p>
                            <p>Clave cita: <span id="claveCita"></span></p>
                            <p>Fecha cita: <input type="datetime-local" id="fechaCita" class="form-control w-50" disabled></p>
                            <p>Motivo cita: <span id="motivoCita"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <a class="btn btn-sm btn-add" href="#" id="export-cita"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a>
                        <!-- <a href="#" id="export-cita"><i class="fas fa-file-export"></i></a> -->
                        <button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar</button>
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
    <script src="<?php echo Url::to('assets/libs/fullcalendar/index.global.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/fullcalendar/es.global.min.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/calendarioCitas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/addCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/confirmUpdateCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/updateCita.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/citas/calendarioCitas.js'); ?>"></script>

</body>

</html>