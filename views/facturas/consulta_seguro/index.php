<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/consultaSeguro.css'); ?>">
    <title>Proyecto 4 | Consultar Usuarios</title>

</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Info Seguro -->
            <div class="row mt-5 align-items-center justify-content-center">
                <div class="col-12 col-lg-6 text-center">
                    <h1 id="nombreSeguro"></h1>
                    <h2 id="rifSeguro"></h2>
                </div>
                <div class="col-12 col-lg-6">
                    <div id="btn-actualizar" data-bs-toggle="modal" data-bs-target="#modalAct">
                        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true" style="opacity: 1; position:relative; display:block; z-index: 0;">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content mt-5 cursor-pointer">
                                    <div class="modal-header flex-column align-items-start">
                                        <h1 class="modal-title fs-5" id="titleCard">Información adicional del seguro</h1>
                                        <small>Nota: al hacer click en cualquier parte blanca del recuadro podrá actualizar la información del seguro</small>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container">
                                            <p>Telefono: <span id="telSeguro"></span></p>
                                            <p>Dirección: <span id="direcSeguro"></span></p>
                                            <p>Porcentaje: <span id="porcentajeSeguro"></span></p>
                                            <p>Costo por consulta: <span id="costoConsultaSeguro"></span></p>
                                            <button class="btn btn-sm btn-add" data-bs-toggle="modal" data-bs-target="#modalExamenes"><i class="fa-sm fas fa-eye"></i> Precio examenes</button>
                                        </div>
                                    </div>
                                    <div class="modal-footer d-flex justify-content-between">
                                        <a data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="fas fa-trash cursor-pointer"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Cabezera -->
            <div class="row">
                <h4 class="pt-5 pb-2 text-grey">Resumen mensual de cobros del seguro</h4>
                <div class="col-md-6 d-flex flex-column align-items-end justify-content-end">

                    <!-- <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> consulta seguro</button> -->
                </div>
            </div>
            <div class="row d-flex justify-content-end">
                <div class="col-6 date-filter-container d-flex flex-column align-items-end justify-content-end">
                    <h6>Seleccione una fecha para obtener su resumen mensual</h6>
                    <div class="date-filter justify-content-end">
                        <input type="month" id="month-year-input" class="form-control border-right-none w-75">
                        <button id="search-button" class="form-control input-search-icon btn-add" onclick="getConsultasSegurosMesByClick()"><i class="fas fa-search"></i></button>
                    </div>
                </div>
            </div>
            <hr class="border-white">
            <!-- Empresas -->
            <div class="row">
                <h4 id="factura-doesnt-exist" class="text-center my-5" style="display: none;">No hay factura disponible actualmente para este mes</h4>
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header factura-header" style="display: none;">
                            <div class="row">
                                <div class="col-lg-6">
                                    <h4 class="card-title text-dark m-1"><b>Recibo N-<span id="factura_id"></span></b></h4>
                                    <h5>Mes: <span id="mes-factura"></span></h5>
                                    <h5>Fecha ocurrencia: <span id="fecha-ocurrencia"></span></h5>
                                    <h5>Fecha vencimiento: <span id="fecha-vencimiento"></span></h5>
                                    <a id="btn-cintillo-pdf" class="btn btn-sm btn-add" style="display: none;" href="#"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a>
                                </div>

                                <div class="col-lg-6 text-lg-end">
                                    <h4 class="card-title text-dark m-1"><b>Estatus:<span id="factura-estatus"></span></b></h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body" style="display: none;">
                            <div class="table-responsive">
                                <table id="consultaSeguro" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Cédula Paciente</th>
                                            <th>Especialidad</th>
                                            <th>Tipo de servicio</th>
                                            <th>Fecha Ocurrencia</th>
                                            <th>Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="total-amount" style="display: none;">
                        <h5 class="card total-amount-price"><b>Monto Total:</b> <span id="total-price"></span></h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-seguro" class="p-3 px-4">
                            <label for="rif">Rif</label>
                            <div class="input-group mb-3">
                                <select name="cod_rif" id="cod-rif" class="me-2">
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                </select>
                                <input type="text" name="rif" class="form-control" data-validate="true" data-type="rif" data-max-length="9">
                                <small class="form-text col-12">El rif debe contener 9 digitos</small>
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45">
                            <small class="form-text">El nombre solo puede contener letras</small>
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255">
                            <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
                            <label for="telefono">Teléfono</label>
                            <div class="input-group mb-3">
                                <select name="cod_tel" id="cod-tel" class="me-2">
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                </select>
                                <input type="text" name="telefono" class="form-control" data-validate="true" data-type="phone" data-max-length="7">
                                <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                            </div>
                            <label for="porcentaje">Porcentaje</label>
                            <div class="input-group">
                                <span class="input-group-text label-input-char" id="addon">%</span>
                                <input type="number" name="porcentaje" class="form-control" data-validate="true" data-type="number" data-max-length="3">
                                <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                            </div>
                            <label for="costo_consulta">Costo consulta</label>
                            <input type="number" step="any" name="costo_consulta" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8">
                            <small class="form-text">El precio de ser mayor o igual a 0</small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Examanes-->
        <div class="modal fade" id="modalExamenes" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalExamenesLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalExamenesLabel">Precios de los exámenes</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="precioExamanes">
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-addExamen" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddPrecioExamen">Registrar un nuevo precio de examen</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agregar Precio de los examen -->
        <div class="modal fade" id="modalAddPrecioExamen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalAddPrecioExamenLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalAddPrecioExamenLabel">Añadir precio de examen</h1>
                        <button type="button" class="btn-close" data-bs-target="#modalExamenes" data-bs-toggle="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert addAlertPrecioExamen d-none" role="alert"></div>
                        <form action="" id="info-precioExamen" class="form-reg p-3 px-4">
                            <div class="row align-items-start">
                                <div class="col-12 col-md-5">
                                    <label for="examen">Examen</label>
                                    <select id="s-examen_id" class="form-control examen" data-active="0" required>
                                    </select>
                                </div>
                                <div class="col-12 col-md-5">
                                    <label for="costos">Costo del examen</label>
                                    <input type="number" step="any" data-validate="true" data-type="price" data-max-length="6" value="0" class="form-control mb-3 costos" required>
                                    <small class="form-text">No se permiten números negativos</small>
                                </div>
                            </div>
                            <input type="hidden" name="seguro_id" id="seguro_precio_id">
                            <button type="button" id="addExamenes" class="btn btn-primary" onclick="addExamenInput()">Añadir nuevo campo</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addPrecioExamenes()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminar-->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Estás seguro que deseas eliminar este seguro?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDeleteSeguro" class="btn btn-danger">Eliminar Seguro</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDeletePrecioExamen" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeletePrecioExamenLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeletePrecioExamenLabel">Eliminar precio del examen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlertPrecioExamen" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este precio del examen?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDeleteExamenPrecio" class="btn btn-danger">Eliminar</button>
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
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/mostrarConsultaSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/eliminarExamenPrecio.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/addExamenInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/addPrecioExamenes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/consultas-seguro/deleteExamenInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/actualizarSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/eliminarSeguro.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
</body>