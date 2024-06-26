<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <!-- <link rel="stylesheet" href="<?php echo Url::to('assets/css/login.css'); ?>"> -->
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/fontawesome/css/all.min.css'); ?>">
    <title>Proyecto 4 | Usuarios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Usuarios</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> Usuario</button>
                </div>
                <hr class="border-white">
                <div class="help-message d-flex align-items-center mb-3 w-50">
                    <i class="fas fa-info-circle text-secondary me-3"></i> 
                    <p class="text-secondary m-0">Para actualizar el estatus del usuario, debe hacer click directamente en el estatus <span class='badge light badge-warning'>Inactivo</span> para activarlo, caso contrario si se presiona con el estatus de <span class='badge light badge-success'>Activo</span> inactivará el usuario</p>
                </div>
            </div>
            <!-- Usuarios -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="usuariosTable" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Rol</th>
                                            <th>Fecha de creación</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
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

        <!-- Modal Registro-->
        <div class="modal fade" id="modalReg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div id="alert" class="alert d-none" role="alert"></div>
                        <form id="info-usuario" class="register-form p-3 px-4">
                            <div id="form-info" class="form-info">
                                <label for="nombre">Nombres del usuario</label>
                                <input class="form-control" type="text" name="nombres" data-validate="true" data-type="name" data-max-length="16" required>
                                <small class="form-text">El nombre solo puede contener letras</small>
                                <label for="nombre">Apellidos del usuario</label>
                                <input class="form-control" type="text" name="apellidos" data-validate="true" data-type="name" data-max-length="16" required>
                                <small class="form-text">El apellido solo puede contener letras</small>
                                <label for="nombre">Usuario</label>
                                <input class="form-control" type="text" name="nombre" data-validate="true" data-type="username" data-max-length="16" required>
                                <small class="form-text">Solo se permiten los siguientes caracteres: "_" y "-"</small>
                                <label for="clave">Contraseña</label>
                                <!-- <div class="input-group mb-3 pass-container"> -->
                                <input class="form-control mb-3" id="password1" type="password" name="clave" data-validate="true" data-type="password" data-max-length="20" required>
                                <small class="form-text">La contraseña debe contener al menos 8 caracteres y un número <br> y los caracteres permitdos son: "@" y "-"</small>
                                <!-- <i class="fas fa-eye" id="togglePassword1" onclick="showPassword(this,'password1')"></i> -->
                                <!-- </div> -->
                                <label for="confirmarClave">Confirmar contraseña</label>
                                <!-- <div class="input-group mb-3 pass-container"> -->
                                <input class="form-control mb-3" id="password2" type="password" name="confirmarClave" data-max-length="20" required>
                                <small class="form-text">Las contraseñas no coinciden</small>
                                <!-- <i class="fas fa-eye" id="togglePassword2" onclick="showPassword(this,'password2')"></i> -->
                                <!-- </div> -->
                                <label for="pin">Pin</label>
                                <input class="form-control mb-3" type="password" name="pin" data-validate="true" data-type="pin" required>
                                <small class="form-text">El pin debe contener mínimo 6 números</small>
                                <label for="rol">Nivel de usuario</label>
                                <select class="form-select mb-3" name="rol" required>
                                    <option value="" disabled>Seleccione un nivel de usuario...</option>
                                    <!-- <option value="1">Admin</option> -->
                                    <option value="2">Gerente</option>
                                    <option value="3">Contador</option>
                                    <option value="4">Analista</option>
                                    <option value="5">Facultativo de salud</option>
                                </select>
                                <!-- <div class="text-center"><input type="button" id="siguiente" class="btn btn-primary my-5" value="Siguiente"></div> -->
                            </div>

                            <div id="form-preguntas" class="form-preguntas">
                                <label>Pregunta de Seguridad 1</label>
                                <select class="form-select mb-3 preguntasSeguridad" id="pregunta1" name="pregunta1" required>
                                    <option value="">Seleccione una pregunta de seguridad</option>
                                    <option value="1">Cuál es tu color favorito</option>
                                    <option value="2">Nombre de tu mascota de la infancia</option>
                                    <option value="3">Segundo apellido de tu mamá</option>
                                    <option value="4">Apodo de la infancia</option>
                                    <option value="5">Cuál es tu pasatiempo favorito</option>
                                    <option value="6">Programa o serie de televisión favorito</option>
                                    <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                    <option value="8">Algo que odies</option>
                                </select>
                                <input class="form-control mt-3 mb-3" type="text" name="respuesta1" placeholder="Respuesta a la pregunta de Seguridad" required>

                                <label>Pregunta de Seguridad 2</label>
                                <select class="form-select mb-3 preguntasSeguridad" id="pregunta2" name="pregunta2" required>
                                    <option value="">Seleccione una pregunta de seguridad</option>
                                    <option value="1">Cuál es tu color favorito</option>
                                    <option value="2">Nombre de tu mascota de la infancia</option>
                                    <option value="3">Segundo apellido de tu mamá</option>
                                    <option value="4">Apodo de la infancia</option>
                                    <option value="5">Cuál es tu pasatiempo favorito</option>
                                    <option value="6">Programa o serie de televisión favorito</option>
                                    <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                    <option value="8">Algo que odies</option>
                                </select>
                                <input class="form-control mt-3 mb-3" type="text" name="respuesta2" placeholder="Respuesta a la pregunta de Seguridad" required>

                                <label>Pregunta de Seguridad 3</label>
                                <select class="form-select mb-3 preguntasSeguridad" id="pregunta3" name="pregunta3" required>
                                    <option value="">Seleccione una pregunta de seguridad</option>
                                    <option value="1">Cuál es tu color favorito</option>
                                    <option value="2">Nombre de tu mascota de la infancia</option>
                                    <option value="3">Segundo apellido de tu mamá</option>
                                    <option value="4">Apodo de la infancia</option>
                                    <option value="5">Cuál es tu pasatiempo favorito</option>
                                    <option value="6">Programa o serie de televisión favorito</option>
                                    <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                    <option value="8">Algo que odies</option>
                                </select>
                                <input class="form-control mt-3 mb-3" type="text" name="respuesta3" placeholder="Respuesta a la pregunta de Seguridad" required>

                                <!-- <div class="text-center"><input type="submit" class="btn btn-primary my-3" value="Registrar Usuario"></div> -->
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <i class="fas fa-eraser cursor-pointer" onclick="cleanForm('info-usuario')"></i>
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addUsuario()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form id="act-usuario" class="p-3 px-4">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="nameExam" data-max-length="45" required>
                            <small class="form-text">El nombre solo debe contener al menos 3 letras sin caracteres especiales</small>
                            <label for="clave">Nueva clave</label>
                            <input type="text" name="clave" class="form-control mb-3" data-validate="true" data-type="password" data-max-length="45">
                            <small class="form-text">La contraseña debe contener al menos 8 caracteres y un número <br> y los caracteres permitdos son: "@" y "-"</small>
                            <label for="tipo_medicamento">Rol</label>
                            <select class="form-select" name="rol" required>
                                <!-- <option value="1">Admin</option> -->
                                <option value="2">Gerente</option>
                                <option value="3">Contador</option>
                                <option value="4">Analista</option>
                                <option value="5">Facultativo de salud</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer d-flex justify-content-between">
                        <i class="fas fa-eraser cursor-pointer" onclick="cleanForm('act-usuario')"></i>
                        <button type="button" id="btn-actualizarInfo" class="btn btn-primary" onclick="confirmUpdate()">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalActEstatus" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActEstatus" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar estatus del usuario</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actEstatusAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea actualizar el estatus de este usuario?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-actualizarInfo1" class="btn btn-primary">Actualizar</button>
                    </div>
                </div>
            </div>
        </div>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/usuarios/mostrarUsuarios.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/usuarios/registrarUsuarioModule.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/usuarios/actualizarUsuario.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/usuarios/eliminarUsuario.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/usuarios/actualizarEstatusUsuario.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/global/filterOptionsVanillaSelect.js'); ?>"></script>
</body>

</html>