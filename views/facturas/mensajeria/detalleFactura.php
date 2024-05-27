<!DOCTYPE html>
<html lang="es">

<head>
    <?php include PATH_VIEWS . '/partials/header.php'; ?>
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/paciente.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/datatables.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/css/custom-datatables.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.searchPanes.min.css'); ?>">
    <link rel="stylesheet" href="<?php echo Url::to('assets/libs/datatables/dataTables.select.min.css'); ?>">
    <title>Proyecto 4 | Recibos de Mensajería Consultas Detalle</title>
</head>

<body>

    <h5 class="loadingMessage">Cargando...</h5>

    <h5 class="mx-3 p-5 pb-1 text-grey consultaLabel" style="display: none">Consultas enviadas a mensajería</h5>
    <div class="accordion consulta-accordion p-5" id="consultaAccordion">

    </div>


    <template id="template-consulta">
        <div class="card">
            <div class="card-header">
                <h2 class="mb-0">
                    <a class="btn btn-link collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#consulta1" aria-expanded="false" aria-controls="consulta1">
                    </a>
                </h2>
            </div>
            <div id="consulta1" class="collapse show" data-parent="#consultaAccordion">
                <div class="card-body">
                    <p><b>Item:</b> <span id="consulta_id"></span> <br>
                        <b>Nombre médico:</b> <span id="nombre_medico"></span> <br>
                        <b>Especialidad:</b> <span id="especialidad"></span> <br>
                        <b>Fecha consulta:</b> <span id="fecha_consulta"></span> <br>
                        <b>Motivo cita:</b> <span id="motivo_cita"></span> <br>
                        <b>Indicaciones:</b> <span id="indicaciones"></span> <br>
                        <b>Observaciones:</b> <span id="observaciones"></span> <br>
                        <b>Monto total en USD:</b> <span id="monto_total_usd"></span> <br>
                        <b>Monto total en BS:</b> <span id="monto_total_bs"></span>
                    </p>
                </div>
            </div>
        </div>
    </template>

    <?php include PATH_VIEWS . '/partials/footer.php'; ?>
    <script type="module" src="<?php echo Url::to('assets\js\facturas-mensajeria\detalleFacturas.js'); ?>"></script>
</body>

</html>