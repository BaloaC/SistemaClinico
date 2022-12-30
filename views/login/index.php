<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/login.css'); ?>" />
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/bootstrap.min.css'); ?>" />
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
                    <div class="col-4 col-md-4 border-end shadow-lg rounded-3 p-0">
                        <img class="w-100 h-100" src="<?php echo Url::to('assets/img/FONDO.jpg'); ?>" alt="Fondo">
                    </div>
                    <!-- Login information -->
                    <div class="col-md-8 col-8">
                        <div class="row p-4">
                            <!-- Logo -->
                            <div class="col-3 offset-lg-10 col-lg-2 p-0">
                                <a href="../proyectofeo/">
                                    <img class="w-100" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="Logo">
                                </a>
                            </div>
                            <!-- Login form -->
                            <div class="col-12 mt-5">
                                <p class="fs-4 fw-bold">Iniciar sesion</p>
                                <p class="fs-5">Introduzca su información</p>
                                <div class="alert d-none" role="alert"></div>
                                <form class="login-form">
                                    <label for="user">Nombre de usuario</label>
                                    <input class="form-control" type="text" name="nombre" id="">
                                    <div class="d-flex justify-content-between mt-3">
                                        <label for="pass">Contraseña</label>
                                        <a class="forgot-password" href="">¿Olvidaste tu contraseña?</a>
                                    </div>
                                    <input class="form-control" type="password" name="clave">
                                    <input type="submit" class="btn btn-primary" value="Iniciar Sesion">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/iniciarSesion.js'); ?>"></script>
</body>

</html>