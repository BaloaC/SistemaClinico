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
        $consultaInsumos = $_consultaInsumo->where('consulta_id', '=', $factura->consulta_id)
                                    ->where('estatus_con', '!=', '2')
                                    ->getAll();

        $consulta = [];

        // Revisamos si tienes insumos asociados
        if ( count($consultaInsumos) > 0 ) {
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
                    $consulta_insumo->monto_total_bs = $consulta_insumo->cantidad * $consulta_insumo->precio_insumo_bs;
                }

                $consulta_insumo->monto_total_usd = $consulta_insumo->cantidad * $consulta_insumo->precio_insumo_usd;
            }
            
            $consulta['insumos'] = $consultaInsumos;
        }

        $consultaList[] = $consulta;
        return $consultaList[0];
    }

    public static function obtenerExamenes($factura) { 
        // echo '<pre>'; var_dump($factura);
        $_consultaExamenModel = new ConsultaExamenModel();
        $consultaExamenes = $_consultaExamenModel->where('consulta_id', '=', $factura->consulta_id)
                                    ->where('estatus_con', '!=', '2')
                                    ->getAll();

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

                    $montoUsd += $examenes->precio_examen_usd;
                    
                    if ( $examenes->precio_examen_bs == 0 ) {
                        $montoBs += round( $examenes->precio_examen_usd * $valorDivisa, 2);

                    } else {
                        $montoBs += $examenes->precio_examen_bs;
                    }
                }
            }

            $consulta['monto_total_usd'] = $montoUsd + $consulta['monto_consulta_usd'];
            $consulta['monto_total_bs'] = $montoBs + $consulta['monto_consulta_bs'];

            // $facturas[] = $consulta;
        // }
        
        return $consulta;
    }

    public static function RetornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json(200);
        exit();
    }
}