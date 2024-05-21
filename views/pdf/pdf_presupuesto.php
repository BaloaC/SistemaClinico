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
    </style>
</head>

<body>
    <header>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
        <p><b>CENTRO MEDICO HIPERBARICO Y DE REHABILITACION <br> SHENQUE C.A <br> CALLE PRONLONGACION MIRANDA 3-05
                SEC.PUNTO FRESCO <br> CAGUA EDO ARAGUA</b></p>
    </header>
    <table>
        <tr>
            <th>Paciente</th>
            <td colspan="3">ADRIANA VALENTINA CHOQUE RODRÍGUEZ</td>
        </tr>
        <tr>
            <th>C.I.</th>
            <td colspan="3">31.948.300</td>
        </tr>
        <tr>
            <th>Titular</th>
            <td colspan="3">GERMAN REGULO CHOQUE ESCUDERO</td>
        </tr>
        <tr>
            <th>Cédula</th>
            <td colspan="3">20.781.113</td>
        </tr>
        <tr>
            <th>Empresa</th>
            <td colspan="3">SENIAT</td>
        </tr>
        <tr>
            <th>Procesador</th>
            <td colspan="3">ANGELA HERNANDEZ</td>
        </tr>
        <tr>
            <th>Seguro</th>
            <td colspan="3">SENIAT</td>
        </tr>
        <tr>
            <th>DXM</th>
            <td colspan="3"></td>
        </tr>

        <tr>
            <th>Código</th>
            <th colspan="3">Descripción</th>
            <th colspan="2">Monto $</th>
        </tr>
        <tr>
            <td>LAB-00565</td>
            <td colspan="3">CREATININA</td>
            <td>8</td>
            <td>296</td>
        </tr>
        <tr>
            <td>CON-0039</td>
            <td colspan="3">CONSULTA PEDIATRIA</td>
            <td>60</td>
            <td>2.220</td>
        </tr>
        <tr>
            <td>LAB-00869</td>
            <td colspan="3">GLICEMIA</td>
            <td>8</td>
            <td>296</td>
        </tr>
        <tr>
            <td>LAB-00911</td>
            <td colspan="3">HEMATOLOGIA + PLAQUETAS ©</td>
            <td>15</td>
            <td>555</td>
        </tr>
        <tr>
            <td>LAB-01200</td>
            <td colspan="3">TRANSAMINASAS TGO</td>
            <td>8</td>
            <td>296</td>
        </tr>
        <tr>
            <td>LAB-C1201</td>
            <td colspan="3">TRANSAMINASAS TGP</td>
            <td>8</td>
            <td>296</td>
        </tr>
        <tr>
            <td>LAB-01211</td>
            <td colspan="3">UREA</td>
            <td>8</td>
            <td>296</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">MACROGOTERO</td>
            <td>2</td>
            <td>74,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">SOLUCIÓN RINGER</td>
            <td>8</td>
            <td>296,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">KETOPROFENO</td>
            <td>6</td>
            <td>222,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">OMEPRAZOL AMP</td>
            <td>2</td>
            <td>74,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">ONDANSETRON AMP</td>
            <td>4</td>
            <td>148,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">JELCO 22</td>
            <td>3,5</td>
            <td>129,50</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">OBTURADOR</td>
            <td>2</td>
            <td>74,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">SERVICIO DE ENFERMERÍA</td>
            <td>30</td>
            <td>1.110,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">ÁREA DE OBSERVACIÓN</td>
            <td>20</td>
            <td>740,00</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="3">Totales Bs.</td>
            <td>192,50</td>
            <td>7.122,50</td>
        </tr>
    </table>
</body>

</html>