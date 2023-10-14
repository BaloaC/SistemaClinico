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
            position: absolute;
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

        .paper {
            display: flex;
            justify-content: space-between;
            /* margin-top: 2rem; */
        }

        .cuadro p {
            /* text-align: center; */
        }

        .cuadro th {
            outline: 1px solid black;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla th,
        .contacto {
            outline: 1px solid black;
            padding: 0.5rem;
        }

        .tabla {
            text-align: left;
        }

        .contacto {
            margin-top: 3rem;
            text-align: center;
        }

        /* Estilos para la firma y sello */

        .firma {
            margin-top: 10px;
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
    <div class="paper">
        <div class="col">
            <div class="info_cita">
                <p>Paciente: <span id="paciente"></span></p>
                <p>Cédula paciente: <span id="cedula_paciente"></span></p>
                <p>Cédula titular: <span id="cedula_titular"></span></p>
                <p>Tipo de cita: <span id="tipo_cita"></span></p>
            </div>
            <div class="contacto">
                <p>Número de comunicación</p>
                <br>
                <p>0412-4301761</p>
                <p>0412-4301761</p>
            </div>
        </div>
        <div class="col">
            <table class="tabla">
                <tr>
                    <th>Número de cita: <span id="cita_id"></span></th>
                </tr>
                <tr>
                    <th>Día de la Consulta <span id="fecha_cita"></span></th>
                </tr>
                <tr>
                    <th>Nombre del especialista: <span id="medico"></span></th>
                </tr>
                <tr>
                    <th>Especialidad: <span id="especialidad"></span></th>
                </tr>
            </table>
            <div class="firma">
                <p>_____________________________________</p>
                <p>Firma del titular</p>
            </div>
            <div class="firma">
                <p>_____________________________________</p>
                <p>Firma y sello del Centro Médico</p>
            </div>
        </div>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfCitas.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>