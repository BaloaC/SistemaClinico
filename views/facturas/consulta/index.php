<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Facturas Consulta</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Facturas Consulta</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalRegNormal"><i class="fa-sm fas fa-plus"></i> Factura</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Factura consulta -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="fConsulta" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Nombre paciente</th>
                                            <th>Método pago</th>
                                            <th>Monto total BS</th>
                                            <th>Monto total USD</th>
                                            <th>Fecha Consulta</th>
                                            <th>Estatus</th>
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
        <div class="modal fade" id="modalRegNormal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegNormalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
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
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFConsulta()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar factura consulta</h1>
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
    <script type="module" src="<?php echo Url::to('assets/js/facturas-consulta/mostrarFConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-consulta/registrarFConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-consulta/eliminarFConsulta.js'); ?>"></script>
</body>

</html>