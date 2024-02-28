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

        h3, header p {
            text-align: center;
        }

        header p {
            margin: 0;
            font-size: 18px;
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

        #titulo {
            text-align: center;
            text-decoration: underline;
        }

        #fecha {
            margin-left: 5rem;
        }

        /* Estilos para la sección del titulo*/

        .paper {
            display: flex;
            justify-content: center;
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

        .tabla th, .tabla td,
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

        /* Imprimir en horizontal */
        @media print {
            @page {
                size: landscape;
            }
        }

    </style>
</head>

<body>
    <header>
        <img src="<?php echo Url::to('assets/img/logo.png'); ?>" alt="logo">
        <p><b>CENTRO MEDICO HIPERBARICO Y DE REHABILITACION <br> SHENQUE C.A <br> CALLE PRONLONGACION MIRANDA 3-05
                SEC.PUNTO FRESCO <br> CAGUA EDO ARAGUA</b></p>
    </header>
    <h3 id="titulo">FACTURA ENTREGADA A MENSAJERÍA Y RECEPCIONADA</h3>
    <h3>Seguro: <span id="seguro"></span> <span id="rif"></span> <span id="fecha"></span></h3>
    <div class="paper">
        <table class="tabla">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Nro. Factura</th>
                    <th>Fecha</th>
                    <th>Cédula Paciente</th>
                    <th>Cédula Titular</th>
                    <th>Paciente</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody id="consultas">
            </tbody>
        </table>
    </div>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfFacturaMensajeria.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>