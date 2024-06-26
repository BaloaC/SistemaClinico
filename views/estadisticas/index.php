<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/estadisticas.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <title>Proyecto 4 | Estadísticas</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <div class="container home">
        <div class="row">
            <h1 class="py-4 fs-7 mt-5">Panel de Estadísticas</h1>
            <h5 class="w-75"> Este apartado del sistema te permite visualizar información a través de gráficas las cuales proporcionan una representación visual de los datos registrados de forma general (o semanalmente en el caso de las consultas). En esta sección, puedes encontrar dos tipos de gráficas: las relacionadas con los pacientes registrados y las relacionadas con las consultas realizadas, las cuales cuentan con filtros por rango para cada una.</h5>
        </div>
    </div>

    <main class="main-home">
        <section>
            <div class="container">
                <h3>Pacientes</h3>
                <p class="mt-3">Filtrar pacientes por rango de edades:</p>
                <div class="containerFiltroPacienteEdad my-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Inicio del rango</label>
                                <input type="number" class="form-control w-100" id="startRange">
                            </div>
                            <div class="col-6">
                                <label for="">Fin del rango</label>
                                <input type="number" class="form-control w-100" id="endRange">
                            </div>
                        </div>
                    </div>
                </div>
                <button id="filterBtn" class="btn btn-sm btn-add w-25 text-white mt-3" onclick="graphFilterHandler(1)">Filtrar</button>
                <div class="row especialidad-container my-5">
                    <!-- Gráfica Paciente por edad-->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="pacienteEdad" class="chart"></div>
                            <p class="pacienteEdad text-no-graph no-data d-none">Todavía no hay pacientes registrados</p>
                            <p class="pacienteEdad loading text-no-graph no-data d-none">Cargando</p>
                        </div>
                    </div>
                    <!-- Gráfica PAciente por tipo-->
                    <div class="col-12 col-lg-6 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="pacienteTipo" class="chart"></div>
                            <p class="pacienteTipo text-no-graph no-data d-none">Todavía no hay pacientes registrados</p>
                            <p class="pacienteTipo loading text-no-graph no-data d-none">Cargando</p>
                        </div>
                    </div>
                </div>


            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="mt-5">Consultas</h3>
                <p class="mt-3">Filtrar consultas por rango de fechas:</p>
                <div class="containerFiltroConsultaFecha my-3">
                    <div class="col-6">
                        <div class="row">
                            <div class="col-6">
                                <label for="">Fecha inicio</label>
                                <input type="date" class="form-control w-100" id="startDate">
                            </div>
                            <div class="col-6">
                                <label for="">Fecha final</label>
                                <input type="date" class="form-control w-100" id="endDate">
                            </div>
                        </div>
                    </div>
                </div>
                <button id="filterBtn" class="btn btn-sm btn-add w-25 text-white mt-3" onclick="graphFilterHandler(2)">Filtrar</button>
                <div class="row especialidad-container mt-5">
                    <!-- Gráfica Consultas Aseguradas-->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="consultasAseguradas" class="chart"></div>
                            <p class="consultasAseguradas text-no-graph no-data d-none">Todavía no hay consultas aseguradas registradas este mes</p>
                            <p class="consultasAseguradas loading text-no-graph no-data d-none">Cargando</p>
                        </div>
                    </div>
                    <!-- Gráfica Consultas por especialidad-->
                    <div class="col-12 col-lg-6 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="consultasEspecialidad" class="chart"></div>
                            <p class="consultasEspecialidad text-no-graph no-data d-none">Todavía no hay consultas registradas este mes</p>
                            <p class="consultasEspecialidad loading text-no-graph no-data d-none">Cargando</p>
                        </div>
                    </div>

                    <div class="col-12 col-lg-6 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <<div id="medicoConsulta" class="chart">
                        </div>
                        <p class="medicoConsulta text-no-graph no-data d-none">Todavía no hay médicos con consultas registradas</p>
                        <p class="medicoConsulta loading text-no-graph no-data d-none">Cargando</p>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <!-- <script type="module" src="<?php echo Url::to('assets/js/homepage/pocosInsumos.js'); ?>"></script> -->
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/index.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/amcharts5/percent.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/xy.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Animated.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Responsive.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/pacienteEdad.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/pacienteTipo.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/medicoConsulta.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/consultasAseguradas.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/consultasEspecialidad.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/estadisticas/graphFilterHandler.js'); ?>"></script>
    <!-- <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesGraph.js'); ?>"></script> -->
    <!-- <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesFetch.js'); ?>"></script> -->



</body>

</html>