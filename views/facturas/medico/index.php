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
                    <h4 class="pt-5 mb-4 text-grey">Acumulados de consultas</h4>
                    <h5 class="text-grey d-inline">Filtrar por:</h5>

                    <form id="filtrarPor">
                        <!-- <div class="sub-menus"> -->
                        <div class="submenu-fecha row">
                            <div class="d-flex align-items-end justify-content-start mt-3">
                                <input type="checkbox" name="fecha" class="form-check-input me-3" onchange="filtrarFacturasMedicoInput(this)">
                                <h6 class="mb-0 form-check-label" for="fecha">Por fecha</h6>
                                <!-- <p class="m-0 form-check-label">Cubrir costo consulta: <span id="costoConsulta"></span></p> -->
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="titular">Fecha inicio</label>
                                <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control mb-3" required disabled>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="tipo_relacion">Fecha fin</label>
                                <input type="date" name="fecha_fin" id="fecha_fin" class="form-control mb-3" required disabled>
                            </div>
                        </div>
                        <div class="submenu-usuario row">
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-end justify-content-start mt-2 mb-3">
                                    <input type="checkbox" name="usuario" class="form-check-input me-3" onchange="filtrarFacturasMedicoInput(this)">
                                    <h6 class="mb-0 form-check-label" for="usuario">Usuario</h6>
                                </div>
                                <select name="medico_id" id="s-medico-filter" class="form-control mb-3" data-active="0" required disabled>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <button type="button" id="btn-registrar" class="btn btn-sm mb-3 btn-add d-inline" onclick="filtrarFacturaMedico(event)"><i class="fas fa-sm fa-filter"></i> Filtrar</button>
                    </form>
                </div>
                <div class="col-6 d-flex align-items-end justify-content-end">
                    <button class="btn btn-sm btn-add me-3 mb-3" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalAct"><i class="fa-sm fas fa-plus"></i> Calcular todos los acumulados</button>
                    <button class="btn btn-sm btn-add mb-3" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Calcular acumulado</button>
                </div>
                <hr class="border-white">
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
                        <h1 class="modal-title fs-3" id="modalActLabel">Calcular todos los acumulados</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert alert-success d-none" role="alert">
                            Todos los acumulados se generaron exitosamente!
                        </div>
                        ¿Está seguro que desea calcular todos los acumulados?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizar" class="btn btn-primary" onclick="generarTodosLosAcumulados()">Actualizar</button>
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
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/filtrarFacturasMedicoInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/generarTodosLosAcumulados.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/facturas-medicos/filtrarFacturaMedico.js'); ?>"></script>
</body>

</html>