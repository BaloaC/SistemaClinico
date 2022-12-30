<!DOCTYPE html>
<html lang="es">
<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <title>Proyecto 4 | Actualizar Usuario</title>
</head>
<body>
    <h1 class="h1">Actualizar Usuario</h1>

    <form action="" method="POST">
        
        <?php if(isset($idUsuario)): ?>

        <input type="hidden" name="idUsuario" id="idUsuario" value="<?php echo $idUsuario; ?>">

        <?php endif; ?>
        <input type="text" name="nombres">
        <input type="text" name="apellidos">
        <input type="text" name="correo">
        <button>Actualizar</button>
    </form> 


    <script src="<?php echo Url::to('assets/js/usuarios/actualizarUsuario.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>
</html>     