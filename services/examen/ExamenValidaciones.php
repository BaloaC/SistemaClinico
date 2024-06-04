<?php

class ExamenValidaciones {

    public static function validarExamen($formulario) {
        $exclude = array('precio_examen');
        $validarExamen = new Validate;
        
        if ( $validarExamen->isEmpty($formulario, $exclude) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }
            
        if ( ($validarExamen->isDuplicated('examen', 'nombre', $formulario['nombre'])) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }

        if (empty($formulario['precio_examen'])) {
            $respuesta = new Response(false, 'Los exámenes hechos en la clínica deben tener precio al momento de registrarlos');
            echo $respuesta->json(400);
            exit();
        }
        
        if ( !empty($formulario['precio_examen']) && !is_numeric($formulario['precio_examen']) ) {
            $respuesta = new Response(false, 'El campo precio_examen solo permite valores numéricos');
            echo $respuesta->json(400);
            exit();
        }

        if ($formulario['tipo'] > 4 || $formulario['tipo'] < 0) {
            $respuesta = new Response(false, 'El tipo ingresado no es válido');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function actualizarExamen($formulario) {
        $validarExamen = new Validate;

        if (array_key_exists('nombre', $formulario)) {
            if ( ($validarExamen->isDuplicated('examen', 'nombre', $formulario['nombre'])) ) {
                $respuesta = new Response('DATOS_DUPLICADOS');
                echo $respuesta->json(400);
                exit();
            }
        }

        if (array_key_exists('precio_examen', $formulario)) {
            if ( !empty($formulario['precio_examen']) && !is_numeric($formulario['precio_examen']) ) {
                $respuesta = new Response(false, 'El campo precio_examen solo permite valores numéricos');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarEspecialidad($especialidades) {
        $validarExamen = new Validate;

        foreach ($especialidades as $especialidad) {
            if ( !($validarExamen->isDuplicated('especialidad', 'especialidad_id', $especialidad['especialidad_id'])) ) {
                $respuesta = new Response(false, 'Las especialidades indicadas no se encuentran registradas en la base de datos');
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}