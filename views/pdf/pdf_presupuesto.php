<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documento PDF en HTML</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        header {
            /* background-color: #333;
            color: #fff; */
            padding: 20px;
            /* text-align: center; */
        }

        img[alt="logo"] {
            position: absolute;
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

        h3 {
            text-align: center;
            margin: 2rem auto;
        }
    </style>
</head>

<body>
    <header>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
        <p><b>CENTRO MEDICO HIPERBARICO Y DE REHABILITACION <br> SHENQUE C.A <br> CALLE PRONLONGACION MIRANDA 3-05
                SEC.PUNTO FRESCO <br> CAGUA EDO ARAGUA</b></p>
    </header>
    <h3>PRESUPUESTO CONSULTA</h3>
    <div>
        <table>
            <thead>
                <tr>
                    <th>Paciente</th>
                    <td colspan="3" id="nombrePaciente">Cargando</td>
                </tr>
                <tr>
                    <th>C.I.</th>
                    <td colspan="3" id="cedulaPaciente">Cargando</td>
                </tr>
                <tr>
                    <th>Edad</th>
                    <td colspan="3" id="edadPaciente">Cargando</td>
                </tr>
                <tr>
                    <th>Titular</th>
                    <td colspan="3" id="nombreTitular">Cargando</td>
                </tr>
                <tr>
                    <th>Cédula</th>
                    <td colspan="3" id="cedulaTitular">Cargando</td>
                </tr>
                <tr>
                    <th>Empresa</th>
                    <td colspan="3" id="empresaNombre">Cargando</td>
                </tr>
                <tr>
                    <th>Procesador</th>
                    <td colspan="3" id="procesadorPor">Cargando</td>
                </tr>
                <tr>
                    <th>Seguro</th>
                    <td colspan="3" id="seguroNombre">Cargando</td>
                </tr>
                <tr>
                    <th>DXM</th>
                    <td colspan="3">0</td>
                </tr>

                <tr>
                    <th>Código</th>
                    <th colspan="3">Descripción</th>
                    <th colspan="2">Monto $</th>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">EXÁMENES</td>
                    <td id="examenesUsd"></td>
                    <td id="examenesBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">INSUMOS</td>
                    <td id="insumoUsd">30</td>
                    <td id="insumoBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">LABORATORIO</td>
                    <td id="laboratorioUsd">30</td>
                    <td id="laboratorioBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">SERVICIO DE ENFERMERÍA</td>
                    <td id="enfermeriaUsd">30</td>
                    <td id="enfermeriaBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">ÁREA DE OBSERVACIÓN</td>
                    <td id="observacionUsd"></td>
                    <td id="observacionBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">CONSULTA</td>
                    <td id="consultaUsd"></td>
                    <td id="consultaBs"></td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="3">Totales Bs.</td>
                    <td id="totalUsd"></td>
                    <td id="totalBs"></td>
                </tr>
            </thead>
        </table>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfPresupuesto.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>