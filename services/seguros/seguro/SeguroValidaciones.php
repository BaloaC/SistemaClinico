<?php

class SeguroValidaciones {

    public static function validacionesGenerales($formulario) {

        $camposNumericos = array("telefono", "costo_especialidad");
        $validarSeguro = new Validate;

        if ($validarSeguro->isEmpty($formulario)) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarSeguro->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarNombre($nombre_seguro) {
        $validarSeguro = new Validate;

        if ( $validarSeguro->isDuplicated('seguro', 'nombre', $nombre_seguro) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarRif($rif_seguro) {
        $validarSeguro = new Validate;

        if ( $validarSeguro->isDuplicated('seguro', 'rif', $rif_seguro) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarSeguroExamenes($formulario) {

        if ( count($formulario['examenes']) != count($formulario['costos']) ) {
            $respuesta = new Response(false, 'Todos los exámenes deben tener un precio indicado');
            echo $respuesta->json(400);
            exit();
        }

        if ( count($formulario['examenes']) != count( array_unique(($formulario['examenes'])) ) ) {
            $respuesta = new Response(false, 'No pueden existir exámenes repetidos');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarExistenciaExamen($formulario) {
        $validarSeguro = new Validate;
        $limite = count($formulario['examenes']);

        for ($i = 0; $i < $limite; $i++) { 
            if ( !$validarSeguro->isDuplicatedId('examen_id', 'hecho_aqui', $formulario['examenes'][$i], 1, 'examen') ) {
                $respuesta = new Response(false, 'El examen no existe o no se realiza en la clínica');
                $respuesta->setData('Error relacionando el examen_id '.$formulario['examenes'][$i]);
                echo $respuesta->json(400);
                exit();

            } else if ($formulario['costos'][$i] <= 0) {
                $respuesta = new Response(false, 'El monto del examen es obligatorio');
                $respuesta->setData('Error con el examen id '.$formulario['examenes'][$i].' asociandolo al monto '.$formulario['costos'][$i]);
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarExistenciaSeguro($seguro_id) {
        
        $validarSeguro = new Validate();
        
        if ( !$validarSeguro->isDuplicated('seguro', 'seguro_id', $seguro_id) ) {
            $respuesta = new Response(false, 'El seguro indicado no existe');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarUltimoExamenSeguro($examenes) {
        if ( count($examenes) == 1 ) {
            $respuesta = new Response(false, 'No está permitido dejar un seguro sin exámenes asociados');
            echo $respuesta->json(400);
            exit();
        }
    }
}
