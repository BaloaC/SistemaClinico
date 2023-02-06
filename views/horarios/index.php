<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/fontawesome/css/all.min.css'); ?>">

    <title>Proyecto 4 | Consultar Usuarios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h1 class="p-4 text-light">Horarios médicos</h1>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-blue" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg">Añadir horarios</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Horarios -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Horarios médicos</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="horarios" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Día</th>
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
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Horario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-horarios" class="p-3 px-4">
                            <label for="nombre">Cédula médico</label>
                            <input type="text" name="nombre" class="form-control mb-3">
                            <label for="horarios" class="d-block mb-1">Seleccione los días disponibles:</label>
                            <div class="two-inputs">
                                <div class="row">
                                    <label for="lunes"><input type="checkbox" name="lunes" id="lunes">Lunes</label>
                                    <label for="martes"><input type="checkbox" name="martes" id="martes">Martes</label>
                                </div>
                            </div>
                            <div class="two-inputs">
                                <div class="row">
                                    <label for="miercoles"><input type="checkbox" name="miercoles" id="miercoles">Miércoles</label>
                                    <label for="jueves"><input type="checkbox" name="jueves" id="jueves">Jueves</label>
                                </div>
                            </div>
                            <div class="two-inputs">
                                <div class="row">
                                    <label for="viernes"><input type="checkbox" name="viernes" id="viernes">Viernes</label>
                                    <label for="sabado"><input type="checkbox" name="sabado" id="sabado">Sábado</label>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Horario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-especialidad" class="p-3 px-4">
                            <label for="nombre">Horarios</label>
                            <input type="text" name="nombre" class="form-control mb-3">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <script type="text/javascript" src="<?php echo Url::to('assets/libs/datatables/datatables.min.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/horarios/mostrarHorarios.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/horarios/registrarHorario.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/especialidades/actualizarEspecialidad.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/eliminarPaciente.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/bootstrap/bootstrap.bundle.min.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>

</html>