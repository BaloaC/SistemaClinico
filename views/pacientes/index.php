<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Consultar Usuarios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Pacientes</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> paciente</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="col-12 seg-container">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title text-dark m-1">Pacientes registrados</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="pacientes" class="table table-compact">
                                    <thead>
                                        <tr>
                                            <th>Detalles</th>
                                            <th>Cédula</th>
                                            <th>Nombres</th>
                                            <th>Apellidos</th>
                                            <th>Edad</th>
                                            <th>Tipo paciente</th>
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
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalRegBody">
                        <div class="alert d-none" role="alert"></div>
                        <form action="" id="info-paciente" class="p-3 px-4">
                            <div class="row">
                                <!-- Labels -->
                                <div class="col-12 col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El nombre solo puede contener letras</small>

                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El apellido solo puede contener letras</small>

                                    <label for="telefono">Teléfono</label>
                                    <div class="input-group mb-3">
                                        <select name="cod_tel" id="cod-tel" class="me-2">
                                            <option value="0412">0412</option>
                                            <option value="0414">0414</option>
                                            <option value="0424">0424</option>
                                            <option value="0416">0416</option>
                                            <option value="0426">0426</option>
                                            <option value="0243">0243</option>
                                        </select>
                                        <input type="text" name="telefono" id="telefono" class="form-control" data-validate="true" data-type="phone" data-max-length="7" required>
                                        <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
                                    <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>

                                    <label for="cedula">Cédula</label>
                                    <input type="number" name="cedula" id="cedula" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" required>
                                    <small class="form-text">La cédula debe contener entre 6 o 8 números</small>

                                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control mb-3" onchange="pacienteMenorDeEdad(this)" required>
                                </div>
                                <div class="col-12 col-md-6 mt-4">
                                    <label for="tipo_paciente">Tipo de paciente</label>
                                    <select name="tipo_paciente" id="s-tipo_paciente" class="form-control mb-3" required>
                                        <option value disabled selected>Seleccione el tipo de paciente...</option>
                                        <option value="1">Natural</option>
                                        <option value="2">Representante</option>
                                        <option value="3">Asegurado</option>
                                        <option value="4">Beneficiado</option>
                                    </select>
                                </div>
                                <div class="col-12 col-md-6 mt-4">
                                    <label for="pacienteMenorLabel" class="opacity-0 d-none">¿El paciente posee cédula de identidad?</label>
                                    <div class="pacienteMenorContainer input-radios-container opacity-0 d-none">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_si" value="1" onchange="pacientePoseeCedula(this,'cedula')">
                                            <label class="form-check-label" for="">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_no" value="0" onchange="pacientePoseeCedula(this,'cedula')" checked>
                                            <label class="form-check-label" for="">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-menus">
                                    <div class="submenu-beneficiado row opacity-0 d-none">
                                        <h5 class="mt-4 mb-3">Información titulares</h5>
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-5">
                                                <label for="titular">Titular</label>
                                                <select name="titular_id" id="s-titular_id" class="form-control mb-3 titular" data-active="0" disabled required>
                                                    <option value="" selected>Seleccione un titular</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label for="tipo_relacion">Tipo de relación</label>
                                                <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3 relacion" required>
                                                    <option value="" disabled selected>Seleccione el tipo de relación</option>
                                                    <option value="1">Seguro</option>
                                                    <option value="2">Natural</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label for="tipo_familiar">Tipo de familiar</label>
                                                <select name="tipo_familiar" id="tipo_familiar" class="form-control mb-3 tipo_familiar" required>
                                                    <option value="" disabled selected>Seleccione el tipo de familiar</option>
                                                    <option value="1">Padre/Madre</option>
                                                    <option value="2">Representante</option>
                                                    <option value="3">Primo/a</option>
                                                    <option value="4">Hermano/a</option>
                                                    <option value="5">Esposo/a</option>
                                                    <option value="6">Tío/a</option>
                                                    <option value="7">Sobrino/a</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-1 d-none">
                                                <button type="button" class="btn" onclick="deleteTitularInput(this)"><i class="fas fa-times m-0"></i></button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-primary w-25" id="addTitular" onclick="addTitularInput()">Agregar titular</button>
                                    </div>
                                    <div class="submenu-seguro row opacity-0 d-none">
                                        <h5 class="mt-4 mb-3">Información del seguro</h5>
                                        <div class="col-12 col-md-6">
                                            <label for="seguro">Seguro</label>
                                            <select name="seguro[]" id="s-seguro" class="form-control mb-3" data-active="0" disabled multiple="multiple" required>
                                                <option value="">Seleccione un seguro</option>
                                            </select>

                                            <label for="empresa">Empresa</label>
                                            <select name="empresa_id" id="s-empresa" class="form-control mb-3" data-active="0" disabled required>
                                                <option value="">Consultar empresas</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="fecha_contra">Fecha de Contratación</label>
                                            <input type="date" name="fecha_contra" class="form-control mb-3" disabled required>

                                            <label for="cobertura_general">Cobertura General</label>
                                            <input type="number" step="any" name="cobertura_general" class="form-control mb-3" disabled required>

                                            <label for="saldo_disponible">Saldo disponible</label>
                                            <input type="number" step="any" name="saldo_disponible" class="form-control mb-3" disabled required>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addPaciente()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal info -->
        <div class="modal fade" id="modalInfo" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalInfoLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalInfoLabel">Información paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-12 col-md-4 paciente-info">
                                    <img src="<?php echo Url::to('assets/img/ficha.png'); ?>" alt="">
                                    <p><strong>Nombres y Apellidos:</strong> <span id="nombre_paciente"></span></p>
                                    <!-- <p><strong>Género:</strong> <span id="genero">Static</span></p> -->
                                    <p><strong>Fecha de nacimiento:</strong> <span id="fecha"></span></p>
                                    <p><strong>Edad:</strong> <span id="edad"></span></p>
                                    <!-- <p><strong>Alergías:</strong> <span id="alergias">Static</span></p> -->
                                    <p><strong>Observación:</strong> <span id="observacion">Sin observaciones</span></p>
                                    <a class="btn btn-sm btn-add my-3" id="consulta-pdf" href="#"><i class="fa-sm fas fa-file-export"></i> Imprimir documento PDF</a>
                                    <button class="btn btn-white">Agregar consulta</button>
                                </div>
                                <div class="col-12 col-md-8 paciente-consulta">
                                    <ul class="pt-3">

                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Actualizar -->
        <div class="modal fade" id="modalAct" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalActLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalActLabel">Actualizar Paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="modalActBody">
                        <div id="actAlert" class="alert d-none" role="alert"></div>
                        <form action="" id="act-paciente" class="p-3 px-4">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <label for="nombres">Nombres</label>
                                    <input type="text" name="nombre" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" require>
                                    <small class="form-text">El nombre solo puede contener letras</small>
                                    <label for="apellidos">Apellidos</label>
                                    <input type="text" name="apellidos" class="form-control mb-3" data-validate="true" data-type="name" data-max-length="45" required>
                                    <small class="form-text">El apellido solo puede contener letras</small>
                                    <label for="cedula">Cédula</label>
                                    <input type="number" name="cedula" id="cedula-act" class="form-control" data-validate="true" data-type="dni" data-max-length="8" required>
                                    <small class="form-text">La cédula debe contener entre 6 o 8 números</small>
                                    <label for="pacienteMenorLabelAct" class="mt-3 opacity-0 d-none">¿El paciente posee cédula de identidad?</label>
                                    <div class="pacienteMenorContainerAct input-radios-container opacity-0 d-none">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_si_act" value="1" onchange="pacientePoseeCedula(this,'cedula-act')">
                                            <label class="form-check-label" for="">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_no_act" value="0" onchange="pacientePoseeCedula(this,'cedula-act')" checked>
                                            <label class="form-check-label" for="">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control mb-3" data-validate="true" data-type="date" onchange="pacienteMenorDeEdadUpdate(this)" required>

                                    <label for="telefono">Teléfono</label>
                                    <div class="input-group">
                                        <select name="cod_tel" id="cod-tel-act" class="me-2">
                                            <option value="0412">0412</option>
                                            <option value="0414">0414</option>
                                            <option value="0424">0424</option>
                                            <option value="0416">0416</option>
                                            <option value="0426">0426</option>
                                            <option value="0243">0243</option>
                                        </select>
                                        <input type="text" name="telefono" id="telefono-act" class="form-control" data-validate="true" data-type="phone" data-max-length="7" required>
                                        <small class="form-text col-12">Solo se permiten números y 9 digitos</small>
                                    </div>

                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
                                    <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>

                                    <label for="tipo_paciente" class="mt-3">Tipo de paciente</label>
                                    <select name="tipo_paciente" id="tipo_paciente" class="form-control mb-3" onchange="actualizarTipoPaciente(this.value)" requried>
                                        <option value="1">Natural</option>
                                        <option value="2">Representante</option>
                                        <option value="3">Asegurado</option>
                                        <option value="4">Beneficiado</option>
                                    </select>

                                </div>

                                <div class="submenu-beneficiado row" style="display: none;">
                                    <h5 class="mt-4 mb-3" id="submenu-beneficiado-title">Información titulares</h5>
                                    <div class="buttons-submenus-add">
                                        <button type="button" id="btn-add-titular" class="btn btn-primary w-25 gap-3" value="show" onclick="toggleAddTitular(this.value)">Añadir titular</button>
                                        <button type="button" id="btn-hide-titular" class="btn btn-danger w-25" value="hide" onclick="toggleAddTitular(this.value)" style="display:none;">Ocultar información</button>
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="col-12 col-md-5 new-titular-input" style="display: none;">
                                            <label for="titular">Titular</label>
                                            <select name="titular_id" id="s-titular_id-act" class="form-control mb-3" data-active="0" disabled required>
                                                <option value="" selected>Seleccione un titular</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5 new-titular-input" style="display: none;">
                                            <label for="tipo_relacion">Tipo de relación</label>
                                            <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3" disabled required>
                                                <option value="" disabled selected>Seleccione el tipo de relación</option>
                                                <option value="1">Seguro</option>
                                                <option value="2">Natural</option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5 new-titular-input" style="display: none;">
                                            <label for="tipo_familiar">Tipo de familiar</label>
                                            <select name="tipo_familiar" id="tipo_familiar" class="form-control mb-3" disabled required>
                                                <option value="" disabled selected>Seleccione el tipo de familiar</option>
                                                <option value="1">Padre/Madre</option>
                                                <option value="2">Representante</option>
                                                <option value="3">Primo/a</option>
                                                <option value="4">Hermano/a</option>
                                                <option value="5">Esposo/a</option>
                                                <option value="6">Tío/a</option>
                                                <option value="7">Sobrino/a</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="submenu-seguro row" style="display: none;">
                                    <h5 class="mt-4 mb-3" id="submenu-seguro-title">Información del seguro</h5>
                                    <div class="buttons-submenus-add">
                                        <button type="button" id="btn-add-seguro" class="btn btn-primary w-25 gap-3" value="show" onclick="toggleAddSeguro(this.value)">Añadir seguro</button>
                                        <button type="button" id="btn-hide-seguro" class="btn btn-danger w-25" value="hide" onclick="toggleAddSeguro(this.value)" style="display:none;">Ocultar información</button>
                                    </div>
                                    <h5 id="new-seguro-title" style="display: none;">Añadir nuevo seguro</h5>
                                    <div class="col-12 col-md-6 new-seguro-input" style="display: none;">
                                        <label for="seguro">Seguro</label>
                                        <select name="seguro[]" id="s-seguro-act" class="form-control mb-3" data-active="0" disabled multiple="multiple" required>
                                            <option value="">Seleccione un seguro</option>
                                        </select>

                                        <label for="empresa">Empresa</label>
                                        <select name="empresa_id" id="s-empresa-act" class="form-control mb-3" data-active="0" disabled required>
                                            <option value="">Consultar empresas</option>
                                        </select>

                                        <label for="tipo_seguro">Tipo de seguro</label>
                                        <select name="tipo_seguro" id="s-tipo_seguro" value="1" class="form-control mb-3" disabled required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6 new-seguro-input" style="display: none;">
                                        <label for="fecha_contra">Fecha de Contratación</label>
                                        <input type="date" name="fecha_contra" class="form-control mb-3" disabled required>

                                        <label for="cobertura_general">Cobertura General</label>
                                        <input type="number" step="any" name="cobertura_general" class="form-control mb-3" disabled required>

                                        <label for="saldo_disponible">Saldo disponible</label>
                                        <input type="number" step="any" name="saldo_disponible" class="form-control mb-3" disabled required>
                                    </div>
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

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este paciente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDeletePacienteSeguro" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar seguro del paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlertPacienteSeguro" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este seguro del paciente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDeletePacienteSeguro" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDeletePacienteTitular" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar titular del paciente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlertPacienteTitular" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este titular del paciente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDeletePacienteTitular" class="btn btn-danger">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/mostrarPacientes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/tipoPaciente.js'); ?>"></script>
    <!-- <script type="module" src="<?php echo Url::to('assets/js/pacientes/infoPaciente.js'); ?>"></script> -->
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/registrarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/actualizarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/eliminarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/addTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/deleteTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/pacienteMenorDeEdad.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/pacienteMenorDeEdadUpdate.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/pacientePoseeCedula.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/actualizarTipoPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/deletePacienteSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/deletePacienteTitular.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/toggleAddSeguro.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/toggleAddTitular.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
</body>