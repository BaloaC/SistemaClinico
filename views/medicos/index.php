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
                <div class="col-6"><h4 class="pt-5 pb-2 text-grey">Gestion de Médicos</h4></div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Médicos</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Médicos -->
            <div class="row" id="medicos-container">

            </div>

            <!-- Template -->
            <template id="card-template">
                <div data-bs-toggle="modal" data-bs-target="#modalInfo" class="card-container col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="card overflow-hidden">
                        <div class="overlay-box">
                            <h3 class="mt-3 mb-0 text-white">Nombre médico</h3>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item"><span class="mb-0">Cédula</span> <b class="text-muted">0000000</b></li>
                            <li class="list-group-item"><span class="mb-0">Especialidad</span> <b class="text-muted">Cirujano</b></li>
                            <li class="list-group-item"><span class="mb-0">Teléfono</span> <b class="text-muted">0000-0000000</b></li>
                        </ul>
                    </div>
                </div>
            </template>
        </div>

       <!-- Modal Registro-->
       <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-medico" class="p-3 px-4">
                            <div class="row">
                                <div class="col-6">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" name="nombres" class="form-control mb-3">
                                    
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3">
                                    
                                    <label for="nombres">Teléfono</label>
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
                                </div>
                                <div class="col-6">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3">

                                    <label for="cedula">Cédula</label>
                                    <input type="text" name="cedula" class="form-control mb-3">

                                    <label for="especialidad">Especialidad</label>
                                    <select name="especialidad[]" id="s-especialidad" class="form-control mb-3" data-active="0" multiple="multiple">
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-12 col-check">
                                    <div class="py-3">Seleccione los horarios del doctor</div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="lunes" class="form-check-input">
                                        <label for="lunes" class="form-check-label">Lunes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="martes" class="form-check-input">
                                        <label for="martes" class="form-check-label">Martes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="miercoles" class="form-check-input">
                                        <label for="miercoles" class="form-check-label">Miercoles</label>
                                    </div>
                                
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="jueves" class="form-check-input">
                                        <label for="jueves" class="form-check-label">Jueves</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="viernes" class="form-check-input">
                                        <label for="viernes" class="form-check-label">Viernes</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" name="horario" value="sabado" class="form-check-input">
                                        <label for="sabado" class="form-check-label">Sábado</label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addMedico()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Info-->
        <div class="modal fade" id="modalInfo" data-bs-keyboard="true" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <!-- <h1 class="modal-title fs-5" id="modalInfoLabel">Ver médico</h1> -->
                        <h1 class="modal-title fs-5" id="nombreMedico"></h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container">
                            <p><span class="fw-bold" id="cedulaMedico"></span></p>
                            <p><span>Datos médico:</span></p>
                            <p>Nombres: <span id="nombresMedico"></span></p>
                            <p>Apellidos: <span id="apellidosMedico"></span></p>
                            <p>Teléfono: <span id="tlfMedico"></span></p>
                            <p>Dirección: <span id="direcMedico"></span></p>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                    <a id="btn-eliminar" class="float-right" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="fas fa-trash"></i></a>
                        <button type="button" id="btn-actualizar" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAct">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar-->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-medico" class="p-3 px-4">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="cedula">Cédula</label>
                                    <input type="number" name="cedula" class="form-control mb-3">
                                    
                                    <label for="especialidad">Especialidad</label>
                                    <select name="especialidad_id" id="s-especialidad-update" class="form-control mb-3" data-active="0">
                                        <option></option>
                                    </select>

                                    <label for="nombres">Nombres</label>
                                    <input type="text" name="nombres" class="form-control mb-3">
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3">

                                    <label for="nombres">Teléfono</label>
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

                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3">
                                </div>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Estás empresa que deseas eliminar este médico?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/registrarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/actualizarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/mostrarMedicos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/eliminarMedico.js'); ?>"></script>

</body>

</html>