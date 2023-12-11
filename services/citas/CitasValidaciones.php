<?php

class CitasValidaciones {

    public static function validacionesGenerales($formulario) {

        $validarCita = new Validate;
        $camposString = array("motivo_cita");
        $campoId = array("paciente_id", "medico_id", "especialidad_id", "cita_id");
        $exclude = array("seguro_id");

        if ( $validarCita->isEmpty($formulario, $exclude) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( !$validarCita->existsInDB($formulario, $campoId) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(404);
            exit();
        }

        if ( $validarCita->isString($formulario, $camposString) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( !$validarCita->isDuplicatedId('especialidad_id', 'medico_id', $formulario['especialidad_id'], $formulario['medico_id'], 'medico_especialidad') ) {
            $respuesta = new Response(false, 'El médico no ejerce la especialidad seleccionada');
            echo $respuesta->json(404);
            exit();
        }

        if ( !$validarCita->isDuplicated('paciente', "cedula", $formulario['cedula_titular']) ) {
            $respuesta = new Response(false, 'Paciente titular no encontrado');
            echo $respuesta->json(404);
            exit();
        }

        if ( $formulario['hora_entrada'] >= $formulario['hora_salida']) {
            $respuesta = new Response(false, 'La hora de salida debe ser posteior de la hora de entrada');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarActualizacion($formulario, $cita_id) {
        $validarCita = new Validate;

        if ( $validarCita->isEmpty($formulario) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( !$validarCita->isDuplicatedId('cita_id', 'estatus_cit', $cita_id, 3, 'cita') ) {
            $respuesta = new Response(false, 'La cita seleccionada ya se encuentra asignada');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarCitaId($cita_id) {
        $validarCita = new Validate;
        
        if ( !$validarCita->isDuplicated('cita', 'cita_id', $cita_id) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarFecha($formulario) {
        $validarCita = new Validate;

        if ( $validarCita->isDate($formulario['fecha_cita']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarCita->isToday($formulario['fecha_cita'], true) ) {
            $respuesta = new Response('FECHA_POSTERIOR');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarCita->isDate($formulario['hora_entrada'], "H:i:s") ) {
            $respuesta = new Response('HORA_INVALIDA');
            $respuesta->setData('Error en la hora de entrada '.$formulario['hora_entrada']);
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarCita->isDate($formulario['hora_salida'], 'H:i:s') ) {
            $respuesta = new Response('HORA_INVALIDA');
            $respuesta->setData('Error en la hora de entrada '.$formulario['hora_salida']);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarDisponibilidad($cita) {
        // Validamos que no haya otra cita a esa hora
        $_citasDelDía = new CitaModel();
        $isDuplicated = $_citasDelDía->where('fecha_cita', '=', $cita['fecha_cita'])->where('hora_entrada', '>=', $cita['hora_entrada'])->where('hora_entrada', '<=', $cita['hora_salida'])->where('medico_id ', '=', $cita["medico_id"])
                ->orWhere('fecha_cita', '=', $cita['fecha_cita'])->where('hora_entrada', '<=', $cita['hora_entrada'])->where('hora_salida', '>=', $cita['hora_salida'])->where('medico_id ', '=', $cita["medico_id"])
                ->orWhere('fecha_cita', '=', $cita['fecha_cita'])->where('hora_entrada', '<=', $cita['hora_entrada'])->where('hora_salida', '>=', $cita['hora_entrada'])->where('medico_id ', '=', $cita["medico_id"])
                ->orWhere('fecha_cita', '=', $cita['fecha_cita'])->where('hora_entrada', '>=', $cita['hora_entrada'])->where('hora_salida', '<=', $cita['hora_entrada'])->where('medico_id ', '=', $cita["medico_id"])
                ->getAll();
        
        
        if ( count($isDuplicated) > 0 ) {
            $respuesta = new Response('DUPLICATE_APPOINTMENT');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarHorario($formulario) {

        // Obtenemos el día según la fecha de la cita
        setlocale(LC_TIME, 'es_VE.UTF-8','esp');
        $fechaCita = strtotime($formulario['fecha_cita']);
        $dia = strftime("%A", $fechaCita);

        if (iconv('UTF-8', 'ISO-8859-1//IGNORE', $dia) == "mircoles") {
            $dia = "miercoles";

        } else if (iconv('UTF-8', 'ISO-8859-1//IGNORE', $dia) == "sbado") {
            $dia = "sabado";
        }
        
        // Obtenemos el horario del médico ese día
        $_horarioModel = new HorarioModel();
        $medico = $_horarioModel->where('medico_id', '=', $formulario['medico_id'])->getAll();
        $horarioMedico = [];
        
        // Validamos si atiende a esa hora
        foreach ($medico as $horario) {
            
            if ($horario->dias_semana == $dia) {
                array_push($horarioMedico, $horario);
                
                if ($formulario['hora_entrada'] < $horario->hora_entrada || $formulario['hora_entrada'] > $horario->hora_salida || $formulario['hora_salida'] > $horario->hora_salida || $formulario['hora_salida'] < $horario->hora_entrada ) {
                    $respuesta = new Response(false, 'El médico indicado no está disponible a esa hora');
                    $respuesta->setData("Ocurrió un problema intentando asignar la cita, el médico se encuentra disponible ese día de ".$horario->hora_entrada." a ".$horario->hora_salida);
                    echo $respuesta->json(400);
                    exit();
                } 
            }
        }
        
        if ( count($horarioMedico) <= 0 ) {
            $respuesta = new Response(false, 'El médico indicado no está disponible ese día');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarReprogramacion($cita) {
        $validarCita = new Validate;
        
        if ($cita->estatus_cit == 2 || $cita->estatus_cit == 4 || $cita->estatus_cit == 5) {
            $respuesta = new Response(false, 'La cita no puede estar eliminada, reprogramada o asociada a una consulta');
            $respuesta->setData("Ocurrió un error reprogramando la cita con estatus ".$cita->estatus_cit);
            echo $respuesta->json(400);
            exit();

        } else if ( $validarCita->isDuplicatedId('medico_id', 'fecha_cita', $cita->medico_id, $_POST['fecha_cita'], 'cita') ) {
            $respuesta = new Response('DUPLICATE_APPOINTMENT');
            $respuesta->setData("Ya existe una cita el día ".$cita->fecha_cita);
            echo $respuesta->json(400);
            exit();
        }
    }
};