<!DOCTYPE html>
<html lang="es">
<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <title>Proyecto 4 | Welcome</title>
</head>
<body>
    <h1 class="h1">Welcomeeee . <?php echo $welcome['Hi'] ?></h1>

    <table>
        <thead>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Correo</th>
        </thead>
        <tbody id="tbody-user">
        
        </tbody>
    </table>
    


    <script src="<?php echo Url::to('assets/js/welcome/welcome.js'); ?>"></script>
    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
</body>
</html>