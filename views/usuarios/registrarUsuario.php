<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/login.css'); ?>" />
    <title>Proyecto 4 | Registrar Usuario</title>
</head>

<body class="vh-100">
    <main class="h-100">
        <div class="container h-100">
            <div class="row h-100 d-flex align-items-center justify-content-center">
                <!-- Registro container -->
                <div class="login-container col-12 col-md-10 d-flex align-items-center justify-content-center rounded">
                    <!-- Registro content -->
                    <div class="row h-100 bg-light justify-content-between rounded-3 shadow">
                        <!--  Imagen lateral -->
                        <div class="col-4 col-md-4 border-end shadow-lg d-flex align-items-center justify-content-center rounded-3 p-0">
                            <img class="w-100 h-100 rounded-3" src="<?php echo Url::to('assets/img/FONDO.jpg'); ?>" alt="">
                        </div>
                        <!-- Registro information -->
                        <div class="col-md-8 col-8">
                            <div class="row justify-content-end align-items-end p-4">
                                <!-- Logo -->
                                <div class="col-3 col-lg-2 p-0">
                                    <a href="">
                                        <img class="w-100" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="Logo">
                                    </a>
                                </div>
                                <!-- Registro form -->
                                <div class="row mt-5">
                                    <p class="fs-4 fw-bold">Registrar Usuario</p>
                                    <p class="fs-5">Introduzca su información</p>
                                    <div class="alert d-none" role="alert"></div>
                                    <form class="register-form">
                                        <label for="nombre">Nombre de usuario</label>
                                        <input class="form-control" type="text" name="nombre" required>
                                        <label for="clave">Contraseña</label>
                                        <input class="form-control" type="password" name="clave" required>
                                        <label for="confirmarClave">Confirmar contraseña</label>
                                        <input class="form-control" type="password" name="confirmarClave" required>
                                        <label for="rol">Nivel de usuario</label>
                                        <select class="form-select" name="rol" required>
                                            <option value="">Seleccione un nivel de usuario...</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Médico</option>
                                            <option value="3">Gerente</option>
                                            <option value="4">Analista</option>
                                            <option value="5">Enfermera</option>
                                        </select>
                                        <input type="submit" class="btn btn-primary" value="Registrar Usuario">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="<?php echo Url::to('assets/js/usuarios/registrarUsuario.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>

</html>