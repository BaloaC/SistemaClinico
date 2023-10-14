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
            font-size: 13px;
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
            /* border: 1px solid black; */
            border-left: none;
            border-right: none;
            padding: 0.5rem;
            text-align: start;
        }

        .light{
            background-color: #222fb938 !important;
        }

        .dark{
            background-color: #222fb9 !important;
            color: #f2f2f2;
        }

        .tabla {
            /* width: 950px; */
            padding: 2rem;
        }

        #title, #recibo_id {
            text-align: right;
            font-size: 13px;
        }


        /* Tabla */

        .separator-section-top{
            border-top: 1px solid black;
        }

        .separator-section-bottom{
            border-bottom: 1px solid black;
        }

        .insumos-head>th {
            /* text-align: center; */

        }

        .insumos-head>th:nth-child(4){
            /* text-align: end; */
        }

        .insumo>td {
            /* text-align: center; */
            /* border-top: 1px solid; */
            /* border-bottom: 1px solid; */
        }

        /* Estilos para la firma y sello */

        .firma {
            /* margin-top: 50px; */
            margin-top: 300px;
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
                    <th colspan="3"></th>
                    <th colspan="1" id="title">Recibo: <span id="recibo_id"></span></th>
                </tr>
                <tr>
                    <th colspan="3" id="title"></th>
                    <th colspan="1" id="title">Fecha: <span id="fecha"></span></th>
                </tr>
                <tr>
                    <th colspan="4" class="separator-section-top">Razón Social: <span id="nombre_seguro"></span></th>
                </tr>
                <tr>
                    <th colspan="4">Rif: <span id="rif"></span></th>
                </tr>
                <tr>
                    <th colspan="4" class="separator-section-bottom">Dirección: <span id="direccion"></span></th>
                </tr>
                <tr><td><br></td></tr>
                <tr>
                    <th colspan="2" class="separator-section-bottom">Descripción:</th>
                    <th colspan="1" class="separator-section-bottom">Cantidad:</th>
                    <th colspan="1" class="separator-section-bottom">Total Bs. S:</th>
                </tr>

                <tr class="insumos-head">
                    <th>Insumos</th>
                    <th></th>
                    <th>-</th>
                    <th id="total_insumos">Enrique Chacón</th>
                </tr>
                <tr class="insumos-head">
                    <th>Exámenes</th>
                    <th></th>
                    <th>-</th>
                    <th id="total_examenes">2</th>
                </tr>
                <tr class="insumos-head">
                    <th>Laboratorio</th>
                    <th></th>
                    <th id="cant_laboratorio"></th>
                    <th id="total_laboratorio"></th>
                </tr>
                <tr class="insumos-head ">
                    <th>Area de observación</th>
                    <th></th>
                    <th>-</th>
                    <th id="area_observacion"></th>
                </tr>
                <tr class="insumos-head">
                    <th>Medicamentos</th>
                    <th></th>
                    <th id="cant_medicamentos"></th>
                    <th id="total_medicamentos"></th>
                </tr>
                <tr class="insumos-head">
                    <th>Enfermería</th>
                    <th></th>
                    <th>-</th>
                    <th id="enfermeria"></th>
                </tr>
                <tr class="insumos-head">
                    <th>Consultas</th>
                    <th></th>
                    <th id="cant_consultas"></th>
                    <th id="total_consultas"></th>
                </tr>
                <tr>
                    <th class="separator-section-top"></th>
                    <th class="separator-section-top"></th>
                    <th class="separator-section-top">Monto total:</th>
                    <th class="separator-section-top"><span id="monto_total_consulta"></span></th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfConsultaEmergencia.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>