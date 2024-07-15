<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">

    <title>Proyecto 4 | Acumulados de consultas</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Acumulados de consultas</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Calcular acumulado</button>
                </div>
                <hr class="border-white">
                <!-- <div class="help-message d-flex align-items-center mb-3"> -->
                    <!-- <i class="fas fa-info-circle text-secondary me-3"></i> -->
                    <!-- <p class="text-secondary m-0">Para actualizar el estatus del recibo, debe hacer click directamente en el estatus de <span class='badge light badge-warning'>Pagar</span></p> -->
                <!-- </div> -->
            </div>
            <!-- Factura médicos -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="fMedicos" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Nombre médico</th>
                                            <th>Sumatoria consultas naturales</th>
                                            <th>Sumatoria consultas aseguradas</th>
                                            <th>Acumulado seguro</th>
                                            <th>Acumulado consulta</th>
                                            <!-- <th>Fecha de pago</th> -->
                                            <th>Fecha emisión</th>
                                            <th>Total acumulado</th>
                                            <!-- <th>Estatus</th> -->
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar recibo médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-fmedico" class="form-reg p-3 px-4">
                            <label for="medico">Médico</label>
                            <select name="medico_id" id="s-medico" class="form-control mb-3" data-active="0" required>
                                <option></option>
                            </select>
                            <!-- <label for="fecha_actual">Fecha de pago</label>
                            <input type="date" name="fecha_actual" class="form-control mb-3" required> -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addFMedico()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">A</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert alert-success d-none" role="alert">
                            Calcular todos los acumulados
                        </div>
                            ¿Está seguro que desea calcular todos los acumulados?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizar" class="btn btn-primary" onclick="actualizarFSeguro()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar recibo pago</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este recibo?
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
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/marcarComoPagado.js'); ?>"></script>
</body>

</html>