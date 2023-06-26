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

        .cuadro {
            display: flex;
            flex-direction: column;
        }

        .cuadro p {
            /* text-align: center; */
        }

        .cuadro th {
            outline: 1px solid black;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla{
            width: 950px;
            padding: 2rem;
        }

        #title {
            text-align: center;
            font-size: x-large;
        }

        #footer{
            height: 200px;
            text-align: start;
            display: flex;
        }

        /* Estilos para la firma y sello */

        .firma{
            margin-top: 175px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

</style>
</head>

<body>
    <header>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
        <p><b>CENTRO MEDICO HIPERBARICO Y DE REHABILITACION <br> SHENQUE C.A <br> CALLE PRONLONGACION MIRANDA 3-05
                SEC.PUNTO FRESCO <br> CAGUA EDO ARAGUA</b></p>
    </header>
    <div class="cuadro">
        <table class="tabla">
            <tr>
                <th id="title">Consulta Médica</th>
            </tr>
            <tr>
                <th>Número de consulta: <span id="consulta_id"></span></th>
            </tr>
            <tr>
                <th>Paciente: <span id="paciente"></span></th>
            </tr>
            <tr>
                <th>Cédula del paciente: <span id="cedula_paciente"></span></th>
            </tr>
            <tr>
                <th>Fecha de consulta: <span id="fecha"></span></th>
            </tr>
            <tr>
                <th>Especialista a cargo: <span id="medico"></span></th>
            </tr>
            <tr>
                <th>Especialidad: <span id="especialidad"></span></th>
            </tr>
            <tr>
                <th id="footer"> <p>Observaciones del paciente: <span id="observaciones"></span></p></th>
            </tr>
        </table>

        <div class="firma">
            <p>_____________________________________</p>
            <p>Firma y sello de especialista</p>
        </div>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfConsulta.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>