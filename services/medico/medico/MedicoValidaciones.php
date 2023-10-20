<?php

class MedicoValidaciones {

    public static function validacionesGenerales($formulario) {
        $camposNumericos = array("cedula", "telefono", "paciente_id");
        $camposString = array("nombres", "apellidos");
        $validarMedico = new Validate;

        if ( ($validarMedico->isEmpty($formulario)) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarMedico->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarMedico->isString($formulario, $camposString) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarCedula($formulario) {
        $validarMedico = new Validate;

        if ( $validarMedico->isDuplicated('medico', 'cedula', $formulario["cedula"]) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarRegistro($formulario) {
        
    }

    public static function validarMedicoEspecialidad($especialidades) {

        $validarMedicoEspecialidad = new Validate();
        foreach ($especialidades as $especialidad) {
            
            if ( !$validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $especialidad['especialidad_id']) ) {
                $respuesta = new Response(false, 'No se consiguieron registros de la especialidad indicada');
                $respuesta->setData('Problemas con la especialidad id '.$especialidad['especialidad_id']);
                echo $respuesta->json(400);
                exit();
            }
            
            if ( !is_numeric($especialidad['costo_especialidad']) ) {
                $respuesta = new Response(false, 'El costo de la especialidad es inválida');
                echo $respuesta->json(400);
                exit();
            }
            
            if ( $validarMedicoEspecialidad->isEmpty($especialidad) ) {
                $respuesta = new Response(false, 'Los datos de especialidad están vacíos');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarDuplicadoMedicoEspecialidad($especialidad) {

        $validarMedicoEspecialidad = new Validate();
        
        if ( $validarMedicoEspecialidad->isDuplicatedId('medico_id', 'especialidad_id', $especialidad['medico_id'], $especialidad['especialidad_id'], 'medico_especialidad') ) {
            $respuesta = new Response(false, 'Ya existe un registro con el médico y la especialidad');
            $respuesta->setData($especialidad);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarHorario($horarios) {

        $camposString = array("dias_semana");
        $validarHorario = new Validate;

        foreach ($horarios as $horario) {
            
            if ( ($validarHorario->isEmpty($horario)) ) {
                $respuesta = new Response(false, 'Los datos de los horarios no pueden enviarse vacíos');
                echo $respuesta->json(400);
                exit();
            }

            if ( $validarHorario->isString($horario, $camposString) ) {
                $respuesta = new Response(false, 'Formato de los días de la semana inválidos');
                echo $respuesta->json(400);
                exit();
            }

            if ( $validarHorario->isDate($horario['hora_entrada'], "H:i") ) {
                $respuesta = new Response('HORA_INVALIDA');
                $respuesta->setData('Error en la hora de entrada '.$horario['hora_entrada']);
                echo $respuesta->json(400);
                exit();
            }

            if ( $validarHorario->isDate($horario['hora_salida'], 'H:i') ) {
                $respuesta = new Response('HORA_INVALIDA');
                $respuesta->setData('Error en la hora de entrada '.$horario['hora_salida']);
                echo $respuesta->json(400);
                exit();
            }

            if ( $horario['hora_entrada'] >= $horario['hora_salida'] ) {
                $respuesta = new Response(false, 'La hora de entrada no puede ser después de la hora de salida');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarMedicoHorario($horario) {

        $validarHorario = new Validate();

        if ( $validarHorario->isDuplicatedId('medico_id', 'dias_semana', $horario['medico_id'], $horario['dias_semana'], 'horario') ) {
            $respuesta = new Response(false, 'El horario ya se encuentra registrado'); 
            $respuesta->setData($horario);
            echo $respuesta->json(400);
            exit();
        }
    }
}