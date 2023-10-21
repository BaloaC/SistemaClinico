<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/seguro.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/select2/select2.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/select2/select2-bootstrap5-theme.css'); ?>">

    <title>Proyecto 4 | Welcome</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="px-5">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Gestion de Médicos</h4>
                    <p id="info-medicos"> <i class="fas fa-info-circle"></i> Para registrar médicos debe tener especialidades registradas</p>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Médicos</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Médicos -->
            <div class="d-flex justify-content-end align-items-center mb-4">
                <input type="text" id="inputSearch" class="form-control w-25 border-right-none" placeholder="Buscar...">
                <button class="form-control input-search-icon btn-add" onclick="filtrarMedicos()"><i class="fas fa-search"></i></button>
            </div>
            <div class="row" id="card-container">
            </div>
            <div class="footer-pagination">
                <button id="boton-pagina-anterior" class="btn btn-primary">Anterior</button>
                <div id="pagination-container" class="pagination"></div>
                <button id="boton-pagina-siguiente" class="btn btn-primary">Siguiente</button>
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
                                    <label for="nombre">Nombres</label>
                                    <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El nombre solo puede contener letras</small>

                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El apellido solo puede contener letras</small>

                                    <label for="nombres">Teléfono</label>
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
                                </div>
                                <div class="col-6">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
                                    <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
                                    <label for="cedula">Cédula</label>
                                    <input type="number" name="cedula" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" required>
                                    <small class="form-text">La cédula debe contener entre 6 o 8 números</small>
                                    <label for="especialidad">Especialidad</label>
                                    <select name="especialidad[]" id="s-especialidad" class="form-control mb-3" data-active="0" multiple="multiple" required>
                                        <option value=""></option>
                                    </select>
                                </div>
                                <div class="col-12 col-check mt-4">
                                    <div class="py-3">Seleccione los horarios del doctor</div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="lunes" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="lunes" class="form-check-label">Lunes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_lunes" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_lunes" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="martes" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="martes" class="form-check-label">Martes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_martes" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_martes" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="miercoles" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="miercoles" class="form-check-label">Miercoles</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_miercoles" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_miercoles" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="jueves" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="jueves" class="form-check-label">Jueves</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_jueves" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_jueves" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="viernes" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="viernes" class="form-check-label">Viernes</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_viernes" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_viernes" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-md-2">
                                            <div class="form-check">
                                                <input type="checkbox" name="horario" value="sabado" class="form-check-input" onchange="changeHorarioInput(this)">
                                                <label for="sabado" class="form-check-label">Sabado</label>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_entrada">Hora entrada</label>
                                            <input type="time" name="hora_inicio_sabado" class="form-control mb-3" disabled>
                                        </div>
                                        <div class="col-md-5">
                                            <label for="hora_salida">Hora salida</label>
                                            <input type="time" name="hora_salida_sabado" class="form-control mb-3" disabled>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onClick="addMedico()">Registrar</button>
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
                            <p>Especialidad: <span id="especialidadMedico"></span></p>
                            <p>Horario: <span id="horarioMessage">Este médico no posee horarios</span></p>
                            <table id="horarios-table" class="table table-borderless">
                                <thead>
                                    <tr>
                                        <th>Día</th>
                                        <th>Hora Entrada</th>
                                        <th>Hora Salida</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <a type="button" id="btn-eliminar" class="float-right" data-bs-toggle="modal" data-bs-target="#modalDelete"><i class="fas fa-trash"></i></a>
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
                                    <label for="nombre">Nombres</label>
                                    <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El nombre solo puede contener letras</small>
                                    <label for="cedula">Cédula</label>
                                    <input type="number" name="cedula" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" required>
                                    <small class="form-text">La cédula debe contener entre 6 o 8 números</small>
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
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El apellido solo puede contener letras </small>
                                    <label for="especialidad">Especialidad</label>
                                    <select name="especialidad[]" id="s-especialidad-update" class="form-control mb-3" data-active="0" multiple="multiple" required>
                                        <option value=""></option>
                                    </select>
                                    <label for="apellidos">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3" data-max-length="255" required>
                                </div>
                                <div class="act-horarios">
                                </div>
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
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar médico</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Estás seguro que deseas eliminar este médico?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Confirmar Eliminar-->
    <div class="modal fade" id="modalDeleteRelacion" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabelRelacion" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDeleteLabelRelacion">Eliminar relación con seguro</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="delAlertRelacion" class="alert d-none" role="alert"></div>
                    ¿Estás seguro que deseas eliminar esta relación?
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-confirmDeleteRelacion" class="btn btn-danger">Eliminar relación</button>
                </div>
            </div>
        </div>
    </div>

    <template id="horarioInitialInputs">
        <div class="col-12 col-check mt-4">
            <div class="py-3">Seleccione los horarios del doctor</div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="lunes" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="lunes" class="form-check-label">Lunes</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_lunes" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_lunes" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="martes" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="martes" class="form-check-label">Martes</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_martes" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_martes" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="miercoles" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="miercoles" class="form-check-label">Miercoles</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_miercoles" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_miercoles" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="jueves" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="jueves" class="form-check-label">Jueves</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_jueves" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_jueves" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="viernes" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="viernes" class="form-check-label">Viernes</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_viernes" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_viernes" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="form-check">
                        <input type="checkbox" name="horario" value="sabado" class="form-check-input horarioInput" onchange="changeHorarioInput(this)">
                        <label for="sabado" class="form-check-label">Sabado</label>
                    </div>
                </div>
                <div class="col-md-5">
                    <label for="hora_entrada">Hora entrada</label>
                    <input type="time" name="hora_inicio_sabado" class="form-control mb-3 horarioEntryInput" disabled>
                </div>
                <div class="col-md-5">
                    <label for="hora_salida">Hora salida</label>
                    <input type="time" name="hora_salida_sabado" class="form-control mb-3 horarioExitInput" disabled>
                </div>
            </div>
        </div>
    </template>

    <!-- Modal Alerta-->
    <div class="modal fade" id="modalAlert" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalDeleteLabel">Alerta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="delAlertSeguro" class="alert alert-warning" role="alert">No es posible dejar una empresa sin seguro asociado</div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btn-confirmDeleteSeguro" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/mostrarMedicos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/registrarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/medicosPagination.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/actualizarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/eliminarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/filtrarMedicos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/eliminarHorarioMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/eliminarEspecialidadMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/changeHorarioInput.js'); ?>"></script>
</body>

</html>