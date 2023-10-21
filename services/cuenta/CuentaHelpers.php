<?php

include_once './services/cuenta/CuentaValidaciones.php';

class CuentaHelpers {

    public static function insertarPreguntaSeguridad($formularios, $usuario_id) {

        foreach ($formularios as $formulario) {
            
            CuentaValidaciones::validarPreguntaSeguridad($formulario, $usuario_id);
            $validarUsuario = new Validate;

            $formularioCompleto = $validarUsuario->dataScape($formulario);
            $formularioCompleto['usuario_id'] = $usuario_id;

            $_preguntaSeguridadModel = new PreguntaSeguridadModel();
            $actualizado = $_preguntaSeguridadModel->insert($formularioCompleto);
            $mensaje = ($actualizado > 0);

            if (!$mensaje) {

                $respuesta = new Response('INSERCION_FALLIDA');
                $respuesta->setData($formularioCompleto['pregunta']);
                echo $respuesta->json(200);
                exit();
            }
        }
    }
}