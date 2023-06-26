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

        .title {
            font-size: xx-large;
            display: flex;
            justify-content: center;
            border: 1px solid black;
            border-left-width: 0;
            border-right-width: 0;
        }

        /* Seguros */

        .seguros-container {
            display: flex;
            width: 900px;
            justify-content: center;
            flex-direction: column;
        }

        .seguro {
            display: flex;
            justify-content: space-between;
            padding: 1.5rem;
            margin: 1.5rem;
            border: 1px solid black;
        }

        .consulta {
            border: 1px solid black;
            margin-bottom: 1rem;
        }

        .consulta p {
            margin-left: 1rem;
        }

        .consulta p:nth-child(2) {
            width: 90%;
            margin-left: 2rem;
            background-color: #222fb9;
            color: #f2f2f2;
        }

        /* Footer */

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
    <div class="title">
        <p><b>Lista de seguros asociados<b></p>
    </div>

    <div class="seguros-container">

    </div>

    <div class="firma">
        <p>_____________________________________</p>
        <p>Firma y sello del contador</p>
    </div>

    <template id="seguro-template">
        <div class="seguro">
            <div class="col">
                <p>Nombre seguro: <span id="nombre"></span></p>
                <p>Rif: <span id="rif"></span></p>
            </div>
            <div class="col">
                <p>Teléfono: <span id="telefono"></span></p>
                <p>Dirección: <span id="direccion"></span></p>
            </div>
        </div>
    </template>

    <script type="module" src="<?php echo Url::to('assets/js/pdf/pdfSeguros.js'); ?>"></script>
    <script>
        window.onafterprint = function() {
            window.close();
        }
    </script>
</body>

</html>