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
                <div class="col-6"><h4 class="pt-5 pb-2 text-grey">Gestion de Empresas</h4></div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> empresa</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row" id="empresas-container">
                <!-- <a href="" data-id="21" data-bs-toggle="modal" data-bs-target="#modalInfo" class="card-container col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="text-center p-5 overlay-box">
                            <h3 class="mt-3 mb-0 text-white">NombreEmpresa</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Rif</span> <b class="text-muted"></b></li>
                            <li class="list-group-item d-flex justify-content-between"><span class="mb-0">Seguro</span> <b class="text-muted"></b></li>
                        </ul>
                    </div>
                </a> -->
                <!-- <div class="col-12 seg-container">
                    <ul class="list-seg">

                    </ul>
                </div> -->
            </div>

            <!-- Template -->
            <template id="card-template">
                <div data-bs-toggle="modal" data-bs-target="#modalInfo" class="card-container col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="overlay-box">
                            <h3 class="mt-3 mb-0 text-white">Nombre Empresa</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="mb-0">Rif</span> <b class="text-muted">J-0000000</b></li>
                            <li class="list-group-item"><span class="mb-0">Seguro</span> <b class="text-muted">Seguro X</b></li>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Empresa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-empresa" class="p-3 px-4">
                            <label for="rif">Rif</label>
                            <div class="input-group mb-3">
                                <select name="cod_rif" id="cod-rif" class="mb-4 me-2">
                                    <option value="J">J</option>
                                    <option value="E">E</option>
                                </select>
                                <input type="text" name="rif" class="form-control">
                            </div>
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control mb-3">
                            <label for="seguro">Seguro</label>
                            <select name="seguro[]" id="s-seguro" class="form-control mb-3" data-active="0" multiple="multiple">
                                <option></option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addEmpresa()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="nombreEmpresa"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <p>RIF<span id="rifEmpresa">:</span></p>
                            <p><span>Datos empresa:</span></p>
                            <p>Dirección: <span id="direcEmpresa"></span></p>
                            <p>Nombre seguro: <span id="nombreSeguro"></span></p>
                            <button id="btn-eliminar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">Eliminar empresa</button>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <a id="btn-eliminar" class="float-right" data-bs-toggle="modal" data-bs-target="#modalAct"><i class="fas fa-trash"></i></a>
                        <button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar empresa</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Empresa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-empresa" class="p-3 px-4">
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
                            <label for="seguro">Seguro</label>
                            <select name="seguro[]" id="s-seguro-update" class="form-control mb-3" data-active="0" multiple="multiple">
                                <option></option>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar empresa</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Estás empresa que deseas eliminar este empresa?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar empresa</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/empresas/registrarEmpresa.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/empresas/actualizarEmpresa.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/empresas/mostrarEmpresas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/empresas/eliminarEmpresa.js'); ?>"></script>
</body>

</html>