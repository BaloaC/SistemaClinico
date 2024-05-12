<?php 

include_once './services/globals/GlobalsHelpers.php';

class FacturaConsultaHelpers {

    public static function obtenerInformacion($factura, $es_asegurada) {

        $selectGeneral = array(
            "paciente.nombre AS nombre_paciente",
            "paciente.apellidos",
            "paciente.cedula",
            "paciente.direccion",
            "especialidad.nombre AS nombre_especialidad",
            "medico.nombre AS nombre_medico",
            "medico.apellidos AS apellidos_medico"
        );
    
        $selectConsultaSinCita = array(
            "consulta_sin_cita.paciente_id",
            "consulta_sin_cita.especialidad_id",
            "consulta_sin_cita.medico_id",
        );
    
        $innerConsultaSinCita = array(
            "paciente" => "consulta_sin_cita",
            "especialidad" => "consulta_sin_cita",
            "medico" => "consulta_sin_cita"
        );
    
        $selectConsultaCita = array(
            "consulta_cita.cita_id",
            "cita.paciente_id",
            "cita.especialidad_id",
            "cita.medico_id",
        );
    
        $innerConsultaCita = array(
            "cita" => "consulta_cita",
            "paciente" => "cita",
            "especialidad" => "cita",
            "medico" => "cita"
        );

        $_consultaCita = new ConsultaCitaModel();
        $innerConsultaCita = $_consultaCita->listInner( $innerConsultaCita );
        $_consultaCita->where('consulta_cita.consulta_id', '=',$factura->consulta_id);

        if ($es_asegurada) {
            $_consultaCita->where('cita.tipo_cita', '=', 2);
        } else {
            $_consultaCita->where('cita.tipo_cita', '=', 1);
        }

        $consulta = $_consultaCita->innerJoin( array_merge($selectConsultaCita, $selectGeneral), $innerConsultaCita, 'consulta_cita');
        
        // Si la consulta no es por cita, buscamos las que son sin cita
        if ( is_null($consulta) || count($consulta) <= 0 ) {
            $_consultaSinCita = new ConsultaSinCitaModel();
            $innerConsultaSinCita = $_consultaSinCita->listInner( $innerConsultaSinCita );
            $consulta = $_consultaSinCita->where('consulta_id', '=',$factura->consulta_id)
                                        ->innerJoin( array_merge($selectConsultaSinCita, $selectGeneral) , $innerConsultaSinCita, 'consulta_sin_cita');
        }


        if ( isset($consulta[0]) ) {
            return $consulta = array_merge( (array) $consulta[0],  (array) $factura);
        } else {
            return $consulta = array_merge( (array) $consulta,  (array) $factura);
        }
    }

    public static function obtenerInsumos($factura) {
        
        $_consultaInsumo = new ConsultaInsumoModel();
        $inners = $_consultaInsumo->listInner(['insumo' => 'consulta_insumo']);
        $array_select = Array('consulta_insumo.consulta_insumo_id', 'consulta_insumo.consulta_id', 'consulta_insumo.cantidad', 'consulta_insumo.estatus_con', 'consulta_insumo.precio_insumo_bs', 'consulta_insumo.precio_insumo_usd', 'consulta_insumo.insumo_id', 'insumo.nombre');
        $consultaInsumos = $_consultaInsumo->where('consulta_id', '=', $factura->consulta_id)
                                    ->where('estatus_con', '!=', '2')
                                    ->innerJoin($array_select, $inners, "consulta_insumo");
        $consulta = [];

        // Revisamos si tienes insumos asociados
        if ( !is_null($consultaInsumos) && count($consultaInsumos) > 0 ) {
            // $monto = $factura->monto_consulta;

            foreach ($consultaInsumos as $consulta_insumo) {
                
                $_insumoModel = new InsumoModel();
                $insumo = $_insumoModel->where('insumo_id', '=', $consulta_insumo->insumo_id)->getFirst();
                $consulta_insumo->precio_insumo = $insumo->precio;

                $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

                if ( isset($factura->consulta_seguro_id) && $consulta_insumo->precio_insumo_bs == 0 ) {
                    $consulta_insumo->precio_insumo_bs = round( $consulta_insumo->precio_insumo_usd * $valorDivisa, 2);
                    $consulta_insumo->monto_total_bs = $consulta_insumo->cantidad * $consulta_insumo->precio_insumo_bs;

                } else {
                    $consulta_insumo->monto_total_bs = round($consulta_insumo->cantidad * $consulta_insumo->precio_insumo_bs, 2);
                }

                $consulta_insumo->monto_total_usd = round($consulta_insumo->cantidad * $consulta_insumo->precio_insumo_usd);
            }
            
            $consulta['insumos'] = $consultaInsumos;
        }

        $consultaList[] = $consulta;
        return $consultaList[0];
    }

    public static function obtenerExamenes($factura) { 
        $_consultaExamenModel = new ConsultaExamenModel();
        $inners = $_consultaExamenModel->listInner(['examen' => 'consulta_examen']);
        $array_select = Array('consulta_examen.precio_examen_usd', 'consulta_examen.precio_examen_bs', 'consulta_examen.consulta_examen_id', 'consulta_examen.consulta_id', 'consulta_examen.examen_id', 'consulta_examen.estatus_con', 'examen.nombre');
        $consultaExamenes = $_consultaExamenModel->where('consulta_examen.consulta_id', '=', $factura->consulta_id)
                                                ->where('consulta_examen.estatus_con', '!=', '2')
                                                ->innerJoin($array_select, $inners, "consulta_examen");
        $consulta = [];
        // Revisamos si tienes insumos asociados
        if ( count($consultaExamenes) > 0 ) {
            // $monto = $factura->monto_consulta;

            foreach ($consultaExamenes as $consulta_examen) {
                $consulta_examen->precio_examen_usd = $consulta_examen->precio_examen_usd;

                if (isset($factura->consulta_seguro_id) && $consulta_examen->precio_examen_bs == 0) {
                    $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
                    $precio_examen_bs = $consulta_examen->precio_examen_usd * $valorDivisa;
                    $consulta_examen->precio_examen_bs = round($precio_examen_bs, 2);

                } else {
                    $consulta_examen->precio_examen_bs = $consulta_examen->precio_examen_bs;
                }       
            }
            
            $consulta['examenes'] = $consultaExamenes;
            $consultaList[] = $consulta;
            return $consultaList[0];
        }
    }

    public static function obtenerCitasExamenes($factura) {

        $_consultaCita = new ConsultaCitaModel();
        $consulta_cita = $_consultaCita->where('consulta_id', '=', $factura->consulta_id)->getFirst();

        if (!is_null($consulta_cita)) {
            $_citaExamenModel = new CitaExamenModel();
            $inners = $_citaExamenModel->listInner(['examen' => 'cita_examen']);
            $array_select = Array('cita_examen.precio_examen_usd', 'cita_examen.precio_examen_bs', 'cita_examen.cita_examen_id', 'cita_examen.cita_id', 'cita_examen.examen_id', 'cita_examen.estatus_cit', 'examen.nombre');
            $cita_examenes = $_citaExamenModel->where('cita_examen.cita_id', '=', $consulta_cita->cita_id)->innerJoin($array_select, $inners, "cita_examen");

            if (!is_null($cita_examenes)) {
                foreach ($cita_examenes as $examen) {
                    $examen->precio_examen_usd = $examen->precio_examen_usd;

                    if (isset($factura->consulta_seguro_id) && $examen->precio_examen_bs == 0) {
                        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
                        $precio_examen_bs = $examen->precio_examen_usd * $valorDivisa;
                        $examen->precio_examen_bs = round($precio_examen_bs, 2);
    
                    } else {
                        $examen->precio_examen_bs = $examen->precio_examen_bs;
                    }
                }
                $lista_examenes['cita_examenes'] = $cita_examenes;
            }
            $array_examen[] = $lista_examenes;
            return $array_examen[0];
        }
    }

    public static function obtenerMontoTotal($consulta) {
        
        $montoBs = 0; $montoUsd = 0;
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

        if (isset($consulta['insumos'])) {
            foreach ($consulta['insumos'] as $insumos) {
                
                $montoUsd += $insumos->monto_total_usd;

                if ( $insumos->monto_total_bs == 0 ) {
                    $montoBs += round( $insumos->monto_total_usd * $valorDivisa, 2);

                } else {
                    $montoBs += $insumos->monto_total_bs;
                }
            }
        }
        
        if (isset($consulta['examenes'])) {
            foreach ($consulta['examenes'] as $examenes) {
                
                $montoUsd += $examenes->precio_examen_usd;
                
                if ( $examenes->precio_examen_bs == 0 ) {
                    $montoBs += round( $examenes->precio_examen_usd * $valorDivisa, 2);

                } else {
                    $montoBs += $examenes->precio_examen_bs;
                }
            }
        }

        if (isset($consulta['cita_examenes'])) {
            foreach ($consulta['cita_examenes'] as $examenes) {
                
                $montoUsd += $examenes->precio_examen_usd;
                
                if ( $examenes->precio_examen_bs == 0 ) {
                    $montoBs += round( $examenes->precio_examen_usd * $valorDivisa, 2);

                } else {
                    $montoBs += $examenes->precio_examen_bs;
                }
            }
        }
        
        $_consultaCitaModel = new ConsultaCitaModel();
        $consulta_cita = $_consultaCitaModel->where('consulta_id', '=', $consulta['consulta_id'])->getFirst();
        
        if ( !is_null($consulta_cita) ) {
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', $consulta_cita->cita_id)->getFirst();

            if ( !is_null($cita) && $cita->tipo_servicio == 2 || is_null($cita)) {
                $consulta['monto_total_usd'] = $montoUsd + $consulta['monto_consulta_usd'];
                $consulta['monto_total_bs'] = round($consulta['monto_total_usd'] * $valorDivisa, 2);
                $consulta['monto_consulta_bs'] = round($consulta['monto_consulta_usd'] * $valorDivisa, 2);

            } else if ( !is_null($cita) && $cita->tipo_servicio == 1) {
                $consulta['monto_total_usd'] = $montoUsd;
                $consulta['monto_total_bs'] = round($consulta['monto_total_usd'] * $valorDivisa, 2);
            }
        }

        return $consulta;
    }

    public static function obtenerPrecioConsulta($consulta_id) {
        $_consultaModel = new ConsultaModel();
        $consulta = $_consultaModel->where('consulta_id', '=', $consulta_id)->getFirst();

        if ($consulta->tipo_servicio == 1) {
            return 0;
        } else {
            $_consultaCita = new ConsultaCitaModel();
            $consulta_cita = $_consultaCita->where('consulta_id', '=', $consulta_id)->getFirst();

            if (is_null($consulta_cita)) {
                $_consultaSinCita = new ConsultaSinCitaModel();
                $consulta_sin_cita = $_consultaSinCita->where('consulta_id', '=', $consulta_id)->getFirst();
                
                $_medicoEspecialidadModel = new MedicoEspecialidadModel();
                $consulta_sin_cita = $_consultaSinCita->where('consulta_id', '=', $consulta_id)->getFirst();
                $medico_especialidad = $_medicoEspecialidadModel->where('medico_id', '=', $consulta_sin_cita->medico_id)->getFirst();

                return $medico_especialidad->costo_especialidad;

            } else if (!is_null($consulta_cita)) {
                $_citaModel = new CitaModel();
                $cita = $_citaModel->where('cita_id', '=', $consulta_cita->cita_id)->getFirst();

                if ($cita->tipo_servicio == 2) {
                    $_medicoEspecialidadModel = new MedicoEspecialidadModel();
                    $medico_especialidad = $_medicoEspecialidadModel->where('medico_id', '=', $cita->medico_id)->getFirst();
                    return $medico_especialidad->costo_especialidad;
                } else {
                    return 0;
                }
            }
        }
    }

    public static function insertarPreciosFacturaNormal($consulta_id) {
        
        $_globalModel = new GlobalModel();
        $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();

        $_consultaExamenModel = new ConsultaExamenModel();
        $examenes = $_consultaExamenModel->where('consulta_id', '=', $consulta_id)->getAll();
        
        foreach ($examenes as $examen) {
            $precio_examen_bs = $examen->precio_examen_usd * (float) $valorDivisa->value;
            $precio_examen_bs = round($precio_examen_bs, 2);
            
            $consultaExamen = new ConsultaExamenModel();
            $actualizado = $consultaExamen->where('consulta_examen_id', '=', $examen->consulta_examen_id)->update(array('precio_examen_bs' => $precio_examen_bs));
        }

        $_consultaCitaModel = new ConsultaCitaModel();
        $consulta_cita = $_consultaCitaModel->where('consulta_id', '=', $consulta_id)->getFirst();

        if (!is_null($consulta_cita)) {
            $_citaExamenModel = new CitaExamenModel();
            $examenes = $_citaExamenModel->where('cita_id', '=', $consulta_cita->cita_id)->getAll();

            foreach ($examenes as $examen) {
                $precio_examen_bs = $examen->precio_examen_usd * (float) $valorDivisa->value;
                $precio_examen_bs = round($precio_examen_bs, 2);
                
                $_citaExamenModel = new CitaExamenModel();
                $actualizado = $_citaExamenModel->where('cita_examen_id', '=', $examen->cita_examen_id)->update(array('precio_examen_bs' => $precio_examen_bs));
            }
        }
        
        $_consultaInsumoModel = new ConsultaInsumoModel();
        $insumos = $_consultaInsumoModel->where('consulta_id', '=', $consulta_id)->getAll();

        foreach ($insumos as $insumo) {
            $precio_insumo_bs = $insumo->precio_insumo_usd * (float) $valorDivisa->value;
            $precio_insumo_bs = round($precio_insumo_bs, 2);
            
            $consultaInsumo = new ConsultaInsumoModel();
            $consultaInsumo->where('consulta_insumo_id', '=', $insumo->consulta_insumo_id)->update(array('precio_insumo_bs' => $precio_insumo_bs));
        }
    }

    public static function RetornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json(200);
        exit();
    }
}