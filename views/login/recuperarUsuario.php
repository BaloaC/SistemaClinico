<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/login.css'); ?>" />
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/bootstrap/bootstrap.min.css'); ?>" />
    <title>Login</title>
</head>

<body>
    <div class="container vh-100">
        <div class="row h-100 d-flex align-items-center justify-content-center">
            <!-- Login container -->
            <div class="login-container col-12 col-md-10 d-flex align-items-center justify-content-center rounded">
                <!-- Login content -->
                <div class="row bg-light rounded-3 shadow w-75">
                    <!--  Imagen lateral -->
                    <div class="col-4 col-md-6 border-end shadow-lg rounded-3 p-0">
                        <img class="w-100 h-100" src="<?php echo Url::to('assets/img/forgot-password.webp'); ?>" alt="Fondo">
                    </div>
                    <!-- Login information -->
                    <div class="col-md-6 col-8">
                        <div class="row p-4">
                            <!-- Logo -->
                            <div class="col-3 offset-lg-10 col-lg-2 p-0">
                                <a href="../proyectofeo/">
                                    <img class="w-100" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="Logo">
                                </a>
                            </div>
                            <!-- Login form -->
                            <div class="offset-1 col-10 mt-3">
                                <p class="fs-4 fw-bold">Recuperación de Contraseña</p>
                                <div class="alert d-none" role="alert"></div>
                                <form method="POST" id="login-form" class="login-form row position-relative">
                                    <div id="form-user">
                                        <label>Introduzca su usuario</label>
                                        <input class="form-control" type="text" name="usuario" id="usuario" data-validate="true" data-type="username" data-max-length="16" required>
                                        <small class="form-text">Solo se permiten los siguientes caracteres: "_" y "-"</small>
                                        <div class="text-center"><input id="siguiente" class="btn btn-primary my-5" value="Siguiente"></div>
                                    </div>
                                    <div id="form-recovery">
                                        <label>Seleccione un método de recuperación</label>
                                        <select name="metodo" id="select-metodo" required>
                                            <option value="0">Seleccione una opción</option>
                                            <option value="1">Pin</option>
                                            <option value="2">Preguntas de Seguridad</option>
                                        </select>
                                        <div id="childForm"></div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/recuperarUsuario.js'); ?>"></script>
</body>

</html>