<?php

class ConsultaValidaciones {

    /**
     * Validaciones para insertar consultas por emergencia
     */
    public static function validarConsultaEmergencia($formulario) {
        
        $camposId = array("consulta_id", "paciente_id",	"paciente_beneficiado_id", "seguro_id");
        $camposNumericos= array("consultas_medicas",	"laboratorios",	"medicamentos",	"area_observacion",	"enfermeria");
        $validarConsulta = new Validate();
        
        if ( !$validarConsulta->existsInDB($_POST, $camposId) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();

        } else if ( $validarConsulta->isNumber($_POST, $camposNumericos) ) {
            $respuesta = new Response(false, 'Los siguientes campos deben ser numéricos: '.implode(', ', $camposNumericos));
            echo $respuesta->json(400);
            exit();
        }
        
        $_titularBeneficiado = new TitularBeneficiadoModel();
        $titular_beneficiado = $_titularBeneficiado->where('paciente_beneficiado_id', '=', $formulario['paciente_beneficiado_id'])->getFirst();
        
        if (is_null($titular_beneficiado)) {
            $respuesta = new Response(false, 'El paciente beneficiado indicado no existe');
            echo $respuesta->json(400);
            exit();
        
        } else if ( $titular_beneficiado->paciente_id != $formulario['paciente_id'] ) {
            $respuesta = new Response(false, 'El paciente titular indicado no tiene relación con el beneficiado');
            echo $respuesta->json(400);
            exit();
        }
    }


}