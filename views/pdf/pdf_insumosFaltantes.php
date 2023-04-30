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
            outline: 1px solid black;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla {
            width: 950px;
            padding: 2rem;
        }

        #title {
            text-align: center;
        }


        /* Tabla */

        .insumos-head>th {
            text-align: center;
        }

        .insumo>td {
            text-align: center;
            border-top: 1px solid;
            border-bottom: 1px solid;
        }

        /* Estilos para la firma y sello */

        .firma {
            margin-top: 50px;
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
            <thead>
                <tr>
                    <th colspan="2" id="title">Insumos por agotarse</th>
                </tr>
                <tr class="insumos-head">
                    <th>Nombre del insumo</th>
                    <th>Cantidad actual</th>
                </tr>
            </thead>
            <tbody>
                <tr style="height: 15px"></tr>
            </tbody>
        </table>

        <div class="firma">
            <p>_____________________________________</p>
            <p>Firma y sello de contador</p>
        </div>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfInsumosFaltantes.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>