<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">

    <title>Proyecto 4 | Auditoria</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-12 col-md-6">
                    <h4 class="pt-5 pb-2 text-grey">Auditoría</h4>
                    <h5 class="pt-3 pb-2 text-grey d-inline">Filtrar por:</h5>
                    <!-- <small class="d-inline-flex mb-3 px-2 py-1 fw-semibold text-success-emphasis alert alert-danger border border-success-subtle rounded-2" role="alert">La fecha final no puede ser inferior a la fecha inicial</small> -->

                    <!-- <select id="inputFiltro" class="form-select d-inline w-50">
                        <option value="" selected disabled>Seleccione un filtro</option>
                        <option value="sinFiltro">Sin filtro</option>
                        <option value="submenu-fecha">Fecha</option>
                        <option value="submenu-usuario">Usuario</option>
                        <option value="submenu-accion">Acción</option>
                    </select> -->
                    <form id="filtrarPor">
                        <!-- <div class="sub-menus"> -->
                        <div class="submenu-fecha row">
                            <div class="d-flex align-items-end justify-content-start mt-3">
                                <input type="checkbox" name="fecha" class="form-check-input me-3" onchange="filtrarAuditoriaInput(this)">
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
                                    <input type="checkbox" name="usuario" class="form-check-input me-3" onchange="filtrarAuditoriaInput(this)">
                                    <h6 class="mb-0 form-check-label" for="usuario">Usuario</h6>
                                </div>
                                <select name="usuario_id" id="s-usuario" class="form-control mb-3" data-active="0" required disabled>
                                    <option></option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="d-flex align-items-end justify-content-start mt-2 mb-3">
                                    <input type="checkbox" name="modulo" class="form-check-input me-3" onchange="filtrarAuditoriaInput(this)">
                                    <h6 class="mb-0 form-check-label" for="modulo">Módulo</h6>
                                </div>
                                <select name="moduloValue" id="s-modulo" class="form-control mb-3" required disabled>
                                    <option selected disabled>Seleccione un módulo</option>
                                    <option value="antecedentes">Antecedentes</option>
                                    <option value="citas">Citas</option>
                                    <option value="consultas">consultas</option>
                                    <option value="empresas">Empresas</option>
                                    <option value="especialidad">Especialidad</option>
                                    <option value="exámenes">Exámenes</option>
                                    <option value="insumos">Insumos</option>
                                    <option value="medicamentos">Medicamentos</option>
                                    <option value="médicos">Médicos</option>
                                    <option value="pacientes">Pacientes</option>
                                    <option value="proveedores">Proveedores</option>
                                    <option value="seguros">Seguros</option>
                                    <option value="usuarios">Usuarios</option>
                                    <option value="orden de compra">Orden de compra</option>
                                    <option value="recibo de consulta">Recibo de consulta</option>
                                    <option value="recibo de pago médico">Recibo de pago médico</option>
                                    <option value="recibo de mensajería">Recibo de mensajería</option>
                                    <option value="recibo de seguros">Recibo de seguros</option>
                                </select>
                            </div>
                        </div>
                        <div class="submenu-accion row">
                            <div class="d-flex align-items-end justify-content-start mt-2 mb-3">
                                <input type="checkbox" name="accion" class="form-check-input me-3" onchange="filtrarAuditoriaInput(this)">
                                <h6 class="mb-0 form-check-label" for="accion">Acción</h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <select name="accionValue" id="s-accion" class="form-control mb-3" required disabled>
                                    <option selected disabled>Seleccione una acción</option>
                                    <option value="eliminación">Eliminar</option>
                                    <option value="actualización">Actualizar</option>
                                    <option value="inserción">Insertar</option>
                                </select>
                            </div>
                        </div>
                        <!-- </div> -->
                        <button type="button" id="btn-registrar" class="btn btn-sm btn-add d-inline" onclick="filtrarAuditoria(event)"><i class="fas fa-sm fa-filter"></i> Filtrar</button>
                </div>
                <div class="col-12 col-md-6 d-flex justify-content-end align-items-end flex-column">
                    <a data-bs-target="#modalConfirmExport" data-bs-toggle="modal" type="button" id="btn-registrar" class="btn btn-sm btn-add d-inline"><i class="fas fa-sm fa-file-export"></i> Exportar Base de Datos</a>
                    <a type="button" id="btn-upload" class="btn btn-sm btn-add d-inline my-3" data-bs-target="#modalConfirmImport" data-bs-toggle="modal"><i class="fas fa-sm fa-file-upload"></i> Importar Base de Datos</a>
                    <a href="#" type="button" id="btn-exportarPdf" class="btn btn-sm btn-add d-inline" onclick="openPopup('pdf/auditoria/00000')"><i class="fas fa-sm fa-file-export"></i>Exportar PDF</a>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="auditoria" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Usuario</th>
                                            <th>Acción</th>
                                            <th>Módulo</th>
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


        <!-- Modal subir archivo-->
        <div class="modal fade" id="modalUpload" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Importar base de datos</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalUploadBody">
                        <div id="uploadAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-upload" class="p-3 px-4">
                            <div class="p-4">
                                <label for="formFile" class="form-label">Archivo sql</label>
                                <input class="form-control" type="file" id="sqlFile" accept=".sql">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="uploadBd()">Importar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confirm export -->
        <div class="modal fade" id="modalConfirmExport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmExport" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalConfirmExportLabel">Confirmación de seguridad</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalConfirmExportBody">
                        <div id="exportConfirmAlert" class="alert d-none" role="alert"></div>
                        <div class="help-message d-flex align-items-center p-4">
                            <i class="fas fa-info-circle text-secondary me-3"></i>
                            <p class="text-secondary m-0">Para realizar la exportación de la base de datos, deberá confirmar la sesión actual del usuario por seguridad</p>
                        </div>
                        <form action="#" id="info-validarExport" class="p-3 px-4">
                            <div class="p-4 pt-0">
                                <label for="formFile" class="form-label">Clave del usuario</label>
                                <input class="form-control" type="password" id="claveUserExport">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-exportInfo" class="btn btn-primary" onclick="confirmValidateExport()">Validar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal confirm import -->
        <div class="modal fade" id="modalConfirmImport" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalConfirmImport" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalConfirmImportLabel">Confirmación de seguridad</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalConfirmImportBody">
                        <div id="importConfirmAlert" class="alert d-none" role="alert"></div>
                        <div class="help-message d-flex align-items-center p-4">
                            <i class="fas fa-info-circle text-secondary me-3"></i>
                            <p class="text-secondary m-0">Para realizar la importación de la base de datos, deberá confirmar la sesión actual del usuario por seguridad</p>
                        </div>
                        <form action="#" id="info-validarImport" class="p-3 px-4">
                            <div class="p-4 pt-0">
                                <label for="formFile" class="form-label">Clave del usuario</label>
                                <input class="form-control" type="password" id="claveUserImport">
                                <p id="loadingMessage" class="m-auto mt-3 text-center" style="display: none;">Cargando...</p>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-importInfo" class="btn btn-primary" onclick="confirmValidateImport()">Validar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/mostrarAuditoria.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/filtrarPorTipo.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/filtrarAuditoria.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/uploadBd.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/confirmValidateExport.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/auditoria/confirmValidateImport.js'); ?>"></script>
</body>

</html>