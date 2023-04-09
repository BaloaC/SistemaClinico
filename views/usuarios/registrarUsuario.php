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
                    <!-- Registro information -->
                    <div class="bg-light rounded-3">
                        <!-- Logo -->
                        <div class="d-flex justify-content-center mt-2">
                            <a href="<?php echo Url::base() . "/login" ?>">
                                <img class="w-15" src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="Logo">
                            </a>
                        </div>
                        <!-- Registro form -->
                        <div class="row mt-1 text-center">
                            <p class="fs-4 fw-bold">Registrar Usuario</p>
                            <!-- <p class="fs-5">Introduzca su información</p> -->
                            <div class="alert d-none" role="alert"></div>
                            <form class="register-form offset-2 col-8 text-start position-relative">
                                <div id="form-info" class="form-info">
                                    <label for="nombre">Nombre de usuario</label>
                                    <input class="form-control" type="text" name="nombre" data-validate="true" data-type="username" data-max-length="16" required>
									<small class="form-text">Solo se permiten los siguientes caracteres: "_" y "-"</small>
                                    <label for="clave">Contraseña</label>
                                    <input class="form-control" type="password" name="clave" data-validate="true" data-type="password" data-max-length="20" required>
									<small class="form-text">La contraseña debe contener al menos 8 caracteres <br> y los caracteres permitdos son: "@" y "-"</small>
                                    <label for="confirmarClave">Confirmar contraseña</label>
                                    <input class="form-control" type="password" name="confirmarClave" data-max-length="20" required>
									<small class="form-text">Las contraseñas no coinciden</small>
                                    <label for="pin">Pin</label>
                                    <input class="form-control" type="password" name="pin" data-validate="true" data-type="pin" required>
									<small class="form-text">El pin debe contener mínimo 6 números</small>
                                    <label for="rol">Nivel de usuario</label>
                                    <select class="form-select" name="rol" required>
                                        <option value="" disabled>Seleccione un nivel de usuario...</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Médico</option>
                                        <option value="3">Gerente</option>
                                        <option value="4">Analista</option>
                                        <option value="5">Enfermera</option>
                                    </select>
                                    <div class="text-center"><input id="siguiente" class="btn btn-primary my-5" value="Siguiente"></div>
                                </div>
                                
                                <div id="form-preguntas" class="form-preguntas">
                                    <label>Pregunta de Seguridad 1</label>
                                    <select class="form-select" name="pregunta1" required>
                                        <option value="">Seleccione una pregunta de seguridad</option>
                                        <option value="1">Cuál es tu color favorito</option>
                                        <option value="2">Nombre de tu mascota de la infancia</option>
                                        <option value="3">Segundo apellido de tu mamá</option>
                                        <option value="4">Apodo de la infancia</option>
                                        <option value="5">Cuál es tu pasatiempo favorito</option>
                                        <option value="6">Programa o serie de televisión favorito</option>
                                        <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                        <option value="8">Algo que odies</option>
                                    </select>
                                    <input class="form-control mt-3" type="text" name="respuesta1" placeholder="Respuesta a la pregunta de Seguridad" required>

                                    <label>Pregunta de Seguridad 2</label>
                                    <select class="form-select" name="pregunta2" required>
                                        <option value="">Seleccione una pregunta de seguridad</option>
                                        <option value="1">Cuál es tu color favorito</option>
                                        <option value="2">Nombre de tu mascota de la infancia</option>
                                        <option value="3">Segundo apellido de tu mamá</option>
                                        <option value="4">Apodo de la infancia</option>
                                        <option value="5">Cuál es tu pasatiempo favorito</option>
                                        <option value="6">Programa o serie de televisión favorito</option>
                                        <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                        <option value="8">Algo que odies</option>
                                    </select>
                                    <input class="form-control mt-3" type="text" name="respuesta2" placeholder="Respuesta a la pregunta de Seguridad" required>

                                    <label>Pregunta de Seguridad 3</label>
                                    <select class="form-select" name="pregunta3" required>
                                        <option value="">Seleccione una pregunta de seguridad</option>
                                        <option value="1">Cuál es tu color favorito</option>
                                        <option value="2">Nombre de tu mascota de la infancia</option>
                                        <option value="3">Segundo apellido de tu mamá</option>
                                        <option value="4">Apodo de la infancia</option>
                                        <option value="5">Cuál es tu pasatiempo favorito</option>
                                        <option value="6">Programa o serie de televisión favorito</option>
                                        <option value="7">Cuál era la caricatura que más te gustaba en la infancia</option>
                                        <option value="8">Algo que odies</option>
                                    </select>
                                    <input class="form-control mt-3" type="text" name="respuesta3" placeholder="Respuesta a la pregunta de Seguridad" required>
                                    
                                    <div class="text-center"><input type="submit" class="btn btn-primary my-3" value="Registrar Usuario"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script src="<?php echo Url::to('assets/js/usuarios/registrarUsuario.js'); ?>"></script>
</body>

</html>