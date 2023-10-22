<?php

class PacienteValidaciones {

    public static function validacionesGenerales($formulario) {

        $camposNumericos = array("cedula", "edad", "telefono", "tipo_paciente");
        $camposString = array("nombre", "apellidos");
        $validarPaciente = new Validate;

        if ( ($validarPaciente->isEmpty($formulario)) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isString($formulario, $camposString) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarNuevoPaciente($formulario) {
        
        $validarPaciente = new Validate;
        
        if ( $validarPaciente->isDate($formulario['fecha_nacimiento']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isToday($formulario['fecha_nacimiento'], false) ) {
            $respuesta = new Response(false, 'La fecha de nacimiento no puede ser posterior al dia de hoy');
            $respuesta->setData($formulario['fecha_nacimiento']);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarPacienteActualizado($formulario, $paciente_id) {
        
        $validarPaciente = new Validate;

        if ( array_key_exists('fecha_nacimiento', $formulario) ) {

            if ( $validarPaciente->isDate($formulario['fecha_nacimiento']) ) {
                $respuesta = new Response('DATOS_INVALIDOS');
                $respuesta->setData($formulario['fecha_nacimiento']);
                echo $respuesta->json(400);
                exit();
            }
            
            if ( $validarPaciente->isToday($formulario['fecha_nacimiento'], false) ) {
                $respuesta = new Response('DATOS_INVALIDOS');
                $respuesta->setData($formulario['fecha_nacimiento']);
                echo $respuesta->json(400);
                exit();
            }   

        }

        if ( !array_key_exists('tipo_paciente', $formulario) && array_key_exists('cedula', $formulario)) {

            // Primero verificamos si el paciente es tipo beneficiado
            $_pacienteModel = new PacienteModel();
            $paciente = $_pacienteModel->where('paciente_id', '=', $paciente_id);
            $isRepeated = $_pacienteModel->where('cedula', '=', $formulario['cedula']);

            // Ahora validamos que la cédula no se repita
            if ($paciente->tipo_paciente != 4 && $isRepeated) {
                $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
                $respuesta->setData("Problema al insertar el paciente con la cédula ".$formulario['cedula']);
                echo $respuesta->json(400);
                exit();
            }
        }

        if ( array_key_exists('tipo_paciente', $formulario) && array_key_exists('cedula', $formulario) && $formulario['tipo_paciente'] != 4 ) {
            
            $_pacienteModel = new PacienteModel();
            $isRepeated = $_pacienteModel->where('cedula', '=', $formulario['cedula']);

            if ($isRepeated) {
                $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
                $respuesta->setData("Problema al insertar el paciente con la cédula ".$formulario['cedula']);
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarPacienteId($paciente_id) {
        $validarPaciente = new Validate;

        if ( !$validarPaciente->isDuplicated('paciente', 'paciente_id', $paciente_id) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarPacienteSeguro($formulario) {
        $validarPaciente = new Validate;
        $camposNumericos = array("cobertura_general", "saldo_disponible");
        $campoId1 = array("seguro_id", "empresa_id","paciente_id");

        if ( array_key_exists('seguro', $formulario) ) {
            foreach ($formulario['seguro'] as $seguro) {
                if ( !$validarPaciente->isDuplicated('seguro', 'seguro_id', $seguro['seguro_id']) ) {

                    $respuesta = new Response(false, 'No se encontraron resultados del seguro indicado');
                    $respuesta->setData("Problema con el seguro ".$seguro['seguro_id']);
                    echo $respuesta->json(400);
                    exit();
                }

                if ( ($validarPaciente->isEmpty($seguro)) ) {
                    $respuesta = new Response(false, 'Los datos del seguro están vacíos');
                    echo $respuesta->json(400);
                    exit();
                }

                if ( $validarPaciente->isNumber($seguro, $camposNumericos) ) {
                    $respuesta = new Response(false, 'Los datos del seguro son inválidos');
                    echo $respuesta->json(400);
                    exit();
                }

                if ( $validarPaciente->isDate($seguro['fecha_contra']) ) {
                    $respuesta = new Response(false, 'La fecha indicada en el registro del seguro es inválida');
                    echo $respuesta->json(400);
                    exit();
                }

                if ( !$validarPaciente->isToday($seguro['fecha_contra'], true) ) {
                    $respuesta = new Response(false, 'La fecha indicada en el registro del seguro es inválida');
                    echo $respuesta->json(400);
                    exit();
                }

                if ( !$validarPaciente->isDuplicatedId('empresa_id', 'seguro_id', $seguro['empresa_id'], $seguro['seguro_id'], 'seguro_empresa') ) {
                    $respuesta = new Response(false, 'La empresa no se encuentra asociada al seguro indicado');
                    echo $respuesta->json(400);
                    exit();
                }

                if ( $validarPaciente->isDuplicatedId('paciente_id', 'seguro_id', $seguro['paciente_id'], $seguro['seguro_id'], 'paciente_seguro') ) {
                    $respuesta = new Response(false, 'Ya existe un registro con la misma información de seguro y paciente');
                    echo $respuesta->json(400);
                    exit();
                }
            }
        }
    }

    public static function validarPacienteBeneficiado($formulario) {
        $camposNumericos = array("tipo_relacion");
        $validarPacienteBeneficiado = new Validate;

        foreach ($formulario as $titular) {
            if ( ($validarPacienteBeneficiado->isEmpty($titular)) ) {
                $respuesta = new Response(false, 'Los datos del seguro están vacíos');
                $respuesta->setData(($titular));
                echo $respuesta->json(400);
                exit();
            }
    
            if ( $validarPacienteBeneficiado->isNumber($titular, $camposNumericos) ) {
                $respuesta = new Response(false, 'Los datos del seguro son inválidos');
                $respuesta->setData($titular['tipo_relacion']);
                echo $respuesta->json(400);
                exit();
            }
        
            if ( $formulario['tipo_relacion'] > 3 ) {
                $respuesta = new Response(false, 'Tipo de relación inválida');
                $respuesta->setData($titular['tipo_relacion']);
                echo $respuesta->json(400);
                exit();
            }

            $_pacienteModel = new PacienteModel();
            $paciente_titular = $_pacienteModel->where('paciente_id', '=', $titular['paciente_id'])->getFirst();

            if ( is_null($paciente_titular)|| $paciente_titular == 0 || $paciente_titular->tipo_paciente == 1 || $paciente_titular->tipo_paciente == 4 ) {
                
                $respuesta = new Response(false, 'El paciente indicado no existe o no está registrado como un titular');
                $respuesta->setData($titular['paciente_id']);
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}