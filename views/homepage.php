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
                        <select class="w-60 form-select form-select-lg" id="s-especialidades" name="especialidades" data-active="0">
                            <option value="all" selected>Todas las especialidades</option>
                        </select>
                        <select class="w-60 select-transparent form-select form-select-lg my-3" id="s-fecha" name="filtrarFecha">
                            <option value="year" selected>Todo el año</option>
                        </select>
                    </div>
                    <!-- Gráfica -->
                    <div class="col-12 col-lg-7 order-lg-last order-first">
                        <div class="card card-home shadow-dark position-relative">
                            <div id="chartdiv"></div>
                            <p class="text-no-graph d-none">Todavía no hay consultas registradas</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-lg-7 order-2 order-lg-1">
                        <div class="card card-home shadow-dark h-100">
                            <div class="card-header text-center">
                                <h2 class="card-title text-dark m-1">Insumos por agotarse</h2>
                            </div>
                            <div class="card-body card-insumo">
                                <div class="table-responsive">
                                    <table id="pocosInsumos" class="table table-compact">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Cantidad Mínima</th>
                                                <th>Cantidad Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
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
                        <a href="insumos" class="btn btn-blue mt-5">ir al Inventario</a>
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <div>
                <h1 class="text-light py-5 mb-3">Navegación Por El Sitio</h1>

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
                                        <p class="text-light text-lightblue">Acceso a la gestión de usuarios del sistema</p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-6 col-sm-6 p-2">
                                    <p>
                                    <div class="bg-img mb-4">
                                        <img src="<?php echo Url::to('assets/img/cirujano.png') ?>" alt="especialidadesAlt">
                                    </div>
                                    <h2 class="text-light">Personal</h2>
                                    <p class="text-light text-lightblue">Acceso a los módulos de <a href="<?php echo Url::base() . "/especialidades" ?>">especialidades</a> y
                                        <a href="<?php echo Url::base() . "/medicos" ?>">médicos</a>
                                    </p>
                                    </a>
                                </article>
                            </div>
                        </div>
                        <!-- Segunda Fila -->
                        <div class="col-12">
                            <div class="row">
                                <article class="col-lg-2 col-md-6 col-sm-6 p-2">
                                    <p>
                                    <div class="bg-img mb-4">
                                        <img src="<?php echo Url::to('assets/img/resultado-medico.png') ?>" alt="pacientesAlt">
                                    </div>
                                    <h2 class="text-light">Atención Médica</h2>
                                    <p class="text-light text-lightblue">Acceso a los módulos de <a href="<?php echo Url::base() . "/consultas" ?>">consultas</a>, <a href="<?php echo Url::base() . "/citas" ?>">citas</a>,
                                        <a href="<?php echo Url::base() . "/examenes" ?>">exámenes</a> y <a href="<?php echo Url::base() . "/pacientes" ?>">pacientes</a>
                                    </p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-6 col-sm-6 p-2">
                                    <p>
                                    <div class="bg-img mb-4">
                                        <img src="<?php echo Url::to('assets/img/factura.png') ?>" alt="facturacionAlt">
                                    </div>
                                    <h2 class="text-light">Facturación</h2>
                                    <p class="text-light text-lightblue">Acceso a los módulos de las facturas de <a href="<?php echo Url::base() . "/factura/compra" ?>">compra</a> ,
                                        de <a href="<?php echo Url::base() . "/factura/seguro" ?>">seguro</a>, de <a href="<?php echo Url::base() . "/factura/consulta" ?>">consulta</a>
                                        y de <a href="<?php echo Url::base() . "/factura/medico" ?>">médicos</a></p>
                                    </a>
                                </article>
                                <article class="offset-lg-2 col-lg-2 col-md-12 p-2">
                                    <p>
                                    <div class="bg-img mb-4">
                                        <img src="<?php echo Url::to('assets/img/medicamento.png') ?>" alt="inventarioAlt">
                                    </div>
                                    <h2 class="text-light">Inventario</h2>
                                    <p class="text-light text-lightblue">Acceso a la gestión de <a href="<?php echo Url::base() . "/proveedores" ?>">proveedores</a> e <a href="<?php echo Url::base() . "/insumos" ?>">insumos</a></p>
                                    </a>
                                </article>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <section class="service-style1-area">
            <div class="round-shape wow slideInLeft animated" style="visibility: visible; animation-duration: 5500ms; animation-delay: 100ms; animation-name: slideInLeft;">
                <img class="zoom-fade" src="assets/images/shape/shape-round.png" alt="">
            </div>
            <div class="container">
                <div class="sec-title text-center">
                    <h1 class="text-light py-5 mb-3">Todos nuestros servicios</h1>
                </div>
                <div class="row">
                    <div class="col-xl-4 col-lg-6" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services1.jpg') ?>" alt="services1">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/vendaje.png') ?>" alt="icon">
                                <h3 class="service-title"><a>Especialidades</a></h3>
                                <div class="inner-text">
                                    <p>Consultas médicas generales, familiares e internas y atención personalizada en distintas especialidades.</p>
                                    <div class="dropdown" style="display: inline-block;" data-bs-hover="dropdown">
                                        <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            Ver todas las especialidades
                                        </a>
                                        <div class="dropdown-menu" aria-labelledby="navbarDropdown" id="especialidadDropdown" style="background-color: #f5f5f5;">
                                            <!-- <p class="dropdown-item">Cardiología - Psicología - Pediatría</p>
                                            <p class="dropdown-item">Dermatología - Traumatología - Nefrología</p>
                                            <p class="dropdown-item">Nefrología - Gastroenterología - Ginecología</p>
                                            <p class="dropdown-item">Otorrinolanringología - Oncología - Urología</p>
                                            <p class="dropdown-item">Neurocirugía - Nutricionista</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-6" style="visibility: visible; animation-duration: 1500ms; animation-delay: 0ms; animation-name: fadeInUp;">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services2.jpg') ?>" alt="services2">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/bisturi.png') ?>" alt="icon">
                                <h3 class="service-title"><a>Cirugía</a></h3>
                                <div class="inner-text">
                                    <p>Intervenciones quirúrgicas pediátrica y de manos realizadas por especialistas altamente capacitados.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services3.jpg') ?>" alt="services3">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/laboratorio.png') ?>" alt="icon">
                                <h3 class="service-title"><a href="<?php echo Url::base() . "/laboratorios" ?>">Laboratorio</a></h3>
                                <div class="inner-text">
                                    <p>Análisis clínicos y pruebas diagnósticas para un enfoque integral en el cuidado de la salud de nuestros pacientes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services4.jpg') ?>" alt="services4">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/rayos-x.png') ?>" alt="icon">
                                <h3 class="service-title"><a>RX</a></h3>
                                <div class="inner-text">
                                    <p>Nuestro consultorio ofrece el servicio de RX para diagnosticar fracturas óseas y enfermedades pulmonares que ayuda a detectar diferentes condiciones médicas para un tratamiento efectivo.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services5.jpg') ?>" alt="services5">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/terapia-fisica.png') ?>" alt="icon">
                                <h3 class="service-title"><a>Terapia</a></h3>
                                <div class="inner-text">
                                    <p>Ofrecemos servicios de terapia avanzada, como la Ozonoterapia, Hidroterapia en piscina y Cámara hiperbárica. Nuestras terapias están diseñadas para mejorar la calidad de vida y la salud de nuestros pacientes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6">
                        <div class="single-service-style1 text-center">
                            <div class="icon-holder">
                                <img src="<?php echo Url::to('assets/img/services6.jpg') ?>" alt="services6">
                            </div>
                            <div class="title-holder">
                                <img src="<?php echo Url::to('assets/img/ultrasonido.png') ?>" alt="icon">
                                <h3 class="service-title"><a>Ecosonograma</a></h3>
                                <div class="inner-text">
                                    <p>Nuestro consultorio ofrece servicios de ecosonogramas especializados para diagnósticos precisos en diversas áreas del cuerpo. Contamos con tecnología de última generación para brindarle resultados de alta calidad a nuestros pacientes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/homepage/pocosInsumos.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/index.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/xy.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Animated.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/libs/amcharts5/Responsive.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesGraph.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/homepage/especialidadesFetch.js'); ?>"></script>



</body>

</html>