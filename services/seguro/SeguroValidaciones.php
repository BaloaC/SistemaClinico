<?php

class SeguroValidaciones {

    public static function validarExistenciaSeguro($seguro_id) {
        
        $validarSeguro = new Validate();
        
        if ( !$validarSeguro->isDuplicated('seguro', 'seguro_id', $seguro_id) ) {
            $respuesta = new Response(false, 'El seguro indicado no existe');
            echo $respuesta->json(400);
            exit();
        }
    }
}
