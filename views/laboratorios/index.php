<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/laboratorios.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <title>Proyecto 4 | Laboratorios</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <div class=""></div>
    <main class="main-home">
        <div class="container text-light">
            <div class="row">
                <h1 class="py-4 fs-7 mt-5">Exámenes de laboratorio</h1>
            </div>
            <div class="row abc-container">
                <div class="abc-elements">
                    <a class="a active-word" onclick="mostrarLaboratorios('a')">A</a>
                    -
                    <a class="b" onclick="mostrarLaboratorios('b')">B</a>
                    -
                    <a class="c" onclick="mostrarLaboratorios('c')">C</a>
                    -
                    <a class="d" onclick="mostrarLaboratorios('d')">D</a>
                    -
                    <a class="e" onclick="mostrarLaboratorios('e')">E</a>
                    -
                    <a class="f" onclick="mostrarLaboratorios('f')">F</a>
                    -
                    <a class="g" onclick="mostrarLaboratorios('g')">G</a>
                    -
                    <a class="h" onclick="mostrarLaboratorios('h')">H</a>
                    -
                    <a class="i" onclick="mostrarLaboratorios('i')">I</a>
                    -
                    <a class="j" onclick="mostrarLaboratorios('j')">J</a>
                    -
                    <a class="k" onclick="mostrarLaboratorios('k')">K</a>
                    -
                    <a class="l" onclick="mostrarLaboratorios('l')">L</a>
                    -
                    <a class="m" onclick="mostrarLaboratorios('m')">M</a>
                    -
                    <a class="n" onclick="mostrarLaboratorios('n')">N</a>
                    -
                    <a class="ñ" onclick="mostrarLaboratorios('ñ')">Ñ</a>
                    -
                    <a class="o" onclick="mostrarLaboratorios('o')">O</a>
                    -
                    <a class="p" onclick="mostrarLaboratorios('p')">P</a>
                    -
                    <a class="q" onclick="mostrarLaboratorios('q')">Q</a>
                    -
                    <a class="r" onclick="mostrarLaboratorios('r')">R</a>
                    -
                    <a class="s" onclick="mostrarLaboratorios('s')">S</a>
                    -
                    <a class="t" onclick="mostrarLaboratorios('t')">T</a>
                    -
                    <a class="u" onclick="mostrarLaboratorios('u')">U</a>
                    -
                    <a class="w" onclick="mostrarLaboratorios('w')">W</a>
                    -
                    <a class="x" onclick="mostrarLaboratorios('x')">X</a>
                    -
                    <a class="y" onclick="mostrarLaboratorios('y')">Y</a> 
                    -
                    <a class="z" onclick="mostrarLaboratorios('z')">Z</a>
                </div>
            </div>
            <div class="row examenes-list">
            </div>
        </div>
    </main>

    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/laboratorios/mostrarLaboratorios.js'); ?>"></script>


</body>

</html>