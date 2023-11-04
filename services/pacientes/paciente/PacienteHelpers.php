<?php

class PacienteHelpers {

    /**
     * Esta función posee la lógica para insertar en las tablas paciente_beneficiado y titular_beneficaido
     * @param formulario formulario key 'titular'
     * @param paciente_id paciente_id (no beneficiado)
     * @return bool
     */
    public static function insertarPacienteBeneficiado($formulario, $paciente_id) {
        
        $validarPacienteBeneficiado = new Validate();
        $data = $validarPacienteBeneficiado->dataScape($formulario);
        $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();

        $paciente_beneficiado['paciente_id'] = $paciente_id;
        $beneficiado_id = $_pacienteBeneficiadoModel->insert($paciente_beneficiado);
        
        if ( !$beneficiado_id > 0) {
            $respuesta = new Response(false, 'Ocurrió un error insertando el paciente beneficiado');
            echo $respuesta->json(400);
            exit();
        }
        
        $titular_beneficiado = $data;
        
        foreach ($formulario as $titular_beneficiado) {
            PacienteHelpers::insertarTitularBeneficiado($titular_beneficiado, $beneficiado_id);
        }
    }

    /**
     * Esta función inserta titulares a un paciente_beneficiado
     */
    public static function insertarTitularBeneficiado($formulario, $paciente_beneficiado_id) {
        $formulario['paciente_beneficiado_id'] = $paciente_beneficiado_id;

        $_titularBeneficiadoModel = new TitularBeneficiadoModel();
        $titular_beneficiado_id = $_titularBeneficiadoModel->insert($formulario);

        if (!$titular_beneficiado_id > 0) {
            $respuesta = new Response(false, 'Ocurrió un problema insertando la relación de titular beneficiado');
            echo $respuesta->json(400);
            exit();
        }
    }
}