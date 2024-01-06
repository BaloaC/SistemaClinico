<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/seguro.css'); ?>">

    <title>Proyecto 4 | Examenes</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Factura Seguro</h4>
                </div>
                <!-- <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> exámen</button>
                </div> -->
                <hr class="border-white">
            </div>
            <!-- Exámenes -->
            <!-- <div class="d-flex justify-content-end align-items-center mb-4">
                <input type="text" id="inputSearch" class="form-control w-25 border-right-none" placeholder="Buscar...">
                <button class="form-control input-search-icon btn-add" onclick="filtrarExamenes()"><i class="fas fa-search"></i></button>
            </div> -->
            <div class="row" id="card-container">
            </div>
            <div class="d-flex justify-content-evenly">
                <button id="boton-pagina-anterior" class="btn btn-primary">Anterior</button>
                <div id="pagination-container" class="pagination"></div>
                <button id="boton-pagina-siguiente" class="btn btn-primary">Siguiente</button>
            </div>

        </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Exámenes</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-examen" class="form-reg p-3 px-4">
                            <label for="nombre">Nombre exámen</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <small class="form-text">El nombre solo puede contener letras</small>
                            <label for="tipo">Tipo</label>
                            <input type="text" name="tipo" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <small class="form-text">El tipo solo puede contener letras</small>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addExamen()">Registrar</button>
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
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-examen" class="p-3 px-4">
                            <label for="nombre">Nombre exámen</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <label for="tipo">Tipo</label>
                            <input type="text" name="tipo" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar exámen</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Estás seguro que deseas eliminar este exámen?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="dropdown-menu show" arial-labelledby="navbarDropdown" id="2023" style="position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(62.5px, 392.5px);" data-popper-placement="bottom-start">
            <div class="row">
                <div class="col">
                    <a class="dropdown-item" id="1">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="dropdown-item" id="2">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="dropdown-item" id="3">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <a class="dropdown-item" id="4">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="dropdown-item" id="5">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
                <div class="col">
                    <a class="dropdown-item" id="6">
                        <div class="seguro">
                            <img src="https://cdn-icons-png.flaticon.com/64/4434/4434431.png">
                            <p>Seguros Miranda</p>
                        </div>
                    </a>
                </div>
            </div>
        </div> -->

    </main>

    <script type="module" src="<?php echo Url::to('assets/js/facturas-seguros/segurosAgePagination.js'); ?>"></script>
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
</body>

</html>