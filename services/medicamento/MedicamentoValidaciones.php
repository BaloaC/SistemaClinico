<?php

class MedicamentoValidaciones {

    public static function validacionesGenerales($formulario) {
        
        $camposNumericos = array("tipo_medicamento");
        $camposId = array("especialidad_id");
        $validarMedicamento = new Validate;
        
        if ( $validarMedicamento->isEmpty($formulario) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarMedicamento->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response(false, 'DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarEspecialidadId($especialidad_id) {
        $validarMedicamento = new Validate;

        if ( !$validarMedicamento->isDuplicated('especialidad', 'especialidad_id', $especialidad_id) ) {
            $respuesta = new Response(false, 'NOT_FOUND');
            $respuesta->setData($especialidad_id);
            echo $respuesta->json(400);
            exit();
        }
    }
}