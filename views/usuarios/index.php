<!DOCTYPE html>
<html lang="es">
<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <title>Proyecto 4 | Consultar Usuarios</title>
</head>
<body>
    <h1 class="h1">Consultar Usuarios</h1>

    <table>
        <thead>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
            <th>Editar</th>
            <th>Eliminar</th>
        </thead>
    </table>

    <script src="<?php echo Url::to('assets/js/usuarios/listarUsuarios.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>
</html>