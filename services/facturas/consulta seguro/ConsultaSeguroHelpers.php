<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";

class ConsultaSeguroHelpers {

    /**
     * Helper para obtener la información de una consulta_seguro por cita
     */
    public static function obtenerInformacionCita($consulta) {

        $_consultaCita = new ConsultaCitaModel();
        $consulta_cita = $_consultaCita->where('consulta_id', '=', $consulta->consulta_id)->getFirst();
        
        $_citaModel = new CitaModel();
        $cita = $_citaModel->where('cita_id', '=', $consulta_cita->cita_id)->getFirst();
        
        $_consultaModel = new ConsultaModel();
        $consultaBase = $_consultaModel->where('consulta_id', '=', $consulta_cita->consulta_id)->getFirst();
        
        $_pacienteModel = new PacienteModel();
        $beneficiado = $_pacienteModel->where('paciente_id', '=', $cita->paciente_id)->getFirst();
        
        $_paciente = new PacienteModel();
        $titular = $_paciente->where('cedula', '=', $cita->cedula_titular)->getFirst();

        $_especialidadModel = new EspecialidadModel();
        $especialidad = $_especialidadModel->where('especialidad_id', '=', $cita->especialidad_id)->getFirst();

        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $cita->medico_id)->getFirst();

        $consulta->cita = $cita;
        $consulta->consulta = $consultaBase;
        $consulta->paciente_beneficiado = $beneficiado;
        $consulta->paciente_titular = $titular;
        $consulta->especialidad = $especialidad;
        $consulta->medico = $medico;

        return $consulta;
    }

    /**
     * Helper para obtener la información de una consulta_seguro por emergencia
     */
    public static function obtenerInformacionEmergencia($consulta) {
        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $consulta_emergencia = $_consultaEmergencia->where('consulta_id', '=', $consulta->consulta_id)->getFirst();

        $_consultaModel = new ConsultaModel();
        $consultaBase = $_consultaModel->where('consulta_id', '=', $consulta->consulta_id)->getFirst();

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('cedula', '=', $consulta_emergencia->cedula_beneficiado)->getFirst();

        $_paciente = new PacienteModel();
        $titular = $_paciente->where('paciente_id', '=', $consulta_emergencia->paciente_id)->getFirst();

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro_id', '=', $consulta_emergencia->seguro_id)->getFirst();

        $consulta->consulta_emergencia = $consulta_emergencia;
        $consulta->consulta = $consultaBase;
        $consulta->paciente_beneficiado = $paciente;
        $consulta->paciente_titular = $titular;
        $consulta->seguro = $seguro;

        return $consulta;
    }

    /**
     * Helper para obtener la información completa, esto incluye citas, consultas, exámenes e insumos
     */
    public static function obtenerInformacionCompleta($consultasSeguros) {

        $listaConsultas = [];

        if (count($consultasSeguros) > 0) {
            foreach ($consultasSeguros as $consulta) {
            
                $_consultaCita = new ConsultaCitaModel();
                $consulta_cita = $_consultaCita->where('consulta_id', '=', $consulta->consulta_id)->getFirst();
                $consulta;

                if (is_null($consulta_cita)) {
                    $consulta = ConsultaSeguroHelpers::obtenerInformacionEmergencia($consulta);
                } else {
                    $consulta = ConsultaSeguroHelpers::obtenerInformacionCita($consulta);
                }

                $consultaInsumos = FacturaConsultaHelpers::obtenerInsumos($consulta);
                $consultaExamenes = FacturaConsultaHelpers::obtenerExamenes($consulta);
                $listaConsultas[] = array_merge((Array) $consulta, (Array) $consultaInsumos, (Array) $consultaExamenes);
            }
        }

        return $listaConsultas;
    }

    /**
     * Helper para calcular la sumatoría de los costos de la consulta_emergencia
     */
    public static function calcularConsultaEmergencia($consulta) {
        $consultaTotal = $consulta["consulta_emergencia"]->consultas_medicas 
            + $consulta["consulta_emergencia"]->laboratorios 
            + $consulta["consulta_emergencia"]->medicamentos 
            + $consulta["consulta_emergencia"]->enfermeria
            + $consulta["consulta_emergencia"]->total_insumos 
            + $consulta["consulta_emergencia"]->total_examenes 
            + $consulta["consulta_emergencia"]->total_consulta;

        $consulta["monto_consulta"] = $consultaTotal;
        return $consulta;
    }

    /**
     * Helper para actualizar los precios de bs de las consultas por seguro
     */
    public static function actualizarConsultaSeguro($consulta) {

        $consultaSeguroModel = new ConsultaSeguroModel();
        $consulta_seguro = $consultaSeguroModel->where('consulta_seguro_id', '=', $consulta["consulta_seguro_id"])->getFirst();

        /* NO USES HELPERS, SACA EL CÁLCULO MANUAL A DIVISAS E INSERTALO */

        // if (is_null($consulta_seguro)) {
        //     $consulta = ConsultaSeguroHelpers::obtenerInformacionEmergencia($consulta);
        // } else {
        //     $consulta = ConsultaSeguroHelpers::obtenerInformacionCita($consulta);
        // }

        // $consultaInsumos = FacturaConsultaHelpers::obtenerInsumos($consulta);
        // $consultaExamenes = FacturaConsultaHelpers::obtenerExamenes($consulta);
        // $listaConsultas[] = array_merge((Array) $consulta, (Array) $consultaInsumos, (Array) $consultaExamenes);
    }
}
