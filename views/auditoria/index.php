<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
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
                    <h4 class="pt-5 pb-2 text-grey">Auditoría</h4>
                    <h5 class="pt-3 pb-2 text-grey d-inline">Filtrar por:</h5>
                    <select id="inputFiltro" class="form-select d-inline w-50">
                        <option value="" selected disabled>Seleccione un filtro</option>
                        <option value="sinFiltro">Sin filtro</option>
                        <option value="fecha">Fecha</option>
                        <option value="usuario">Usuario</option>
                        <option value="accion">Acción</option>
                    </select>
                    <form id="filtrarPor">
                        <div class="sub-menus">
                            <div class="submenu-fecha row opacity-0 d-none">
                                <div class="col-12 col-md-6">
                                    <label for="titular">Fecha inicio</label>
                                    <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control mb-3" required>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="tipo_relacion">Fecha fin</label>
                                    <input type="date" name="fecha_fin" id="fecha_fin" class="form-control mb-3" required>
                                </div>
                            </div>
                            <div class="submenu-usuario row opacity-0 d-none">
                                <div class="col-12 col-md-6">
                                    <label for="usuario">Usuario</label>
                                    <select name="usuario" id="s-usuario" class="form-control mb-3" data-active="0" required>
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                            <div class="submenu-accion row opacity-0 d-none">
                                <div class="col-12 col-md-6">
                                    <label for="accion">Acción</label>
                                    <select name="accion" id="s-accion" class="form-control mb-3" required>
                                        <option selected disabled>Seleccione una acción</option>
                                        <option value="delete">Eliminar</option>
                                        <option value="update">Actualizar</option>
                                        <option value="insert">Insertar</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="button" id="btn-registrar" class="btn btn-sm btn-add d-inline" onclick="filtrarAuditoria(event)"><i class="fas fa-sm fa-filter"></i> Filtrar</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Auditoría</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="auditoria" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>Descripción</th>
                                            <th>Fecha</th>
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

        <!-- Modal Confirmar Eliminación -->
        <!-- <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Especialidad</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar esta especialidad?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div> -->

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/mostrarAuditoria.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/filtrarPorTipo.js'); ?>"></script>
</body>

</html>