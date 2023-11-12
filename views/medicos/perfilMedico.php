<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/perfilMedico.css'); ?>">
    <title>Proyecto 4 | Consultar Usuarios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h4 class="pt-5 pb-2 text-grey">Perfil Médico</h4>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                </div>
                <hr class="border-white">
            </div>
            <!-- Empresas -->
            <div class="row">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 col-md-4 medico-info">
                            <img src="<?php echo Url::to('assets/img/ficha_medico.png'); ?>" alt="">
                            <p><b>Cédula:</b> <span id="cedula_medico"></span></p>
                            <p><b>Nombres y Apellidos:</b> <span id="nombre_medico"></span></p>
                            <p><b>Teléfono:</b> <span id="telefono"></span></p>
                            <p><b>Dirección:</b> <span id="direccion"></span></p>
                            <p><b>Acumulado:</b> <span id="acumulado"></span></p>
                            <p><b>Especialidad:</b> <span id="especialidadMedico"></span></p>
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
                            <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-medico text-end"><i class="fas fa-edit act-especialidad"></i></a>
                        </div>
                        <div class="col-12 col-md-8 medico-consulta">
                            <!-- <button class="btn btn-sm btn-add align-self-end mb-2" data-bs-toggle="modal" data-bs-target="#modalRegConsulta"><i class="fa-sm fas fa-plus"></i> Agregar consulta</button> -->
                            <h5 class="pt-5 pb-2 text-grey d-none" id="citasLabel">Citas pendientes</h4>
                                <div class="accordion citas-accordion" id="citaAccordion">

                                </div>
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
                        <h1 class="modal-title fs-3" id="modalRegLabel">Registrar Antecedente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert d-none" role="alert"></div>
                        <form id="info-antecedente" class="form-reg p-3 px-4">
                            <label for="tipo_antedecente_id">Tipo de antecedente</label>
                            <select name="tipo_antecedente_id" class="form-control mb-3" required>
                                <option value="" disabled selected>Seleccione el tipo de antecedente</option>
                                <option value="1">Alergía</option>
                                <option value="2">Familiar</option>
                            </select>
                            <label for="descripcion">Descripción</label>
                            <input type="text" name="descripcion" class="form-control mb-3" data-max-length="45" required>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addAntecedente()">Registrar</button>
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
                                            <option value="0243">0243</option>
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

        <!-- Modal Confirmar Eliminación -->
        <div class="modal fade" id="modalDelete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalDeleteLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="modalDeleteLabel">Eliminar Antecedente</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="delAlert" class="alert d-none" role="alert"></div>
                        ¿Está seguro que desea eliminar este antecedente?
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-confirmDelete" class="btn btn-danger" onclick="confirmDelete()">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Registo Consulta-->
        <div class="modal fade" id="modalRegConsulta" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalRegConsultaLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-3" id="modalRegConsultaLabel">Registrar Consulta</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alertConsulta d-none" role="alert"></div>
                        <form action="" id="info-consulta" class="form-reg p-3 px-4">
                            <div class="row">
                                <div class="row">
                                    <h5>Información del Paciente</h5>
                                    <div class="col-12 col-md-6">
                                        <label for="nombres">Paciente</label>
                                        <select name="paciente_id" id="s-paciente" class="form-control" data-active="0" required>
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="cita">Cita</label>
                                        <select name="cita_id" id="s-cita" class="form-control" data-active="0" required>
                                            <option></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <h5>Información de la Consulta</h5>
                                    <div class="col-12 col-md-6">
                                        <label for="peso">Peso</label>
                                        <input type="number" step="any" name="peso" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" required>
                                        <small class="form-text">No se permiten números negativos</small>

                                        <label for="altura">Altura</label>
                                        <input type="number" step="any" name="altura" class="form-control mb-3" data-validate="true" data-type="price" data-max-length="6" required>
                                        <small class="form-text">No se permiten números negativos</small>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <label for="examenes">Exámenes llevados a la consulta</label>
                                        <select name="examenes[]" id="s-examen" class="form-control mb-3" data-active="0" multiple="multiple">
                                            <option></option>
                                        </select>

                                        <label for="fecha_consulta">Fecha consulta</label>
                                        <input type="date" name="fecha_consulta" class="form-control mb-3 required">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <h5>Insumos utilizados en la Consulta (Opcional)</h5>
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-1">
                                            <button type="button" class="btn" disabled><i class="fas fa-times m-0"></i></button>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="insumo">Insumo</label>
                                            <select id="s-insumo" class="form-control insumo-id" data-active="0">
                                                <option></option>
                                            </select>
                                        </div>
                                        <div class="col-12 col-md-5">
                                            <label for="cantidad" class="p-0">Cantidad utilizada</label>
                                            <input type="number" step="any" class="form-control insumo-cant">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addInsumo" onclick="addInsumoInput('#modalRegConsulta')">Añadir otro insumo</button>

                            <div class="row mt-4">
                                <h5>Recipes otorgados en la Consulta (Opcional)</h5>
                                <div class="row align-items-center">
                                    <div class="col-3 col-md-1">
                                        <button type="button" class="btn" disabled><i class="fas fa-times m-0"></i></button>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="medicamento">Medicamento</label>
                                        <select id="s-medicamento" class="form-control medicamento-id" data-active="0">
                                            <option></option>
                                        </select>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="uso" class="p-0">Uso</label>
                                        <input type="text" class="form-control uso-medicamento">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addRecipe" onclick="addRecipeInput('#modalRegConsulta')">Añadir otro insumo</button>

                            <div class="row mt-4">
                                <h5>Indicaciones mencionadas en la Consulta (Opcional)</h5>
                                <div class="row align-items-center">
                                    <div class="col-3 col-md-1">
                                        <button type="button" class="btn" disabled><i class="fas fa-times m-0"></i></button>
                                    </div>
                                    <div class="col-12 col-md-5">
                                        <label for="indicacion" class="p-0">Indicación</label>
                                        <input type="text" class="form-control indicaciones">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary mt-3" id="addIndicacion" onclick="addIndicacionInput()">Añadir otro insumo</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="btn-registrar" class="btn btn-primary" onclick="addConsulta()">Registrar</button>
                    </div>
                </div>
            </div>
        </div>

        <template id="template-antecedente">
            <div class="antecedente">
                <p><b>Tipo de antecedente:</b> <span id="tipo_antedecente"></span></p>
                <p><b>Descripción</b> <span id="descripcion_antecedente"></span></p>
                <div class="actions text-end">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalAct" class="act-antecedente"><i class="fas fa-edit act-antecedente"></i></a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#modalDelete" class="del-antecedente"><i class="fas fa-trash del-antecedente"></i></a>
                </div>
            </div>
        </template>

        <template id="template-seguro">
            <div class="seguro">
                <p><b>Nombre de la empresa:</b> <span id="nombre_empresa"></span></p>
                <p><b>Nombre del seguro:</b> <span id="nombre_seguro"></span></p>
            </div>
        </template>

        <template id="template-cita">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">
                        <a class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#cita1" aria-expanded="false" aria-controls="cita1">
                        </a>
                    </h2>
                </div>
                <div id="cita1" class="collapse show" data-parent="#citaAccordion">
                    <div class="card-body">
                        <p><b>ID:</b> <span id="cita_id"></span> <br>
                            <b>Nombre paciente:</b> <span id="nombre_paciente"></span> <br>
                            <b>Especialidad:</b> <span id="especialidad"></span> <br>
                            <b>Fecha cita:</b> <span id="fecha_cita"></span> <br>
                            <b>Motivo cita:</b> <span id="motivo_cita"></span> <br>
                            <b>Hora entrada:</b> <span id="hora_entrada"></span> <br>
                            <b>Hora salida:</b> <span id="hora_salida"></span> <br>
                            <b>Tipo de cita:</b> <span id="tipo_cita"></span> <br>
                            <b>Estatus:</b> <span id="estatus_cit"></span> <br>
                        </p>
                    </div>
                </div>
            </div>
        </template>

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

    </main>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/perfil-medico/mostrarPerfilMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/perfil-medico/actualizarMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/perfil-medico/eliminarEspecialidadMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/perfil-medico/eliminarHorarioMedico.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/medicos/changeHorarioInput.js'); ?>"></script>
</body>