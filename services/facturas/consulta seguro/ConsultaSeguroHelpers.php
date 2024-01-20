<?php

include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/consulta/consultaService.php";
include_once "./services/globals/GlobalsHelpers.php";

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
        // $_consultaEmergencia = new ConsultaEmergenciaModel();
        // $consulta_emergencia = $_consultaEmergencia->where('consulta_id', '=', $consulta->consulta_id)->getFirst();

        $_consultaModel = new ConsultaModel();
        $consultaBase = $_consultaModel->where('consulta_id', '=', $consulta->consulta_id)->getFirst();

        // $_pacienteModel = new PacienteModel();
        // $paciente = $_pacienteModel->where('cedula', '=', $consulta_emergencia->cedula_beneficiado)->getFirst();
        $consulta_emergencia = ConsultaService::obtenerConsultaEmergencia($consulta);
        // $_paciente = new PacienteModel();
        // $titular = $_paciente->where('paciente_id', '=', $consulta_emergencia->paciente_id)->getFirst();

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro_id', '=', $consulta_emergencia->seguro_id)->getFirst();

        // $consulta->consulta_emergencia = $consulta_emergencia;
        $consulta->consulta = $consultaBase;
        // $consulta->paciente_beneficiado = $paciente;
        // $consulta->paciente_titular = $titular;
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
        $consultaTotal = $consulta["factura"]->consultas_medicas 
            + $consulta["factura"]->laboratorios 
            + $consulta["factura"]->medicamentos 
            + $consulta["factura"]->enfermeria
            + $consulta["factura"]->total_insumos 
            + $consulta["factura"]->total_examenes 
            + $consulta["factura"]->total_consulta;

        $consulta["monto_consulta"] = $consultaTotal;
        return $consulta;
    }

    /**
     * Helpers para calcular el total de los exámenes de la consulta por emergencia
     */
    public static function calcularExamenesEmergencia($examenes) {
        $costo_total_examenes = 0;

        foreach ($examenes as $examen) {
            $costo_total_examenes += $examen->precio_examen_usd;
        }

        return $costo_total_examenes;
    }

    /**
     * Helper para actualizar los precios de bs de las consultas por seguro
     */
    public static function actualizarConsultaSeguro($consulta) {

        $consultaSeguroModel = new ConsultaSeguroModel();
        $consulta_seguro = $consultaSeguroModel->where('consulta_seguro_id', '=', $consulta["consulta_seguro_id"])->getFirst();
        
        if (is_null($consulta_seguro)) {
            ConsultaHelper::actualizarPrecioEmergencia($consulta);

        } else {

            $consultaExamenModel = new ConsultaExamenModel();
            $consulta_examenes = $consultaExamenModel->where('consulta_id', '=', $consulta_seguro->consulta_id)->getAll();

            $consultaInsumoModel = new ConsultaInsumoModel();
            $consulta_insumos = $consultaInsumoModel->where('consulta_id', '=', $consulta_seguro->consulta_id)->getAll();

            $costo_examenes_bs = 0; $costo_insumos_bs = 0;

            if( !is_null($consulta_examenes) ) {
                foreach ($consulta_examenes as $examen) {
                    
                    $examen_modificado = Array( 'precio_examen_bs' => 0 );

                    $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
                    $examen_modificado['precio_examen_bs'] = round( $examen->precio_examen_usd * $valorDivisa ,2 );
                    $costo_examenes_bs += $examen_modificado['precio_examen_bs'];
                    
                    $consultaExamenModel = new ConsultaExamenModel();
                    $isUpdate = $consultaExamenModel->where('consulta_examen_id', '=', $examen->consulta_examen_id)->update($examen_modificado);
                }
            }
            
            if( !is_null($consulta_insumos) ) {
                foreach ($consulta_insumos as $insumo) {
                    
                    $insumo_modificado = Array( 'precio_insumo_bs' => 0 );

                    $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
                    $precio_bs_actual = round( $insumo->precio_insumo_usd * $valorDivisa ,2 );
                    $insumo_modificado['precio_insumo_bs'] = $precio_bs_actual * $insumo->cantidad;
                    $costo_insumos_bs += $insumo_modificado['precio_insumo_bs'];
                    
                    $consultaInsumoModel = new ConsultaInsumoModel();
                    $isUpdate = $consultaInsumoModel->where('consulta_insumo_id', '=', $insumo->consulta_insumo_id)->update($insumo_modificado);
                }
            }

            $monto_total_bs = round($consulta_seguro->monto_consulta_usd * $valorDivisa, 2);
            $monto_sumatoria_bs = $monto_total_bs + $costo_examenes_bs + $costo_insumos_bs;
            $consulta_modificada = Array("monto_consulta_bs" => $monto_sumatoria_bs);
            $consultaUpdate = $consultaSeguroModel->update($consulta_modificada);
        }
    }
}
