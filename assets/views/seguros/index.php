<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/seguro.css'); ?>">

    <title>Proyecto 4 | Welcome</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h1 class="p-4 text-light">Gestion de Seguros</h1>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#modalReg">Añadir seguro</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Seguros -->
            <div class="row">
                <div class="col-12 seg-container">
                    <ul class="list-seg">

                    </ul>
                </div>
            </div>
        </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-seguro" class="p-3 px-4">
                            <label for="rif">Rif</label>
                            <div class="input-group mb-3">
                                <select name="cod_rif" id="cod-rif" class="me-2">
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                </select>
                                <input type="text" name="rif" class="form-control">
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group mb-3">
                                <select name="cod_tel" id="cod-tel" class="me-2">
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                </select>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                            <label for="porcentaje">Porcentaje</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">%</span>
                                <input type="text" name="porcentaje" class="form-control" aria-label="porcentaje" aria-describedby="porcentaje">
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control">
                                <option value="">Seleccione el tipo de seguro</option>
                                <option value="1">Acumulativo</option>
                                <option value="2">Normal</option>
                            </select>
                        </form>
                        <!-- <form action="" id="info-seguro">
                            <label for="rif">Rif</label>
                            <input type="text" name="rif" class="form-control">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group mb-3">
                                <select name="cod_tel" id="cod-tel">
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                </select>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                            <label for="porcentaje">Porcentaje</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="text" name="porcentaje" class="form-control" aria-label="porcentaje" aria-describedby="porcentaje">
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control">
                                <option value="">Seleccione el tipo de seguro</option>
                                <option value="1">Acumulativo</option>
                                <option value="2">Normal</option>
                            </select>
                        </form> -->
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalInfoLabel">Ver Seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <div class="row mb-5">
                                <div class="col-12 d-flex justify-content-between">
                                    <h2 class="fw-bold" id="nombreSeguro"></h2>
                                    <h2 class="fw-bold" id="rifSeguro"></h2>
                                </div>
                            </div>
                            <p><span>Datos Seguro:</span></p>
                            <p>Dirección: <span id="direcSeguro"></span></p>
                            <p>Telefono: <span id="telSeguro"></span></p>
                            <p>Porcentaje: <span id="porcSeguro"></span>%</p>
                            <p>Tipo de Seguro: <span id="tipoSeguro"></span></p>
                            <button id="btn-eliminar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">Eliminar Seguro</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar Seguro</button>
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
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-seguro" class="p-3 px-4">
                            <label for="rif">Rif</label>
                            <div class="input-group mb-3">
                                <select name="cod_rif" id="cod-rif" class="me-2">
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                </select>
                                <input type="text" name="rif" class="form-control">
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3">
                            <label for="telefono">Teléfono</label>
                            <div class="input-group mb-3">
                                <select name="cod_tel" id="cod-tel" class="me-2">
                                    <option value="0412">0412</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                </select>
                                <input type="text" name="telefono" class="form-control">
                            </div>
                            <label for="porcentaje">Porcentaje</label>
                            <div class="input-group mb-3">
                                <span class="input-group-text">%</span>
                                <input type="text" name="porcentaje" class="form-control" aria-label="porcentaje" aria-describedby="porcentaje">
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control mb-3">
                                <option value="1">Acumulativo</option>
                                <option value="2">Normal</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary">Actualizar</button>
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
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar Seguro</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="<?php echo Url::to('assets/libs/jquery/jquery-3.6.0.min.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/registrarSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/actualizarSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/mostrarSeguros.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/eliminarSeguro.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/bootstrap/popper.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/bootstrap/bootstrap.min.js'); ?>"></script>
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
</body>

</html>