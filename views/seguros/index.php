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
        <div class="px-5">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Gestion de Seguros</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> seguro</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Seguros -->
            <div class="row" id="seguros-container">
            </div>

            <!-- Template -->
            <template id="card-template">
                <div data-bs-toggle="modal" data-bs-target="#modalInfo" class="card-container col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="overlay-box">
                            <h3 class="mt-3 mb-0 text-white">Nombre Seguro</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="mb-0">Rif</span> <b class="text-muted">J-0000000</b></li>
                            <li class="list-group-item"><span class="mb-0">Teléfono</span> <b class="text-muted">Seguro X</b></li>
                        </ul>
                    </div>
                </div>
            </template>
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
                                <select name="cod_rif" id="cod-rif" class="me-2" required>
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                </select>
                                <input type="number" name="rif" class="form-control" data-validate="true" data-type="rif" data-max-length="9" required>
                                <small class="form-text col-12">El rif debe contener 9 digitos</small>
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <small class="form-text">El nombre solo puede contener letras</small>
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
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
                                <input type="number" name="telefono" class="form-control" data-validate="true" data-type="phone" data-max-length="7" required>
                                <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control" required>
                                <option value="">Seleccione el tipo de seguro</option>
                                <option value="1">Acumulativo</option>
                                <option value="2">Normal</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addSeguro()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="nombreSeguro"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <p><span>Datos Seguro:</span></p>
                            <p>RIF: <span id="rifSeguro"></span></p>
                            <p>Dirección: <span id="direcSeguro"></span></p>
                            <p>Telefono: <span id="telSeguro"></span></p>
                            <p>Tipo de Seguro: <span id="tipoSeguro"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <a id="btn-eliminar" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="fas fa-trash"></i></a>
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
                                <input type="text" name="rif" class="form-control" data-validate="true" data-type="rif" data-max-length="9" required>
                                <small class="form-text col-12">El rif debe contener 9 digitos</small>
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <small class="form-text">El nombre solo puede contener letras</small>
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
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
                                <input type="text" name="telefono" class="form-control" data-validate="true" data-type="phone" data-max-length="7" required>
                                <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control mb-3" required>
                                <option value="1">Acumulativo</option>
                                <option value="2">Normal</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
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

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/registrarSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/actualizarSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/mostrarSeguros.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/eliminarSeguro.js'); ?>"></script>

</body>

</html>