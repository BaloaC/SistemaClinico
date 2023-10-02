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
                    <h4 class="pt-5 pb-2 text-grey">Gestion de Exámenes</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> exámen</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Exámenes -->
            <div class="d-flex justify-content-end align-items-center mb-4">
                <input type="text" id="inputSearch" class="form-control w-25 border-right-none" placeholder="Buscar...">
                <button class="form-control input-search-icon btn-add" onclick="filtrarExamenes()"><i class="fas fa-search"></i></button>
            </div>
            <div class="row" id="card-container">
            </div>
            <div class="d-flex justify-content-evenly">
                <button id="boton-pagina-anterior" class="btn btn-primary">Anterior</button>
                <div id="pagination-container" class="pagination"></div>
                <button id="boton-pagina-siguiente" class="btn btn-primary">Siguiente</button>
            </div>

            <!-- Template -->
            <template id="card-template">
                <div class="card-container col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="overlay-box">
                            <h3 class="mt-3 mb-0 text-white">Nombre Exámenes</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="mb-0">Tipo</span><b class="text-muted">J-0000000</b></li>
                            <li class="list-group-item"><span class="mb-0"><button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar</button></span><button id="btn-eliminar" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalDelete">Eliminar</button></li>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Exámenes</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-examen" class="p-3 px-4">
                            <label for="nombre">Nombre exámen</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <small class="form-text">El nombre solo puede contener letras</small>
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="s-tipo" class="form-control mb-3">
                                <option value="" disabled selected>Seleccione el tipo de exámen</option>
                                <option value="1">Ecografía</option>
                                <option value="2">Laboratorio</option>
                                <option value="3">Ultrasonido</option>
                            </select>
                            <label for="nombre" id="precioExamenLabel">Precio exámen</label>
                            <input type="number" step="any" name="precio_examen" id="precioExamen" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <label for="tipo">¿Este exámen lo realizan aquí?</label>
                            <div class="input-radios-container">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho_aqui" id="tipoPacienteTitular" value="1" required>
                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho_aqui" id="tipoPacienteBeneficiado" value="0" required>
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                            </div>
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
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-examen" class="p-3 px-4">
                            <label for="nombre">Nombre exámen</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                            <label for="tipo">Tipo</label>
                            <select name="tipo" id="s-tipo" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de exámen</option>
                                <option value="1">Ecografía</option>
                                <option value="2">Laboratorio</option>
                                <option value="3">Ultrasonido</option>
                            </select>
                            <label for="nombre" id="precioExamenLabelAct">Precio exámen</label>
                            <input type="number" step="any" name="precio_examen" id="precioExamenAct" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="8" required>
                            <label for="tipo">¿Este exámen lo realizan aquí?</label>
                            <div class="input-radios-container">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho_aqui" id="hecho_aqui_si" value="1" required>
                                    <label class="form-check-label" for="inlineRadio1">Sí</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hecho_aqui" id="hecho_aqui_no" value="0" required>
                                    <label class="form-check-label" for="inlineRadio2">No</label>
                                </div>
                                <input type="hidden" name="hecho_aqui_value" id="hecho_aqui_value">
                            </div>
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
    </main>

    <script type="module" src="<?php echo Url::to('assets/js/examenes/mostrarExamenes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/examenesPagination.js'); ?>"></script>
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/registrarExamen.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/actualizarExamen.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/eliminarExamen.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/filtrarExamenes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/examenes/examenHechoAqui.js'); ?>"></script>
</body>

</html>