<?php

class FacturaConsultaService {

    public static function listarFacturas() {

        $selectConsulta = array(
            "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            "factura_consulta.tipo_consulta",
            // "factura_consulta.metodo_pago",
            "factura_consulta.monto_consulta_bs",
            "factura_consulta.monto_consulta_usd",
            "factura_consulta.estatus_fac",
            "consulta.fecha_consulta",
            "consulta.es_emergencia"
        );
        
        $innerConsulta = array("consulta" => "factura_consulta");

        // Obtenemos todas las facturas
        $_facturaConsulta = new FacturaConsultaModel();

        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_facturaConsulta->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_facturaConsulta->where("CONCAT(factura_consulta.factura_consulta_id)", 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_facturaConsulta->where("CONCAT(factura_consulta.factura_consulta_id)", 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $innersConsulta = $_facturaConsulta->listInner($innerConsulta);

        if ( array_key_exists('date', $_GET) ) {
            
            $fecha_mes = DateTime::createFromFormat('Y-m-d', $_GET['date']);
            $mes = $fecha_mes->format("m");
            $anio = $fecha_mes->format("Y");
            
            $facturasList = $_facturaConsulta->where('YEAR(fecha_consulta)',"=",$anio)
                                                ->where('MONTH(fecha_consulta)', '=', $mes)
                                                ->innerJoin($selectConsulta, $innersConsulta, "factura_consulta");

        } else {
            $facturasList = $_facturaConsulta->innerJoin($selectConsulta, $innersConsulta, "factura_consulta");
        }
        
        // Hacemos inner para obtener los datos de las consultas
        $consultaList = [];
        $monto_total_consultas_bs = 0;
        $monto_total_consultas_usd = 0;
        
        if (!is_null($facturasList) && count($facturasList)) {
            foreach ($facturasList as $factura) {

                $_consultaSeguro = new ConsultaSeguroModel();
                $consulta_seguro = $_consultaSeguro->where('consulta_id', '=', $factura->consulta_id)->getFirst();
                $es_asegurada = is_null($consulta_seguro) ? false : true;

                if ( array_key_exists('date', $_GET) ) {
                    $informacion_consulta = FacturaConsultaHelpers::obtenerInformacion($factura, $es_asegurada); 
                    // $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
    
                    // verificar para que sirve este codigo
                    // $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);
                    // verificar para que sirve este codigo
                    
                    // $factura_consulta = array_merge($informacion_consulta, $insumos_consulta);
    
                    $consultaList['facturas'][] = $informacion_consulta;
                    $monto_total_consultas_bs += $informacion_consulta['monto_consulta_bs'];
                    $monto_total_consultas_usd += $informacion_consulta['monto_consulta_usd'];
    
                } else {

                    $consulta_info = FacturaConsultaHelpers::obtenerInformacion($factura, $es_asegurada);
                    // $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
                    // echo '<pre>';
                    // var_dump($consulta_info);
                    if (!isset($consulta_info['nombre_paciente']) && $consulta_info['es_emergencia'] == 0) {
                        $_consultaCitaModel = new ConsultaCitaModel();
                        $inners = $_consultaCitaModel->listInner(['cita' => 'consulta_cita', 'paciente' => 'cita']);
                        $informacion_paciente = $_consultaCitaModel->where('consulta_cita.consulta_id', '=', $factura->consulta_id)
                                                        ->innerJoin(['paciente.nombre AS nombre_paciente', 'paciente.apellidos'], $inners, 'consulta_cita');
                        
                        $consulta_info = array_merge($consulta_info, (array) $informacion_paciente[0]);

                    } else if ($consulta_info['es_emergencia']) {
                        $_consultaEmergencia = new ConsultaEmergenciaModel();
                        $inners = $_consultaEmergencia->listInner(['paciente' => 'consulta_emergencia']);
                        $cta_emergencia = $_consultaEmergencia->where('consulta_id', '=', $factura->consulta_id)
                                                                ->innerJoin(['paciente.nombre AS nombre_paciente', 'paciente.apellidos'], $inners, 'consulta_emergencia');

                        $consulta_info = array_merge($consulta_info, (array) $cta_emergencia[0]);
                    }
    
                    $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);
                    $examenes_cita = FacturaConsultaHelpers::obtenerCitasExamenes($factura);
                    $examenes = "";

                    if ( !is_null($examenes_consulta) && !is_null($examenes_cita)) {
                        $examenes = array_merge($examenes_consulta, $examenes_cita);
                    } else {
                        $examenes = $examenes_consulta ?? $examenes_cita;
                    }
                    
                    if (!is_null($examenes)) {
                        $consultaList[] = array_merge($consulta_info, $examenes);
                    } else {
                        $consultaList[] = $consulta_info;
                    }
                }
            }
        }
        
        if ( array_key_exists('date', $_GET) ) {
            $consultaList['monto_total_bs'] =  round($monto_total_consultas_bs, 2);
            $consultaList['monto_total_usd'] =  round($monto_total_consultas_usd, 2);
            return $consultaList;
        }

        $facturas = [];
        foreach ($consultaList as $consulta) {
            // $montoRelaciones =  FacturaConsultaHelpers::obtenerMontoTotal($consulta);

            $facturas[] = FacturaConsultaHelpers::obtenerMontoTotal($consulta);
        }

        return $facturas;
    }

    public static function listarFacturaPorId($factura_id) {
        
        // Obtenemos todas las facturas
        $selectConsulta = array(
            "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            // "factura_consulta.metodo_pago",
            "factura_consulta.monto_consulta_bs",
            "factura_consulta.monto_consulta_usd",
            "factura_consulta.estatus_fac",
            "consulta.fecha_consulta",
            "consulta.es_emergencia"
        );
        
        $innerConsulta = array("consulta" => "factura_consulta");

        $_facturaConsulta = new FacturaConsultaModel();
        $innersConsulta = $_facturaConsulta->listInner($innerConsulta);
        $factura = $_facturaConsulta->where('factura_consulta_id', '=', $factura_id)
                                    ->innerJoin($selectConsulta, $innersConsulta, "factura_consulta");
        
        if (is_null($factura) || count($factura) <= 0) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();
        }
        
        $factura = (object) $factura[0];
        $_consultaSeguro = new ConsultaSeguroModel();
        $consulta_seguro = $_consultaSeguro->where('consulta_id', '=', $factura->consulta_id)->getFirst();
        $es_asegurada = is_null($consulta_seguro) ? false : true;

        $consulta_info = FacturaConsultaHelpers::obtenerInformacion($factura, $es_asegurada);
        $consulta_info['es_asegurada'] = true;
        // $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
        $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);
        $examenes_cita = FacturaConsultaHelpers::obtenerCitasExamenes($factura);
        $examenes = "";
                
        if ( !is_null($examenes_consulta) && !is_null($examenes_cita)) {
            $examenes = array_merge($examenes_consulta, $examenes_cita);
        } else {
            $examenes = $examenes_consulta ?? $examenes_cita;
        }
        
        if (!is_null($examenes)) {
            // $consultaList[] = array_merge($consulta_info, $examenes);
            return FacturaConsultaHelpers::obtenerMontoTotal(array_merge($consulta_info, $examenes));
        } else {
            return FacturaConsultaHelpers::obtenerMontoTotal(array_merge($consulta_info));
            // $consultaList[] = $consulta_info;
        }
        
        // $factura_consulta = array_merge($consulta_info, $examenes_consulta, $examenes_cita);
        // return FacturaConsultaHelpers::obtenerMontoTotal($consultaList);

        // return FacturaConsultaHelpers::obtenerMontoTotal( array ($factura_consulta));
    }
}