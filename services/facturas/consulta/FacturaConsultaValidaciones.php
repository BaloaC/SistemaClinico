<?php

class FacturaConsultaValidaciones {

    public static function validacionesGenerales($formulario) {

        $validarFactura = new Validate;
        $camposNumericos = array('monto_consulta_usd');
        $camposId = array('consulta_id', 'paciente_id');

        if ($validarFactura->isEmpty($formulario)) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarFactura->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( !$validarFactura->existsInDB($formulario, $camposId) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(200);
            exit();
        }

        if ( $validarFactura->isEliminated('consulta', 'consulta_id', $formulario['consulta_id']) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(200);
            exit();
        }

        // if !$validarFactura->isDuplicatedId('paciente_id', 'consulta_id', $formulario['consulta_id'], $formulario['paciente_id'], 'consulta') {
        //     $respuesta = new Response(false, 'La consulta indicada no coincide con el paciente ingresado');
        //     echo $respuesta->json(400);
        //exit();
        // }

        if ( $validarFactura->isDuplicated('factura_consulta', 'consulta_id', $formulario['consulta_id']) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarSiEsAsegurada($consulta_id) {
        $_consultaPorCitaModel = new ConsultaCitaModel();
        $consulta = $_consultaPorCitaModel->where('consulta_id', '=', $consulta_id)->where('estatus_con', '=', 1)->getFirst();

        if (!is_null($consulta)) {
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', $consulta->cita_id)->getFirst();

            if ($cita->tipo_cita == 2) {
                $respuesta = new Response(false, 'Por este medio solo puedes insertar facturas de consultas naturales');
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}