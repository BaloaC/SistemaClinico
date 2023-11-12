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
    <title>Proyecto 4 | Insumos</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Insumos</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Insumo</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Insumos -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="insumos" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Cantidad Mínima</th>
                                            <th>Precio</th>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Insumo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form id="info-insumo" class="form-reg p-3 px-4">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="nameExam" data-max-length="45" required>
                            <small class="form-text">El nombre solo debe contener al menos 3 letras sin caracteres especiales</small>
                            <label for="cantidad">Cantidad</label>
                            <input type="number" step="any" name="cantidad" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El campo de ser mayor o igual a 0</small>
                            <label for="nombre">Cantidad mínima</label>
                            <input type="number" step="any" name="cantidad_min" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El campo de ser mayor o igual a 0</small>
                            <label for="nombre">Precio</label>
                            <input type="number" step="any" name="precio" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El precio de ser mayor o igual a 0</small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addInsumo()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Insumo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-insumo" class="p-3 px-4">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="nameExam" data-max-length="45" required>
                            <small class="form-text">El nombre solo debe contener al menos 3 letras sin caracteres especiales</small>
                            <label for="cantidad">Cantidad</label>
                            <input type="number" step="any" name="cantidad" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El campo de ser mayor o igual a 0</small>
                            <label for="nombre">Cantidad mínima</label>
                            <input type="number" step="any" name="cantidad_min" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El campo de ser mayor o igual a 0</small>
                            <label for="nombre">Precio</label>
                            <input type="number" step="any" name="precio" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <small class="form-text">El precio de ser mayor o igual a 0</small>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Insumo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este insumo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/insumos/mostrarInsumos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/insumos/registrarInsumo.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/insumos/actualizarInsumo.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/insumos/eliminarInsumo.js'); ?>"></script>
</body>

</html>