<?php

class ConsultaValidaciones {

    /**
     * Validaciones para insertar consultas por emergencia
     */
    public static function validarConsultaEmergencia($formulario) {
        
        $camposId = array("consulta_id", "paciente_id", "seguro_id");
        $camposNumericos= array("cantidad_consultas_medicas", "consultas_medicas", "cantidad_laboratorios", "laboratorios", "cantidad_medicamentos", "medicamentos",	"area_observacion",	"enfermeria");
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
        
        // Validamos que el seguro esté asociado al titular
        $_pacienteSeguroModel = new PacienteSeguroModel();
        $pacienteSeguro = $_pacienteSeguroModel->where('paciente_id', '=', $formulario['paciente_id'])
                                                ->where('seguro_id', '=', $formulario['seguro_id'])
                                                ->getFirst();

        if (is_null($pacienteSeguro)) {
            $respuesta = new Response(false, 'El paciente titular indicado no está asociado a ese seguro');
            echo $respuesta->json(400);
            exit();
        }


        // Buscamos al paciente beneficiado para validar si tiene relación con el titular
        $_pacienteModel = new PacienteModel();
        $pacienteBeneficiado = $_pacienteModel->where('cedula', '=', $formulario['cedula_beneficiado'])->getFirst();
        
        if (is_null($pacienteBeneficiado)) {
            $respuesta = new Response(false, 'El paciente beneficiado indicado no existe');
            echo $respuesta->json(400);
            exit();
        }

        // Si la cedula es la del titular no validamos
        if ($pacienteBeneficiado->paciente_id != $formulario['paciente_id']) {
            
            $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();
            $beneficiado = $_pacienteBeneficiadoModel->where('paciente_id', '=', $pacienteBeneficiado->paciente_id)->getFirst();

            if (is_null($beneficiado)) {
                $respuesta = new Response(false, 'El paciente beneficiado indicado no tiene relación con el paciente titular');
                echo $respuesta->json(400);
                exit();
            }
            
            $_titularBeneficiado = new TitularBeneficiadoModel();
            $titular_beneficiado = $_titularBeneficiado->where('paciente_beneficiado_id', '=', $beneficiado->paciente_beneficiado_id)->getFirst();
            
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

        $total_medico = 0;
        foreach ($formulario['pagos'] as $medico) {
            if ( !$validarConsulta->isDuplicated('medico', 'medico_id', $medico['medico_id']) ) {
                $respuesta = new Response(false, 'El médico ingresado no ha sido encontrado');
                echo $respuesta->json(400);
                exit();
            }

            $total_medico += $medico['monto'];
        }

        $total_consulta = $formulario['consultas_medicas'] + $formulario['laboratorios'] + $formulario['medicamentos'] + $formulario['area_observacion'] + $formulario['enfermeria'] + $formulario['total_insumos'] + $formulario['total_examenes']; 
        
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