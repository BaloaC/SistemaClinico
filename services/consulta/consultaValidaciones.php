<?php

class ConsultaValidaciones {

    /**
     * Validaciones para insertar consultas por emergencia
     */
    public static function validarConsultaEmergencia($formulario) {
        
        $camposId = array("consulta_id", "paciente_id",	"paciente_beneficiado_id", "seguro_id");
        $camposNumericos= array("consultas_medicas",	"laboratorios",	"medicamentos",	"area_observacion",	"enfermeria");
        $validarConsulta = new Validate();
        
        if ( !$validarConsulta->existsInDB($formulario, $camposId) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();

        } else if ( $validarConsulta->isNumber($formulario, $camposNumericos) ) {
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

        $total_medico = 0;
        foreach ($formulario['pagos'] as $medico) {
            if ( !$validarConsulta->isDuplicated('medico', 'medico_id', $medico['medico_id']) ) {
                $respuesta = new Response(false, 'El médico ingresado no ha sido encontrado');
                echo $respuesta->json(400);
                exit();
            }

            $total_medico += $medico['monto'];
        }

        $total_consulta = $formulario['consultas_medicas'] + $formulario['laboratorios'] + $formulario['medicamentos'] + $formulario['area_observacion'] + $formulario['enfermeria'];
        
        if ( $total_medico > $total_consulta ) {
            $respuesta = new Response(false, 'El monto de los médicos no puede superar el de la consulta');
            echo $respuesta->json(400);
            exit();
        }
    }

    /**
     * Validaciones de una Consulta Normal
     */
    public static function validarConsulta($formulario) {

        $validarConsulta = new Validate;
        $exclude = array("peso","altura","es_emergencia","observaciones");
        $campoId = array("paciente_id", "medico_id", "especialidad_id", "cita_id");

        switch ($validarConsulta) {
            case !$validarConsulta->existsInDB($formulario, $campoId):
                $respuesta = new Response('NOT_FOUND');
                echo $respuesta->json(404);
                exit();

            case ($validarConsulta->isEmpty($formulario, $exclude)):
                $respuesta = new Response('DATOS_VACIOS');
                echo $respuesta->json(400);
                exit();

            case $validarConsulta->isDate($formulario['fecha_consulta']):
                $respuesta = new Response('FECHA_INVALIDA');
                echo $respuesta->json(400);
                exit();

            case $validarConsulta->isToday($formulario['fecha_consulta'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                echo $respuesta->json(400);
                exit();
        }
    }
}