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
            background-color: #222fb9;
            color: #f2f2f2;
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
                <th>Nombres: <span id="nombres">Enrique Miguel</span></th>
                <th>Apellidos: <span id="apellidos">Chacón Almerida</span></th>
                <th>Cédula de identidad: <span id="cedula">29527505</span></th>
            </thead>
        </table>
    </div>
    <template id="consulta-template">
        <div class="consulta">
            <p>Consulta: N-<span id="consulta_id">12</span></p>
            <p>Fecha: <span id="fecha">2022-03-12</span></p>
            <br>
            <br>
            <p>Especialitas a cargo: <span id="nombre_medico">Francis Mayini Baloa Coronado</span></p>
            <p>Especialidad: <span id="especialidad">Traumatología</p>
            <p>Exámenes: <span id="examen">No se realizó ningún exámen</span></p>
            <p>Insumos utilizados: <span id="insumo">No se realizó ningún exámen</span></p>
            <p>Observaciones: <span id="observaciones">El paciente manisfetó dolores musculares</span></p>
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