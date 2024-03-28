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
            /* padding: 20px; */
            /* text-align: center; */
            display: flex;
            justify-content: space-between;
            align-items: end;
        }

        header img {
            text-align: end;
        }


        header h1 {
            margin: 0;
        }

        h3,
        header p {
            text-align: center;
        }

        header p {
            margin: 0;
            font-size: 18px;
            text-align: left;
            /* line-height: 2.5; */
            font-weight: bolder;
            margin-left: 0.25rem;
        }

        /* Estilos para el cuerpo */
        body {
            font-family: Arial, sans-serif;
            font-size: 16px;
            line-height: 1.5;
            margin: 0;
            /* padding: 2rem; */
            margin: 2rem;
            background-color: #fff;
            border: 2px solid #000;
        }

        /* Estilos para la sección del titulo*/

        .cuadro {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .cuadro p {
            /* text-align: center; */
        }

        .cuadro th {
            outline: 1px solid black;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla {
            width: 100%;
            /* width: 750px; */
            /* padding: 1rem 2rem; */
        }

        .tabla>table {
            width: 100%;
        }

        #title {
            text-align: center;
            font-size: x-large;
        }

        #footer {
            height: 100px;
            text-align: start;
            display: flex;
        }

        /* Estilos para la firma y sello */

        .firma {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .row {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            font-weight: bolder;
            display: flex;
            justify-content: space-around;
        }

        .row.end {
            justify-content: start;
        }

        .row p {
            margin: 0;
            padding: 0;
        }
        
        .tabla tr th{
            text-align: start;
        }

        .underline{
            border-bottom: 3px solid #000000;
        }

        .gray-color {
            background-color: #d2d2d2;
        }
    </style>
</head>

<body>
    <header>
        <p>SHENQUE C.A <br> J 29656003-0 <br> AUTORIZADO DE INGRESO</p>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
    </header>
    <div class="row">
        <p>AUTORIZADO: <span id="clave">3232</span></p>
        <p>Fecha Ingreso: <span id="fechaIngreso">2022-03-01</span></p>
    </div>
    <div class="row gray-color">
        <p>&emsp13;</p>
    </div>
    <div class="tabla">
        <table>
            <thead>
                <tr>
                    <th colspan="1">Paciente:</th>
                    <th colspan="2" class="underline" id="nombrePaciente">Maria del carmen gonzalez</th>
                </tr>
                <tr>
                    <th colspan="1">C.I:</th>
                    <th colspan="2" class=""><span class="underline gray-color" id="cedulaPaciente">29527505</span> Fec.Nac: <span class="underline" id="fechaNacimiento">2001-01-28</span></th>
                </tr>
                <tr>
                    <th colspan="1">Dirección:</th>
                    <th colspan="2" class="underline" id="direccion">Cagua estado Aragua</th>
                </tr>
                <tr>
                    <th colspan="1">Teléfono:</th>
                    <th colspan="2" class="underline" id="telefono">0412-2941454</th>
                </tr>
                <tr>
                    <th colspan="1">Seguro:</th>
                    <th colspan="2" class="underline" id="seguro"></th>
                </tr>
                <tr>
                    <th colspan="1">Especialidad:</th>
                    <th colspan="2" class="underline" id="especialidad">Gastroenterologia</th>
                </tr>
                <tr>
                    <th colspan="1">Medico Tratante:</th>
                    <th colspan="2" class="underline" id="nombreMedico">Enrique Chacón</th>
                </tr>
                <tr>
                    <th colspan="1">DXM:</th>
                    <th colspan="2" class="underline">0</th>
                </tr>
                <tr>
                    <th colspan="1">
                        <p>&emsp13;</p>
                    </th>
                </tr>
                <tr>
                    <th colspan="2">&emsp13;</th>
                    <th colspan="1">_____________________________________</th>
                </tr>
                <tr>
                    <th colspan="1">&emsp13;</th>
                    <th colspan="2">Firma del Médico Tratante</th>
                </tr>
                <tr>
                    <th colspan="1">
                        <p>&emsp13;</p>
                    </th>
                </tr>
                <tr>
                    <th colspan="1">Titular:</th>
                    <th colspan="3"><span style="margin-right: 1rem" class="underline" id="nombreTitular">Maria del carmen gonzalez </span> Cédula: <span id="cedulaTitular">29527505</span></th>
                </tr>
                <tr>
                    <th colspan="1">Empresa:</th>
                    <th colspan="2" class="underline" id="nombreEmpresa">X</th>
                </tr>
                <tr>
                    <th colspan="1">
                        <p>&emsp13;</p>
                    </th>
                </tr>
                <tr>
                    <th colspan="1">OBSERVACIONES:</th>
                    <th colspan="2" class="underline" id="observaciones">Sin observaciones.</th>
                </tr>
                <tr>
                    <th colspan="1">
                        <p>&emsp13;</p>
                    </th>
                </tr>
                <tr>
                    <th colspan="3">
                        <p>&emsp13;</p>
                    </th>
                    <th colspan="1">SELLO</p>
                    </th>
                </tr>
                <!-- <tr>
                    <th colspan="1"><p>&emsp13;</p></th>
                </tr> -->
                <tr>
                    <th colspan="1">Paciente:</th>
                    <th colspan="3"><span style="margin-right: 0rem" id="nombrePaciente2">Maria del carmen gonzalez </span> Cuenta: <span id="cedulaPaciente2">29527505</span></th>
                    <th colspan="2"><span id="fechaNacimiento2">2001-01-28</span></th>
                </tr>
            </thead>
        </table>
    </div>
    <div class="row end">
        <p>Estudio: <span id="especialidad2">Gastroenterologia</span></p>
    </div>
    <!-- <div class="cuadro">
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
            <th id="footer">
                <p>Observaciones del paciente: <span id="observaciones"></span></p>
            </th>
        </tr>
    </table>

    <div class="firma">
        <p>_____________________________________</p>
        <p>Firma y sello de especialista</p>
    </div>
    </div> -->

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfConsultaSeguro.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>