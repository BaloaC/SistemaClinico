<?php

class ExamenValidaciones {

    public static function validarExamen($formulario) {
        $exclude = array('hecho_aqui', 'precio_examen');
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

        if ( $formulario['hecho_aqui'] != 1 && $formulario['hecho_aqui'] != 0 ) {
            $respuesta = new Response(false, 'El campo hecho aqui solo permite valores booleanos');
            echo $respuesta->json(400);
            exit();
        }

        if ($formulario['hecho_aqui'] == 1 && empty($formulario['precio_examen'])) {
            $respuesta = new Response(false, 'Los exámenes hechos en la clínica deben tener precio al momento de registrarlos');
            echo $respuesta->json(400);
            exit();
        }
        
        if ( !empty($formulario['precio_examen']) && !is_numeric($formulario['precio_examen']) ) {
            $respuesta = new Response(false, 'El campo precio_examen solo permite valores numéricos');
            echo $respuesta->json(400);
            exit();
        }
    }
}