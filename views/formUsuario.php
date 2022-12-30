<!DOCTYPE html>
<html lang="es">
<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <title>Proyecto 4 | Registrar Usuario</title>
</head>
<body>
    <h1 class="h1">Registrar Usuario</h1>

    <form action="/registrar" method="POST">

        <input type="text" name="nombres">
        <input type="text" name="apellidos">
        <input type="text" name="correo">
        <button>Registrar</button>
    </form> 


    <script src="<?php echo Url::to('assets/js/welcome/welcome.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/js/usuarios/registrarUsuario.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>
</html>