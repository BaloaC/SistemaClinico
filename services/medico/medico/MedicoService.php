<?php

include_once './services/medico/medico/MedicoValidaciones.php';
include_once './services/medico/medico/MedicoHelpers.php';

class MedicoService {

    public static function insertarMedico($formulario) {

        $validarMedico = new Validate;

        MedicoValidaciones::validacionesGenerales($formulario);
        MedicoValidaciones::validarCedula($formulario);
        MedicoValidaciones::validarMedicoEspecialidad($formulario['especialidad']);
        MedicoValidaciones::validarHorario($formulario['horario']);

        $especialidad = $formulario['especialidad'];
        $horario = $formulario['horario'];
        unset($formulario['especialidad']);
        unset($formulario['horario']);

        $data = $validarMedico->dataScape($formulario);

        $_medicoModel = new MedicoModel();
        $id = $_medicoModel->insert($data);

        if ($id > 0) {
            MedicoHelpers::insertarMedicoEspecialidad($especialidad, $id);
            MedicoHelpers::insertarMedicoHorario($horario, $id);
        }
    }

    public static function actualizarMedico($formulario, $medico_id) {
        $validarMedico = new Validate;

        MedicoValidaciones::validacionesGenerales($formulario);

        if (array_key_exists('cedula', $formulario)) {
            MedicoValidaciones::validarCedula($formulario);
        }

        if (array_key_exists('especialidad', $_POST)) {
            $especialidad = $_POST['especialidad'];
            unset($_POST['especialidad']);

            MedicoValidaciones::validarMedicoEspecialidad($especialidad);
            MedicoHelpers::insertarMedicoEspecialidad($especialidad, $medico_id);
        }

        if (array_key_exists('horario', $_POST)) {
            $horario = $_POST['horario'];
            unset($_POST['horario']);

            MedicoValidaciones::validarHorario($horario);
            MedicoHelpers::insertarMedicoHorario($horario, $medico_id);
        }

        $medico_actualizado = $validarMedico->dataScape($_POST);

        if (!empty($medico_actualizado)) {

            $_medicoModel = new MedicoModel();
            $actualizado = $_medicoModel->where('medico_id', '=', $medico_id)->update($medico_actualizado);
            $mensaje = ($actualizado > 0);

            if (!$mensaje) {
                $respuesta = new Response('ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);
                return $respuesta->json(400);
            }
        }
    }
}