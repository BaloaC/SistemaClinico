<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/homepage.css'); ?>">
    
    <title>Proyecto 4 | Welcome</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <header class="d-flex align-items-center justify-content-center">
            <div>
                <h2 class="p-4">Centro Médico Hiperbárico</h2>
                <h2 class="p-2">Y De Rehabilitación</h2>
                <h1 class="p-4 fw-bold text-uppercase">Shenque</h1>
            </div>
        </header>
        <section class="bg-blue-c">
            <div class="container">
                <div class="row">
                    <!-- Contenido de Bienvenida -->
                    <div class="col-12 col-lg-6 order-lg-first order-last flex-column p-5">
                        <div class="text-start">
                            <h1 class="py-4 lt-spacing-1 fs-7">¡Bienvenido!</h1>
                            <h2 class="mb-3">@usuario</h2>
                        </div>
                        <select class="col-8 w-75 form-select form-select-lg my-3" name="especialidades">
                            <option value="Ematologia">Todas las especialidades</option>
                            <option value="ematologia completa">Neurologia</option>
                            <option value="examen de adn">Cardiologia</option>
                            <option value="ematologia completa">Ginecologia</option>
                            <option value="examen de adn">Fisioterapeuta</option>
                            <option value="ematologia completa">Psiquiatria</option>
                            <option value="examen de adn">Medicina interna</option>
                            <option value="ematologia completa">Odontologia</option>
                            <option value="examen de adn">Medicina General</option>
                            <option value="ematologia completa">Psicologia</option>
                            <option value="examen de adn">Bionalista</option>
                        </select>
                        <select class="w-75 form-select form-select-lg my-3" name="filtrarFecha">
                            <option value="Ematologia">Todo el año</option>
                        </select>
                    </div>
                    <!-- Gráfica -->
                    <div class="col-12 col-lg-6 order-lg-last order-first bg-dark">
                        <img src="<?php echo Url::to('assets/img/doctor (1).png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </section>
        <section class="border-bottom border-light-c">
            <div class="container bg-light-blue">
                <div class="row">
                    <!-- Contenido de Bienvenida -->
                    <div class="col-12 col-lg-6 order-lg-first order-last bg-light p-4 flex-column">
                        <h1 class="fw-bold p-4">¡Bienvenido!</h1>
                        <h2 class="mb-3">@usuario</h2>
                        <select class="form-select form-select-lg my-3" name="especialidades">
                            <option value="Ematologia">Todas las especialidades</option>
                            <option value="ematologia completa">Neurologia</option>
                            <option value="examen de adn">Cardiologia</option>
                            <option value="ematologia completa">Ginecologia</option>
                            <option value="examen de adn">Fisioterapeuta</option>
                            <option value="ematologia completa">Psiquiatria</option>
                            <option value="examen de adn">Medicina interna</option>
                            <option value="ematologia completa">Odontologia</option>
                            <option value="examen de adn">Medicina General</option>
                            <option value="ematologia completa">Psicologia</option>
                            <option value="examen de adn">Bionalista</option>
                        </select>
                        <select class="form-select form-select-lg my-3" name="filtrarFecha">
                            <option value="Ematologia">Todo el año</option>
                        </select>
                    </div>
                    <!-- Gráfica -->
                    <div class="col-12 col-lg-6 order-lg-last order-first bg-dark">
                        <img src="<?php echo Url::to('assets/img/doctor (1).png'); ?>" alt="">
                    </div>
                </div>
            </div>
        </section>
        <footer>
            <h1 class="text-light py-5 mb-3">Navegacion Por El Sitio</h1>

            <div class="container">
                <div class="row">
                    <!-- Primera Fila -->
                    <div class="col-12 d-fle">
                        <div class="row">
                            <article class="col-lg-6 col-md-6 col-sm-6 p-2">
                                <a class="text-decoration-none text-dark" href="">
                                    <div class="bg-img">
                                        <img src="<?php echo Url::to('assets/img/rueda-dentada.png') ?>" alt="adminAlt">
                                    </div>
                                    <h2 class="text-light">Administrador</h2>
                                    <p class="text-light">Acceso a la gestion de usuarios del sistema</p>
                                </a>
                            </article>
                            <article class="col-lg-6 col-md-6 col-sm-6 p-2">
                                <a class="text-decoration-none text-dark" href="">
                                    <div class="bg-img">
                                        <img src="<?php echo Url::to('assets/img/cirujano.png') ?>" alt="especialidadesAlt">
                                    </div>
                                    <h2 class="text-light">Especialidades</h2>
                                    <p class="text-light">Acceso a los modulos medicos, especialidades y laboratorio</p>
                                </a>
                            </article>
                        </div>
                    </div>
                    <!-- Segunda Fila -->
                    <div class="col-12 d-fle">
                        <div class="row">
                            <article class="col-lg-4 col-md-6 col-sm-6 p-2">
                                <a class="text-decoration-none text-dark" href="">
                                    <div class="bg-img">
                                        <img src="<?php echo Url::to('assets/img/resultado-medico.png') ?>" alt="pacientesAlt">
                                    </div>
                                    <h2 class="text-light">Pacientes</h2>
                                    <p class="text-light">Acceso a los modulos pacientes, seguros y empresas</p>
                                </a>
                            </article>
                            <article class="col-lg-4 col-md-6 col-sm-6 p-2">
                                <a class="text-decoration-none text-dark" href="">
                                    <div class="bg-img">
                                        <img src="<?php echo Url::to('assets/img/factura.png') ?>" alt="facturacionAlt">
                                    </div>
                                    <h2 class="text-light">Facturación</h2>
                                    <p class="text-light">Acceso a los modulos facturas y libros</p>
                                </a>
                            </article>
                            <article class="col-lg-4 col-md-12 p-2">
                                <a class="text-decoration-none text-dark" href="">
                                    <div class="bg-img">
                                        <img src="<?php echo Url::to('assets/img/medicamento.png') ?>" alt="inventarioAlt">
                                    </div>
                                    <h2 class="text-light">Inventario</h2>
                                    <p class="text-light">Acceso a la gestion de inventario</p>
                                </a>
                            </article>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
</body>

</html>