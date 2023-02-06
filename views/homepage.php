<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/homepage.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <title>Proyecto 4 | Welcome</title>
</head>

<body class="bg-transparent">
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <div class="bg-static"></div>
    <main class="main-home">
        <header class="d-flex align-items-center justify-content-center">
            <div>
                <h2 class="p-4">Centro Médico Hiperbárico</h2>
                <h2 class="p-2">Y De Rehabilitación</h2>
                <h1 class="p-4 fw-bold text-uppercase">Shenque</h1>
            </div>
        </header>
        <section>
            <div class="container">
                <div class="row especialidad-container">
                    <!-- Contenido de Bienvenida -->
                    <div class="col-12 col-lg-5 order-lg-first order-last flex-column p-5">
                        <div class="text-start">
                            <h1 class="py-4 lt-spacing-1 fs-7">¡Bienvenido!</h1>
                            <h2 class="mb-3 text-transparent">@usuario</h2>
                        </div>
                        <select class="w-60 select-transparent form-select form-select-lg mx-3" id="s-especialidades" name="especialidades" data-active="0">  
                            <option value="all" selected>Todas las especialidades</option>    
                        </select>
                        <select class="w-60 select-transparent form-select form-select-lg my-3" id="s-fecha" name="filtrarFecha">
                            <option value="year" selected>Todo el año</option>  
                        </select>
                    </div>
                    <!-- Gráfica -->
                    <div class="col-12 col-lg-7 order-lg-last order-first">
                        <div class="card card-home shadow-dark"><div id="chartdiv"></div></div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-7 order-2 order-lg-1">
                        <div class="card card-home shadow-dark">
                            <div class="card-header text-center">
                                <h2 class="card-title text-dark m-1">Insumos por agotarse</h2>
                            </div>
                            <div class="card-body card-insumo">
                                <div class="table-responsive">
                                    <table id="pocosInsumos" class="table table-compact">
                                        <thead>
                                            <tr>
                                                <th>Insumo ID</th>
                                                <th>Nombre</th>
                                                <th>Cant Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Vendas</td>
                                                <td>12</td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Curitas</td>
                                                <td>2</td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Loratadina</td>
                                                <td>13</td>
                                            </tr>
                                            <tr>
                                                <td>4</td>
                                                <td>Paracetamol</td>
                                                <td>18</td>
                                            </tr>
                                            <tr>
                                                <td>5</td>
                                                <td>Inyectadoras</td>
                                                <td>50</td>
                                            </tr>
                                            <tr>
                                                <td>6</td>
                                                <td>Ibuprofeno</td>
                                                <td>155</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Tabla de inventario -->
                    <div class="col-12 col-lg-5 order-1 order-lg-2 p-4 flex-column">
                        <h1 class="fw-bold mb-0">Control de Inventario</h1>
                        <h6 class="mb-3 text-transparent">Acceso Rápido</h6>
                        <p class="pt-4 ps-">Verifique rápidamente los insumos que poseen menor cantidad en el sistema</p>
                        <button class="btn btn-blue mt-5">ir al Inventario</button>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div>
                <h1 class="text-light py-5 mb-3">Navegacion Por El Sitio</h1>

                <div class="container">
                    <div class="row">
                        <!-- Primera Fila -->
                        <div class="col-12">
                            <div class="row pb-5">
                                <article class="col-lg-2 col-md-6 col-sm-6 p-2">
                                    <a class="text-decoration-none text-dark" href="">
                                        <div class="bg-img mb-4">
                                            <img src="<?php echo Url::to('assets/img/rueda-dentada.png') ?>" alt="adminAlt">
                                        </div>
                                        <h2 class="text-light">Administrador</h2>
                                        <p class="text-light text-lightblue">Acceso a la gestion de usuarios del sistema</p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-6 col-sm-6 p-2">
                                    <a class="text-decoration-none text-dark" href="">
                                        <div class="bg-img mb-4">
                                            <img src="<?php echo Url::to('assets/img/cirujano.png') ?>" alt="especialidadesAlt">
                                        </div>
                                        <h2 class="text-light">Especialidades</h2>
                                        <p class="text-light text-lightblue">Acceso a los modulos medicos, especialidades y laboratorio</p>
                                    </a>
                                </article>
                            </div>
                        </div>
                        <!-- Segunda Fila -->
                        <div class="col-12">
                            <div class="row">
                                <article class="col-lg-2 col-md-6 col-sm-6 p-2">
                                    <a class="text-decoration-none text-dark" href="">
                                        <div class="bg-img mb-4">
                                            <img src="<?php echo Url::to('assets/img/resultado-medico.png') ?>" alt="pacientesAlt">
                                        </div>
                                        <h2 class="text-light">Pacientes</h2>
                                        <p class="text-light text-lightblue">Acceso a los modulos pacientes, seguros y empresas</p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-6 col-sm-6 p-2">
                                    <a class="text-decoration-none text-dark" href="">
                                        <div class="bg-img mb-4">
                                            <img src="<?php echo Url::to('assets/img/factura.png') ?>" alt="facturacionAlt">
                                        </div>
                                        <h2 class="text-light">Facturación</h2>
                                        <p class="text-light text-lightblue">Acceso a los modulos facturas y libros</p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-12 p-2">
                                    <a class="text-decoration-none text-dark" href="">
                                        <div class="bg-img mb-4">
                                            <img src="<?php echo Url::to('assets/img/medicamento.png') ?>" alt="inventarioAlt">
                                        </div>
                                        <h2 class="text-light">Inventario</h2>
                                        <p class="text-light text-lightblue">Acceso a la gestion de inventario</p>
                                    </a>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/js/homepage/pocosInsumos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/index.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/xy.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Animated.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Responsive.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesGraph.js'); ?>"></script>

   

</body>

</html>