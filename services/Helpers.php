<?php

class Helpers {

    public static function retornarGet($draw, $recordsTotal, $data) {
        $respuesta = new Response(!is_null($data) ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);

        if (!is_null($data)) {
            $respuesta->setRecords([$draw, $recordsTotal]);
        }

        echo $respuesta->json(!is_null($data) ? 200: 400);
        exit();
    }

    public static function retornarMensaje($bool, $data) {
        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json($bool ? 200: 400);
        exit();
    }

    public static function retornarMensajeActualizacion($isTrue, $data) {
        $respuesta = new Response($isTrue ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($data);
        echo $respuesta->json($isTrue ? 200: 400);
        exit();
    }

    public static function retornarMensajeListado($data) {
        $respuesta = new Response($data ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json($data ? 200: 400);
        exit();
    }
}