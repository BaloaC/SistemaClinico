<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/welcome.css'); ?>">
    <title>Proyecto 4 | Welcome</title>
</head>

<body>
    <!-- Nav -->
    <!-- <nav class="navbar navbar-expand-lg">
        <div class="container"> -->
            <!-- Logo -->
            <!-- <a class="navbar-brand" href="#">
                <img class="w-50" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logoAlt">
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navBarGod" aria-controls="navBarGod" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button> -->

            <!-- Links -->
            <!-- <div class="collapse navbar-collapse" id="navBarGod">
                <ul class="list-nav navbar-nav align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?php echo Url::to('/login') ?>">Iniciar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav> -->
    <!-- Fin Nav -->
    <main class="vh-100">
        <div class="container-fluid h-100 p-0">
            <div class="row">
                <!-- Imagen -->
                <div class="col-0 col-md-7 d-flex justify-content-start align-items-center vh-100">
                    <img class="w-100 img-welcome" src="<?php echo Url::to('assets/img/guantes.jpg'); ?>" alt="">
                </div>
                <!-- Contenido -->
                <div class="col-12 col-md-3 d-flex justify-content-center align-items-center">
                    <h1 class="title position-absolute bottom-50 start-50">Centro Médico SHENQUE</h1>
                    <h2 class="position-absolute top-0 start-50 fs-1 fw-light">2022</h2>
                    <a class="btn-login fw-light" href="#">Inicio de Sesión</a>
                </div>
            </div>
        </div>
    </main>

    <!-- <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script> -->
    <!-- <?php include PATH_VIEWS . '/partials/footer.php'; ?> -->
</body>
</html>