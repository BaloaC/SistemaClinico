<?php

class CuentaValidaciones {

    public static function validarNuevoUsuario($formulario) {

        $camposNumericos = array("rol", "pin");
        $validarUsuario = new Validate;

        if ($validarUsuario->isEmpty($formulario)) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ($validarUsuario->isNumber($formulario, $camposNumericos)) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ($validarUsuario->isDuplicated('usuario', 'nombre', $formulario["nombre"])) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }

        if (strlen($formulario['pin']) < 6) {
            $respuesta = new Response(false, 'El pin debe ser mayor a 6 digitos');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarPreguntaSeguridad($formulario, $usuario_id) {
        $validarUsuario = new Validate;

        if ( $validarUsuario->isEmpty($formulario) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if (!$validarUsuario->isDuplicated("usuario", 'usuario_id', $usuario_id)) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(200);
            exit();
        }
    }
}