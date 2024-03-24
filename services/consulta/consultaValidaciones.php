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

        if( isset($formulario['pagos']) ) {
            foreach ($formulario['pagos'] as $medico) {
                if ( !$validarConsulta->isDuplicated('medico', 'medico_id', $medico['medico_id']) ) {
                    $respuesta = new Response(false, 'El médico ingresado no ha sido encontrado');
                    echo $respuesta->json(400);
                    exit();
                }

                $total_medico += $medico['monto'];
            }

            $total_consulta = $formulario['consultas_medicas'] + $formulario['laboratorios'] + $formulario['medicamentos'] + $formulario['area_observacion'] + $formulario['enfermeria'] + $formulario['total_insumos']; 
            
            if ( $total_medico > $total_consulta ) {
                $respuesta = new Response(false, 'El monto de los médicos no puede superar el de la consulta');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    /**
     * Validaciones de una Consulta Normal
     */
    public static function validarConsulta($formulario) {

        $validarConsulta = new Validate;
        $exclude = array("peso","altura","es_emergencia","observaciones");
        $campoId = array("paciente_id", "medico_id", "especialidad_id");
        
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

            // case $validarConsulta->isToday($formulario['fecha_consulta'], true):
            //     $respuesta = new Response('FECHA_INVALIDA');
            //     echo $respuesta->json(400);
            //     exit();
        }
    }

    /**
     * Validaciones de los insumos
     */
    public static function validarInsumos($insumos) {

        foreach ($insumos as $insumo) {

            $camposNumericos = array("insumo_id");
            $validarConsultaInsumo = new Validate;

            switch ($validarConsultaInsumo) {
                case ($validarConsultaInsumo->isEmpty($insumo)):
                    $respuesta = new Response(false, 'Los datos de los insumos están vacíos');
                    echo $respuesta->json(400);
                    exit();

                case $validarConsultaInsumo->isEliminated("insumo", 'estatus_ins', $insumo['insumo_id']):
                    $respuesta = new Response(false, 'El insumo indicado no ha sido encontrado en el sistema');
                    echo $respuesta->json(404);
                    exit();

                case !$validarConsultaInsumo->existsInDB($insumo, $camposNumericos):
                    $respuesta = new Response(false, 'No se encontraron resultados de los datos indicados en la base de datos');
                    echo $respuesta->json(404);
                    exit();

                default: 
                    $_insumoModel = new InsumoModel();
                    $insumoExistente = $_insumoModel->where('insumo_id', '=', $insumo['insumo_id'])->getFirst();
                    
                    if ($insumo['cantidad'] > $insumoExistente->cantidad) {
                        $respuesta = new Response(false, 'Cantidad de insumos mayor a la que hay en existencia');
                        $respuesta->setData('La cantidad disponible de insumos es de '.$insumoExistente->cantidad);
                        echo $respuesta->json(400);
                        exit();
                    }

            }
        }
    }

    /**
     * Validaciones de los insumos
     */
    public static function validarEsEmergencia($formulario) {

        if ( $formulario['es_emergencia'] != 0 && $formulario['es_emergencia'] != 1 ) {
            $respuesta = new Response(false, 'El atributo es_emergencia tiene que ser un booleano');
            echo $respuesta->json(400);
            exit();
        }
    }

    /**
     * Validación de la cita de la consulta
     */
    public static function validarEstatusCita($formulario) {
        $validarConsulta = new Validate;
        
        if ( !$validarConsulta->existsInDB($formulario, ['cita_id']) ) {
            $respuesta = new Response(false, 'La cita indicada no existe');
            $respuesta->setData('Ocurrió un problema con la cita_id '.$formulario['cita_id']);
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $formulario['cita_id'], 4, 'cita') ) {
            $respuesta = new Response(false, 'La cita indicada ya se encuentra asociada a una consulta');
            echo $respuesta->json(400);
            exit();
        } 
        
        if ( $validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $formulario['cita_id'], 3, 'cita') ) {
            $respuesta = new Response(false, 'Para realizar la consulta la cita debe tener su clave correspondiente');
            echo $respuesta->json(400);
            exit();
        }
    }

    /**
     * Validación de los exámenes en la consulta
     */
    public static function validarConsultaExamen($examenes) {
        $validarConsultaExamen= new Validate();
        $camposNumericos = array("examen_id", "consulta_id");

        foreach ($examenes as $examen) {
            
            if ($validarConsultaExamen->isEmpty($examen)) {
                $respuesta = new Response(false, 'Los datos de los exámenes están vacíos');
                echo $respuesta->json(400);
                exit();
            }
    
            if ( $validarConsultaExamen->isNumber($examen, $camposNumericos) ) {
                $respuesta = new Response(false, 'Los datos de los exámenes seguro son inválidos');
                echo $respuesta->json(400);
                exit();
            }
    
            if ( !$validarConsultaExamen->existsInDB($examen, $camposNumericos) ) {
                $respuesta = new Response(false, 'No se encontraron resultados de los datos indicados en la base de datos');         
                echo $respuesta->json(404);
                exit();
            }
        }
    }

    public static function validarDuplicadoConsultaExamen($examenes) {
        $validarConsultaExamen= new Validate();
        
        foreach ($examenes as $examen) {
            if ($validarConsultaExamen->isDuplicatedId('consulta_id', 'examen_id', $examen['consulta_id'], $examen['examen_id'], 'consulta_examen') ) {
                $respuesta = new Response(false, 'Ese examen ya está registrado en la consulta');
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}