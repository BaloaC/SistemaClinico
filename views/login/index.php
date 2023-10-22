<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/bootstrap/bootstrap.min.css'); ?>" />
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/login.css'); ?>" />
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
                        <img class="w-100 h-100" src="<?php echo Url::to('assets/img/FONDO.jpg'); ?>" alt="Fondo">
                    </div>
                    <!-- Login information -->
                    <div class="col-md-6 col-8">
                        <div class="row p-4">
                            <!-- Logo -->
                            <div class="col-3 offset-lg-10 col-lg-2 p-0">
                                <a href="<?php echo Url::base() . "/login" ?>">
                                    <img class="w-100" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="Logo">
                                </a>
                            </div>
                            <!-- Login form -->
                            <div class="col-12 mt-3">
                                <p class="fs-4 fw-bold">Iniciar sesion</p>
                                <div class="alert d-none" role="alert"></div>
                                <form class="login-form row">
                                    <div class="offset-2 col-8">
                                        <label for="user">Nombre de usuario</label>
                                        <input class="form-control no-pass" type="text" name="nombre" id="" data-max-length="16" required>
                                        <label for="pass" class="mt-2">Contraseña</label>
                                        <div class="input-group mb-3">
                                            <input class="form-control mb-3" type="password" inputmode="text" id="password" name="clave" data-max-length="20" required>
                                            <i class="fas fa-eye" id="togglePassword" onclick="showPassword(this,'password')"></i>
                                        </div>
                                        <div class="text-end"><a href="<?php echo Url::base() . "/login/recuperarusuario" ?>" class="forgot-password" href="">¿Olvidaste tu contraseña?</a></div>
                                        <div class="text-center"><button type="submit text-center" class="btn btn-primary mt-3" value="Iniciar Sesion">Iniciar Sesión</button></div>
                                    </div>
                                </form>
                                <div class="text-center mt-5">
                                    <p>¿Todavía no tienes una cuenta? <a href="<?php echo Url::base() . "/usuarios/registrar" ?>">Regístrate</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/login/iniciarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/login/autoLogOut.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/js/global/showPassword.js'); ?>"></script>
</body>

</html>