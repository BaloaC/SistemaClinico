<?php

class Helpers {

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
}