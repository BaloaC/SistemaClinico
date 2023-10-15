<?php

include_once './services/medico/medico/MedicoValidaciones.php';

class MedicoHelpers {

    public static function insertarMedicoEspecialidad($especialidades, $id) {

        $validarMedicoEspecialidad = new Validate();
        $medico_id = $id;

        foreach ($especialidades as $especialidad) {

            $especialidad['medico_id'] = $medico_id;
            MedicoValidaciones::validarDuplicadoMedicoEspecialidad($especialidad);

            $medico_especialidad = $validarMedicoEspecialidad->dataScape($especialidad);

            $_medicoEspecialidadModel = new MedicoEspecialidadModel();
            $id = $_medicoEspecialidadModel->insert($medico_especialidad);
            $mensaje = ($id > 0);

            if (!$mensaje) {  
                $respuesta = new Response('INSERCION_FALLIDA');
                $respuesta->setData('El registro de la médico especialidad: '.$especialidad.' fallo');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function insertarMedicoHorario($horarios, $medico_id) {

        $validarHorario = new Validate();

        foreach ($horarios as $horario) {
            
            $horario['medico_id'] = $medico_id;
            MedicoValidaciones::validarMedicoHorario($horario);

            $medico_horario = $validarHorario->dataScape($horario);

            $_horarioModel = new HorarioModel();
            $id = $_horarioModel->insert($medico_horario);
            $mensaje = ($id > 0);

            if (!$mensaje) {
                $respuesta = new Response('INSERCION_FALLIDA');
                echo $respuesta->json($mensaje ? 201 : 400);
                exit();
            }
        }
    }
}