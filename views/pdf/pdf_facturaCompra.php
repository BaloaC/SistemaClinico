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

        #title{
            font-size: x-large;
        }
        .cuadro {
            display: flex;
            flex-direction: column;
        }

        .cuadro th, .insumo td{
            outline: 1px solid black;
            padding: 0.5rem;
            text-align: start;
        }

        .tabla {
            width: 950px;
            padding: 2rem;
        }

        .text-center, .insumos-head>th{
            text-align: center !important; 
        }


        /* Tabla */

        .insumo>td {
            text-align: center;
            
        }

        /* Estilos para la firma y sello */

        .firma {
            margin-top: 50px;
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
                    <th colspan="4" class="text-center" id="title">Recibo de Compra</th>
                </tr>
                <tr class="insumos-head">
                    <th colspan="2">Nombre del proveedor: <span id="proveedor">EMPRESAS TE QUIERO MUCHO C.A</span></th>
                    <th colspan="2">Recibo de Compra ID: <span id="factura_id">13</spani></th>
                </tr>
                <tr class="insumos-head">
                    <th colspan="2">Monto total sin iva: <span id="monto_sin_iva">1111.23</span></th>
                    <th colspan="2">Fecha de compra: <span id="fecha_compra">2022-08-30</span></th>
                </tr>
                <tr class="insumos-head">
                    <th colspan="2">Monto total con iva: <span id="monto_con_iva">32323.12</span></th>
                    <th colspan="2">Excento: <span id="excento">222.32</span></th>
                </tr>
                <tr>
                    <th colspan="4" class="text-center">Insumos comprados</th>
                </tr>
                <tr class="insumos-head">
                    <th>Nombre insumo</th>
                    <th>Unidades adquiridas</th>
                    <th>Precio unitario</th>
                    <th>Precio total</th>
                </tr>
            </thead>
            <tbody id="insumosAdquridos">
            </tbody>
        </table>

        <div class="firma">
            <div class="col">
                <p>_____________________________________</p>
                <p>Firma y sello de Gerente</p>
            </div>
            <div class="col">
                <p>_____________________________________</p>
                <p>Firma y sello de Contador</p>
            </div>
        </div>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfFacturaCompra.js'); ?>"></script>
    <script>
        window.onafterprint = function () {
            window.close();
        }
    </script>
</body>

</html>