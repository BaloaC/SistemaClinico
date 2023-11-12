<?php

include_once './services/pacientes/paciente/PacienteHelpers.php';
include_once './services/pacientes/paciente/PacienteValidaciones.php';
include_once './services/pacientes/paciente seguro/PacienteSeguroService.php';

class PacienteService{

    public static function insertarPaciente($formulario) {

        $validarPaciente = new Validate;
        $_pacienteModel = new PacienteModel();

        if ( $formulario['tipo_paciente'] != 4 && $validarPaciente->isDuplicated('paciente', 'cedula', $formulario['cedula']) ) { 
            $respuesta = new Response(false, 'Ya existe un paciente con esa cédula');
            $respuesta->setData("Problema al insertar el paciente con la cédula ".$formulario['cedula']);
            return $respuesta->json(400);
        }

        if ( $formulario['tipo_paciente'] == 3 ) {
            // lógica para paciente tipo asegurado

            $pacienteSeguro = $formulario['seguro'];
            unset($formulario['seguro']);
            
            $data = $validarPaciente->dataScape($formulario);
            $id = $_pacienteModel->insert($data);

            PacienteValidaciones::validarTipoPaciente($formulario, $id, 3);
            PacienteValidaciones::validarDuplicadoPacienteSeguro($pacienteSeguro, $id);
            
            if ( $id > 0 ) {
                
                PacienteSeguroService::insertarPacienteSeguro($pacienteSeguro, $id);
                $respuesta = new Response('INSERCION_EXITOSA');
                $respuesta->setData($data);
                echo $respuesta->json(201);
                exit();
            }

        } else if( $formulario['tipo_paciente'] == 4 ) {
            // Lógica para paciente tipo beneficiado

            $pacienteBeneficiado = $formulario['titular'];
            PacienteValidaciones::validarPacienteBeneficiado($pacienteBeneficiado);
            unset($formulario['titular']);

            $data = $validarPaciente->dataScape($formulario);
            $id = $_pacienteModel->insert($data);
            
            PacienteValidaciones::validarTipoPaciente($formulario, $id, 4);
            
            if ( $id > 0 ) {
                PacienteHelpers::insertarPacienteBeneficiado($pacienteBeneficiado, $id);
                
                $respuesta = new Response('INSERCION_EXITOSA');
                echo $respuesta->json(201);
                exit();
            }

        }else {
            
            $data = $validarPaciente->dataScape($formulario);
            $id = $_pacienteModel->insert($data);
            $mensaje = ($id > 0);
            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
            echo $respuesta->json($mensaje ? 201 : 400);
            exit();
        }
    }

    public static function actualizarPaciente($formulario, $paciente_id) {
        
        $validarPaciente = new Validate();

        PacienteValidaciones::validarPacienteId($paciente_id);
        PacienteValidaciones::validacionesGenerales($formulario);
        PacienteValidaciones::validarPacienteActualizado($formulario, $paciente_id);
        PacienteValidaciones::validarPacienteSeguro($formulario);
        
        if ( array_key_exists('seguro', $formulario) ) {
            
            PacienteValidaciones::validarDuplicadoPacienteSeguro($formulario['seguro'], $paciente_id);
            PacienteValidaciones::validarTipoPaciente($formulario, $paciente_id, 3);
            PacienteSeguroService::insertarPacienteSeguro($formulario['seguro'], $paciente_id);
            
            unset($formulario['seguro']);
        }

        if ( array_key_exists('titular', $formulario) ) {
            
            PacienteValidaciones::validarPacienteBeneficiado($formulario['titular']);
            PacienteValidaciones::validarTipoPaciente($formulario, $paciente_id, 4);
            
            $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();
            $paciente_beneficiado_id = $_pacienteBeneficiadoModel->where('paciente_id', '=', $paciente_id)->getFirst();
            
            if (is_null($paciente_beneficiado_id) || count( (Array) $paciente_beneficiado_id) <= 0) {
                PacienteHelpers::insertarPacienteBeneficiado($formulario['titular'], $paciente_id);
                
            } else {
                PacienteValidaciones::validarDuplicadoPacienteBeneficiado($formulario['titular'], $paciente_beneficiado_id->paciente_beneficiado_id);

                foreach ($formulario['titular'] as $titulares) {
                    PacienteHelpers::insertarTitularBeneficiado($titulares, $paciente_beneficiado_id->paciente_beneficiado_id);
                }
            }

            unset($formulario['titular']);
        }

        if ( !empty($formulario) ) {

            $data = $validarPaciente->dataScape($formulario);
            $_pacienteModel = new PacienteModel();
            
            $actualizado = $_pacienteModel->where('paciente_id','=',$paciente_id)->update($data);

            if (!$actualizado > 0) {
                $respuesta = new Response('ACTUALIZACION_FALLIDA');
                $respuesta->setData($data);
                return $respuesta->json(400);
            }
        }
    }
}