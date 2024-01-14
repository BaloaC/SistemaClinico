<?php

class FacturaConsultaService {

    public static function listarFacturas() {

        $selectConsulta = array(
            "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            "factura_consulta.metodo_pago",
            "factura_consulta.monto_consulta_bs",
            "factura_consulta.monto_consulta_usd",
            "factura_consulta.estatus_fac",
            "consulta.fecha_consulta",
            "consulta.es_emergencia"
        );
        
        $innerConsulta = array("consulta" => "factura_consulta");

        // Obtenemos todas las facturas
        $_facturaConsulta = new FacturaConsultaModel();
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
        
        foreach ($facturasList as $factura) {
            
            if ( array_key_exists('date', $_GET) ) {
                
                $informacion_consulta = FacturaConsultaHelpers::obtenerInformacion($factura); 
                $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
                $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);
                
                $factura_consulta = array_merge($informacion_consulta, $insumos_consulta);

                $consultaList['facturas'][] = $factura_consulta;
                $monto_total_consultas_bs += $factura_consulta['monto_consulta_bs'];
                $monto_total_consultas_usd += $factura_consulta['monto_consulta_usd'];

            } else {
                $consulta_info = FacturaConsultaHelpers::obtenerInformacion($factura);
                $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
                $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);

                $consultaList[] = array_merge($consulta_info, $insumos_consulta, $examenes_consulta);
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
            "factura_consulta.metodo_pago",
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

        $consulta_info = FacturaConsultaHelpers::obtenerInformacion($factura);
        $insumos_consulta = FacturaConsultaHelpers::obtenerInsumos($factura);
        $examenes_consulta = FacturaConsultaHelpers::obtenerExamenes($factura);

        $factura_consulta = array_merge($consulta_info, $insumos_consulta, $examenes_consulta);
        return FacturaConsultaHelpers::obtenerMontoTotal($factura_consulta);

        // return FacturaConsultaHelpers::obtenerMontoTotal( array ($factura_consulta));
    }
}