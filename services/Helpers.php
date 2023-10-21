<?php

class Helpers {

    public static function retornarMensaje($bool, $data) {
        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json($bool ? 200: 400);
        exit();
    }
}