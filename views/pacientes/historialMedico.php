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
                    <h4 class="pt-5 pb-2 text-grey">Historial Médico</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-sm btn-add" id="btn-add" data-bs-toggle="modal" data-bs-target="#modalReg"><i class="fa-sm fas fa-plus"></i> antecedentes</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 paciente-info">
                            <a class="btn btn-sm btn-add align-self-end my-3" id="consulta-pdf" href="#"><i class="fa-sm fas fa-file-export"></i></a>
                            <img src="<?php echo Url::to('assets/img/ficha.png'); ?>" alt="">
                            <p><b>Nombres y Apellidos:</b> <span id="nombre_paciente"></span></p>
                            <p><b>Fecha de nacimiento:</b> <span id="fecha"></span></p>
                            <p><b>Edad:</b> <span id="edad"></span></p>
                            <p><b>Antecedentes:</b></p>
                            <div class="antecedente-container">

                            </div>
                        </div>
                        <div class="col-12 col-md-8 paciente-consulta">
                            <button class="btn btn-sm btn-add align-self-end mb-2"><i class="fa-sm fas fa-plus"></i> Agregar consulta</button>
                            <div class="accordion consulta-accordion" id="consultaAccordion">

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
                    <div class="modal-body">
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
                                    <select name="tipo_paciente" id="s-tipo_paciente" class="form-control mb-3" requried>
                                        <option disabled selected>Seleccione el tipo de paciente...</option>
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
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_si" value="1" onchange="pacientePoseeCedula(this)">
                                            <label class="form-check-label" for="">Sí</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="cedula_beneficiario" id="cedula_menor_no" value="0" onchange="pacientePoseeCedula(this)" checked>
                                            <label class="form-check-label" for="">No</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="sub-menus">
                                    <div class="submenu-beneficiado row opacity-0 d-none">
                                        <h5 class="mt-4 mb-3">Información titulares</h5>
                                        <div class="row align-items-center">
                                            <div class="col-12 col-md-1">
                                                <button type="button" class="btn" disabled><i class="fas fa-times m-0"></i></button>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label for="titular">Titular</label>
                                                <select name="titular_id" id="s-titular_id" class="form-control mb-3 titular" data-active="0" disabled required>
                                                    <option value="">Seleccione un titular</option>
                                                </select>
                                            </div>
                                            <div class="col-12 col-md-5">
                                                <label for="tipo_relacion">Tipo de relación</label>
                                                <select name="tipo_relacion" id="tipo_relacion" class="form-control mb-3 relacion" disabled required>
                                                    <option value="" disabled>Seleccione el tipo de relación</option>
                                                    <option value="1">Seguro</option>
                                                    <option value="2">Padre/Madre</option>
                                                    <option value="3">Representante</option>
                                                </select>
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

                                            <label for="tipo_seguro">Tipo de seguro</label>
                                            <select name="tipo_seguro" id="s-tipo_seguro" class="form-control mb-3" disabled required>
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label for="fecha_contra">Fecha de Contratación</label>
                                            <input type="date" name="fecha_contra" class="form-control mb-3" disabled required>

                                            <label for="cobertura_general">Cobertura General</label>
                                            <input type="number" name="cobertura_general" class="form-control mb-3" disabled required>

                                            <label for="saldo_disponible">Saldo disponible</label>
                                            <input type="number" name="saldo_disponible" class="form-control mb-3" disabled required>
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
                    <div class="modal-body">
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
                                    <input type="number" name="cedula" class="form-control mb-3" data-validate="true" data-type="dni" data-max-length="8" required>
                                    <small class="form-text">La cédula debe contener entre 6 o 8 números</small>
                                </div>
                                <div class="col-12 col-md-6">
                                    <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                    <input type="date" name="fecha_nacimiento" class="form-control mb-3" required>

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

                                    <label for="direccion">Dirección</label>
                                    <input type="text" name="direccion" class="form-control mb-3" data-validate="true" data-type="address" data-max-length="255" required>
                                    <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>

                                    <label for="tipo_paciente">Tipo de paciente</label>
                                    <select name="tipo_paciente" id="tipo_paciente" class="form-control mb-3" requried>
                                        <option value="1">Natural</option>
                                        <option value="2">Asegurado</option>
                                        <option value="3">Beneficiado</option>
                                    </select>
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

        <template id="template-antecedente">
            <div class="antecedente">
                <p><b>Tipo de antecedente:</b> <span id="tipo_antedecente"></span></p>
                <p><b>Descripción</b> <span id="descripcion_antecedente"></span></p>
            </div>
        </template>

        <template id="template-consulta">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <a class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#consulta1" aria-expanded="false" aria-controls="consulta1">
                        </a>
                    </h2>
                </div>
                <div id="consulta1" class="collapse show" data-parent="#consultaAccordion">
                    <div class="card-body">
                        <p>ID: <span id="consulta_id">133</span> <br> Nombre médico: <span id="nombre_medico">Francis Baloa</span> <br> Especialidad: <span id="especialidad">Psiquiatría</span> <br> Fecha consulta: <span id="fecha_consulta">2022-07-02</span> <br> Observaciones: <span id="observaciones">Dolor de Cabeza</span></p>
                    </div>
                </div>
            </div>
        </template>

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/mostrarPacientes.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/tipoPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/infoPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/registrarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/actualizarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/eliminarPaciente.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/addTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/deleteTitularInput.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/pacientes/pacienteMenorDeEdad.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
</body>