<?php 

include_once './services/globals/GlobalsHelpers.php';

class FacturaConsultaHelpers {

    public static function obtenerInformacion($factura) {

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
        $consulta = $_consultaCita->where('consulta_cita.consulta_id', '=',$factura->consulta_id)
                                    ->where('cita.tipo_cita', '=', 1)                        
                                    ->innerJoin( array_merge($selectConsultaCita, $selectGeneral), $innerConsultaCita, 'consulta_cita');
        
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

                $consulta_insumo->monto_total_usd = $consulta_insumo->cantidad * $consulta_insumo->precio_insumo_usd;
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
        }

        $consultaList[] = $consulta;
        return $consultaList[0];
    }

    public static function obtenerMontoTotal($consulta) {
        // $facturas = [];
        
        // foreach ($facturaList as $consulta) {
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
                    // var_dump($consulta['examenes']);
                    // var_dump($examenes);
                    $montoUsd += $examenes->precio_examen_usd;
                    
                    if ( $examenes->precio_examen_bs == 0 ) {
                        $montoBs += round( $examenes->precio_examen_usd * $valorDivisa, 2);

                    } else {
                        $montoBs += $examenes->precio_examen_bs;
                    }
                }
            }
            // echo '<pre>'; var_dump(isset($consulta['consulta_emergencia']));
            // if ( isset($consulta['consulta_emergencia']) ) {
                $consulta['monto_total_usd'] = $montoUsd + $consulta['monto_consulta_usd'];
                $consulta['monto_total_bs'] = round($consulta['monto_total_usd'] * $valorDivisa, 2);
                $consulta['monto_consulta_bs'] = round($consulta['monto_consulta_usd'] * $valorDivisa, 2);
            // }
            

            // $facturas[] = $consulta;
        // }
        
        return $consulta;
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