<?php

class EspecialidadValidaciones {

    public static function validacionesGenerales($formulario) {

        $camposString = array("nombre");
        $validarEspecialidad = new Validate;

        if ( $validarEspecialidad->isEmpty($_POST) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarEspecialidad->isString($_POST, $camposString) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarEspecialidad->isDuplicated('especialidad', 'nombre', $_POST["nombre"]) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarExistenciaEspecialidad($especialidad_id) {
        $validarEspecialidad = new Validate;

        if ( !$validarEspecialidad->isDuplicated("especialidad", "especialidad_id", $especialidad_id) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(200);
            exit();
        }
    }
}