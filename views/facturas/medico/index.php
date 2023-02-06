<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Facturas Médicos</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6"><h4 class="pt-5 pb-2 text-grey">Facturas Médicos</h4></div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Factura</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Factura médicos -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Facturas médicos registradas</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="fMedicos" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Nombre doctor</th>
                                            <th>Acumulado seguro</th>
                                            <th>Acumulado consulta</th>
                                            <th>Fecha de pago</th>
                                            <th>Total a pagar</th>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar factura compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-fmedico" class="p-3 px-4">
                            <label for="medico">Médico</label>
                            <select name="medico_id" id="s-medico" class="form-control mb-3" data-active="0">
                                <option></option>
                            </select>
                            <label for="fecha_actual">Fecha de pago</label>
                            <input type="date" name="fecha_actual" class="form-control mb-3">
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFMedico()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar factura compra</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar esta factura?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/mostrarFMedicos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/registrarFMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/eliminarFMedico.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
</body>

</html>