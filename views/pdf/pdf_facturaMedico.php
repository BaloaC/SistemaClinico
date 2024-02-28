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
            width: 800px;
            padding: 2rem;
        }

        #title {
            font-size: x-large;
        }
        /* Tabla */

        .insumos-head>th, #sub-title, #title {
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
            margin-top: 150px;
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
                    <th colspan="2" id="title">Recibo de pago al personal médico</th>
                </tr>
                <tr>
                    <th colspan="2" id="sub-title">Recibo de pago correspondiente a la fecha: <span id="fecha">2023-02-18</span></th>
                </tr>
                <tr>
                    <th colspan="2" id="sub-title">Fecha de emisión: <span id="fecha_emision">2023-02-18</span></th>
                </tr>
                <tr class="insumos-head light">
                    <th>Nombre</th>
                    <th id="nombre">Enrique Chacón</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Sumatoria Consultas Aseguradas</th>
                    <th id="sumatoria_consultas_aseguradas">0</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Sumatoria Consultas Naturales</th>
                    <th id="sumatoria_consultas_naturales">0</th>
                </tr>
                <tr class="insumos-head">
                    <th>Pacientes atendidos</th>
                    <th id="pacientes">2</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Pacientes atendidos por seguro</th>
                    <th id="pacientes_seguro">1</th>
                </tr>
                <tr class="insumos-head">
                    <th>Acumulado por consulta</th>
                    <th id="consultas">$30.21</th>
                </tr>
                <tr class="insumos-head light">
                    <th>Acumulado por consulta de seguros</th>
                    <th id="consultas_seguro">$20</th>
                </tr>
                <tr class="insumos-head">
                    <th>Pago total</th>
                    <th id="pago_total">$50.21</th>
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

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfFacturaMedico.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>