<?php

include_once './services/medico/medico/MedicoValidaciones.php';
include_once './services/medico/medico/MedicoHelpers.php';

class MedicoService {

    public static function insertarMedico($formulario) {

        $validarMedico = new Validate;

        MedicoValidaciones::validarRegistro($formulario);
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
}