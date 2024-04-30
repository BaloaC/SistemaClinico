<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
    <style>
        /* Estilos para el encabezado */
        header {
            /* background-color: #333;
            color: #fff; */
            padding: 20px;
            /* text-align: center; */
        }

        header img {
            text-align: start;
        }


        header h1 {
            margin: 0;
        }

        h3, header p {
            text-align: center;
        }

        header p {
            margin: 0;
            font-size: 18px;
            text-align: center;
            line-height: 2.5;
        }

        /* Estilos para el cuerpo */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            padding: 20px;
            background-color: #fff;
        }

        /* Estilos para la sección del titulo*/

        .title {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .title p {
            text-align: center;
        }

        .title th {
            outline: 1px solid black;
            padding: 0.5rem
        }

        /* Consultas */

        .consulta {
            border: 1px solid black;
            margin-bottom: 1rem;
        }

        .consulta p {
            margin-left: 1rem;
        }

        .consulta p:nth-child(2) {
            width: 90%;
            margin-left: 2rem;
        }
    </style>
</head>

<body>
    <header>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
        <p><b>CENTRO MEDICO HIPERBARICO Y DE REHABILITACION <br> SHENQUE C.A <br> CALLE PRONLONGACION MIRANDA 3-05
                SEC.PUNTO FRESCO <br> CAGUA EDO ARAGUA</b></p>
    </header>
    <div class="title">
        <p><b>Historial del paciente<b></p>
        <table>
            <thead>
                <th>Nombres: <span id="nombres">Cargando</span></th>
                <th>Apellidos: <span id="apellidos">Cargando</span></th>
                <th>Cédula de identidad: <span id="cedula">Cargando</span></th>
            </thead>
        </table>
    </div>
    <template id="consulta-template">
        <div class="consulta">
            <p>Consulta: N-<span id="consulta_id"></span></p>
            <p>Fecha: <span id="fecha"></span></p>
            <br>
            <br>
            <p>Especialitas a cargo: <span id="nombre_medico"></span></p>
            <p>Especialidad: <span id="especialidad"></p>
            <p>Exámenes: <span id="examen"></span></p>
            <p>Insumos utilizados: <span id="insumo"></span></p>
            <p>Observaciones: <span id="observaciones"></span></p>
        </div>
    </template>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfHistorialMedico.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>