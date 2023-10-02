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

    <main class="main-home">
        <div class="container text-light">
            <h1 class="py-4 fs-7 mt-5">Panel de estadisticas</h1>
            <h5 class="w-75">En esta sección del sistema, podrá visualizar a través de gráficas la información registrada en el mismo a nivel general o mensual.</h5>
        </div>
        <section>
            <div class="container">
                <h3>Pacientes</h3>
                <div class="row especialidad-container my-5">
                    <!-- Gráfica Paciente por edad-->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="pacienteEdad" class="chart"></div>
                        </div>
                    </div>
                    <!-- Gráfica PAciente por tipo-->
                    <div class="col-12 col-lg-6 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="pacienteTipo" class="chart"></div>
                        </div>
                    </div>
                </div>


            </div>
        </section>
        <section>
            <div class="container">
                <h3 class="mt-5">Médicos</h3>
                <div class="row especialidad-container mt-5">
                    <!-- Gráfica Paciente por edad-->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="medicoConsulta" class="chart"></div>
                        </div>
                    </div>
                </div>

                <h3 class="mt-5">Consultas</h3>
                <div class="row especialidad-container mt-5">
                    <!-- Gráfica Paciente por edad-->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="consultasAseguradas" class="chart"></div>
                        </div>
                    </div>
                    <!-- Gráfica Paciente por tipo-->
                    <div class="col-12 col-lg-6 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="consultasEspecialidad" class="chart"></div>
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
    <!-- <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesGraph.js'); ?>"></script> -->
    <!-- <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesFetch.js'); ?>"></script> -->



</body>

</html>