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
    <title>Proyecto 4 | Medicamentos</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Medicamentos</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Medicamento</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Medicamentos -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Medicamentos</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="medicamentos" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Especialidad</th>
                                            <th>Tipo de medicamento</th>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Medicamento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form id="info-medicamento" class="p-3 px-4">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre_medicamento" class="form-control mb-3" data-max-length="45" required>
                            <label for="tipo_medicamento">Tipo de medicamento</label>
                            <select name="tipo_medicamento" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de medicamento</option>
                                <option value="1">Cápsula</option>
                                <option value="2">Jarabe</option>
                                <option value="3">Inyección</option>
                            </select>
                            <label for="especialidad">Especialidad</label>
                            <select name="especialidad_id" id="s-especialidad" class="form-control mb-3" data-active="0" required>
                                <option value="">Seleccione la especialidad</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addMedicamento()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Medicmaento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form id="act-medicamento" class="p-3 px-4">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre_medicamento" class="form-control mb-3" data-max-length="45" required>
                            <label for="tipo_medicamento">Tipo de medicamento</label>
                            <select name="tipo_medicamento" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de medicamento</option>
                                <option value="1">Cápsula</option>
                                <option value="2">Jarabe</option>
                                <option value="3">Inyección</option>
                            </select>
                            <label for="especialidad">Especialidad</label>
                            <select name="especialidad_id" id="s-especialidad-update" class="form-control mb-3" data-active="0" required>
                                <option value="">Seleccione la especialidad</option>
                            </select>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Medicamento</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este medicamento?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/medicamentos/mostrarMedicamentos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicamentos/registrarMedicamento.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicamentos/actualizarMedicamento.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicamentos/eliminarMedicamento.js'); ?>"></script>
</body>

</html>