<!DOCTYPE html>
<html lang="es">

<head>
    <?php include constant('PATH_VIEWS') . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/seguro.css'); ?>">

    <title>Proyecto 4 | Welcome</title>
</head>

<body>
    <?php include constant('PATH_VIEWS') . '/partials/nav.php'; ?>

    <main>
        <div class="container">
            <!-- Cabezera -->
            <div class="row">
                <div class="col-6">
                    <h1 class="p-4 text-light">Gestion de Seguros</h1>
                </div>
                <div class="col-6 d-flex align-items-center justify-content-end">
                    <button class="btn btn-blue" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Añadir seguro</button>
                </div>
                <hr class="border-white">
            </div>
            <!-- Seguros -->
            <div class="row">
                <div class="col-12">
                    <ul class="list-seg">
                        <li><img src="<?php echo Url::to('assets/img/edificios.png') ?>" alt=""><a href="">Seguros Miranda</a></li>
                        <li><img src="<?php echo Url::to('assets/img/estadisticas.png') ?>"><a href="">Seguros Caracas</a></li>
                        <li><img src="<?php echo Url::to('assets/img/trabajo-en-equipo.png') ?>" alt=""><a href="">Seguros Vision</a></li>
                    </ul>
                </div>
                <div class="col-12">
                    <ul class="list-seg">
                        <li class="list-seg-item"><img src="<?php echo Url::to('assets/img/edificios (1).png') ?>"><a href="">Seguros Unidos</a></li>
                        <li class="list-seg-item"><img src="<?php echo Url::to('assets/img/piramides.png') ?>" alt=""><a href="">Seguros Piramides</a></li>
                        <li class="list-seg-item"><img src="<?php echo Url::to('assets/img/edificios (2).png') ?>" alt=""><a href="">Seguros Exterior</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Registrar Seguro</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="" id="info-seguro">
                            <label for="rif">Rif</label>
                            <input type="text" name="rif" class="form-control">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" class="form-control">
                            <label for="direccion">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                            <label for="telefono">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                            <label for="Porcentaje">Porcentaje</label>
                            <div class="input-group">
                                <span class="input-group-text">%</span>
                                <input type="text" class="form-control" aria-label="porcentaje" aria-describedby="porcentaje">
                            </div>
                            <label for="tipo-seguro">Tipo de Seguro</label>
                            <select name="tipo_seguro" class="form-control">
                                <option value="">Seleccione el tipo de seguro</option>
                                <option value="1">Titular</option>
                                <option value="2">Beneficiario</option>
                            </select>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="button" id="btn-registrar" class="btn btn-primary">Registrar Seguro</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script type="module" src="<?php echo Url::to('assets/js/login/validarSesion.js'); ?>"></script>
    <script type="module" src="<?php echo Url::to('assets/js/seguros/registrarSeguro.js'); ?>"></script>
    <script src="<?php echo Url::to('assets/libs/bootstrap/bootstrap.min.js'); ?>"></script>
    <?php include constant('PATH_VIEWS') . '/partials/footer.php'; ?>
</body>

</html>