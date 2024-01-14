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

        .cuadro th {
            border: 1px solid black;
            border-left: none;
            border-right: none;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla {
            width: 950px;
            padding: 2rem;
        }

        #title {
            text-align: center;
            font-size: x-large;
        }


        /* Tabla */

        .insumos-head>th {
            text-align: center;

        }

        .insumos-head>th:nth-child(1){
            border-right: 1px solid;
        }

        .insumo>td {
            text-align: center;
            border-top: 1px solid;
            border-bottom: 1px solid;
        }

        /* Estilos para la firma y sello */

        .firma {
            /* margin-top: 50px; */
            margin-top: 5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            text-align: center;
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
            <thead>
                <tr>
                    <th colspan="2" id="title">Recibo de pago de consulta médica</th>
                </tr>
                <tr>
                    <th colspan="2" id="title">Recibo de pago correspondiente a la fecha de la consulta: <span id="fecha">2023-02-18</span></th>
                </tr>
                <tr class="insumos-head light">
                    <th>Nombre Paciente</th>
                    <th id="nombre_paciente">Enrique Chacón</th>
                </tr>
                <tr class="insumos-head">
                    <th>Cédula Paciente</th>
                    <th id="cedula_paciente">2</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Cédula titular</th>
                    <th id="cedula_titular">1</th>
                </tr>
                <tr class="insumos-head">
                    <th>Nombre médico</th>
                    <th id="nombre_medico">$30.21</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Especialidad</th>
                    <th id="especialidad">$20</th>
                </tr>
                <tr class="insumos-head">
                    <th>Método de pago</th>
                    <th id="metodo_pago"></th>
                </tr>
                <tr class="insumos-head light">
                    <th>Pago total en Bs</th>
                    <th id="pago_total_bs"></th>
                </tr>
                <tr class="insumos-head light">
                    <th>Pago total en Usd</th>
                    <th id="pago_total_usd"></th>
                </tr>
            </thead>
        </table>

        <div class="firma">
            <div class="col">
                <p>_____________________________________</p>
                <p>Firma y sello de Especialista</p>
            </div>
            <div class="col">
                <p>_____________________________________</p>
                <p>Firma y sello de Contador</p>
            </div>
        </div>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfFacturaConsulta.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>