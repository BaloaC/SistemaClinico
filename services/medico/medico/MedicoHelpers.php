<?php

include_once './services/medico/medico/MedicoValidaciones.php';

class MedicoHelpers {

    protected static $arrayInnerHorario = array(
        "medico" => "horario"
    );

    protected static $arraySelectHorario = array(
        "horario.horario_id",
        "horario.dias_semana",
        "horario.hora_entrada",
        "horario.hora_salida"
    );

    protected static $arrayInner = array(
        // "medico" => "medico_especialidad",
        "especialidad" => "medico_especialidad",
    );

    protected static $arraySelect = array(
        "especialidad.nombre AS nombre_especialidad",
        "especialidad.especialidad_id",
        "medico_especialidad.medico_especialidad_id"
    );

    public static function obtenerRelaciones($medicos) {
        // Especialidad
        $_medicoModel = new MedicoModel();
        $inners = $_medicoModel->listInner(MedicoHelpers::$arrayInner);
        $medico = $_medicoModel->where('medico_especialidad.medico_id', '=', $medicos->medico_id)->where('medico_especialidad.estatus_med', '=', '1')->innerJoin(MedicoHelpers::$arraySelect, $inners, "medico_especialidad");

        if ($medico) {
            $medicos->especialidad = $medico;
        }

        $_medicoModel = new MedicoModel();
        $innersH = $_medicoModel->listInner(MedicoHelpers::$arrayInnerHorario);
        $horario = $_medicoModel->where('horario.medico_id', '=', $medicos->medico_id)->where('horario.estatus_hor', '=', '1')->innerJoin(MedicoHelpers::$arraySelectHorario, $innersH, "horario");

        if ($horario && $medico) {
            $medicos->horario = $horario;
        }

        $resultado = $medicos;
        return $resultado;
    }

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