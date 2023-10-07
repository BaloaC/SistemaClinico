<?php

include_once './services/facturas/consulta seguro/ConsultaSeguroService.php';
include_once './services/globals/GlobalsHelpers.php';

class FacturaMensajeriaHelpers {

    public static $arraySelect = array(
        // "factura_mensajeria.factura_mensajeria_id",
        // "factura_mensajeria.fecha_mensajeria",
        // "factura_mensajeria.total_mensajeria_bs",
        // "factura_mensajeria.total_mensajeria_usd",
        // "factura_mensajeria.seguro_id",
        "seguro.nombre AS nombre_seguro",
        "seguro.rif AS rif_seguro",
        "factura_mensajeria_consultas.factura_mensajeria_id",
        "factura_mensajeria_consultas.factura_mensajeria_consultas_id",
        "factura_mensajeria_consultas.consulta_seguro_id",
        "consulta_seguro.consulta_id"
    );

    public static $arrayInner = array(
        "factura_mensajeria" => "factura_mensajeria_consultas",
        "seguro" => "factura_mensajeria",
        "consulta_seguro" => "factura_mensajeria_consultas"
    );

    public static function calcularTotal($consultas) {
        
        $monto = array(
            "monto_total_bs" => 0, 
            "monto_total_usd" => 0
        );

        foreach ($consultas as $consulta) {
            
            $consulta = ConsultaSeguroService::listarConsultasSeguroId($consulta['consulta_seguro_id']);
            $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

            if ( !isset($consulta[0]['monto_total_usd']) ) {
                $monto['monto_total_usd'] = $consulta[0]["factura"]->total_consulta;
                $monto['monto_total_bs'] = round( $consulta[0]["factura"]->total_consulta * $valorDivisa , 2);
                
                
            } else {
                $monto['monto_total_usd'] += $consulta[0]['monto_total_usd'];
                $monto['monto_total_bs'] += round( $consulta[0]['monto_total_usd'] * $valorDivisa, 2);
            }
        }
        
        return $monto;
    }

    public static function obtenerDetallesConsulta($factura) {

        $_facturaMensajeriaConsultas = new FacturaMensajeriaConsultasModel();
        $inners = $_facturaMensajeriaConsultas->listInner(FacturaMensajeriaHelpers::$arrayInner);

        $factura->consultas = $_facturaMensajeriaConsultas->where('factura_mensajeria_consultas.factura_mensajeria_id', '=', $factura->factura_mensajeria_id)
                                                        ->innerJoin(FacturaMensajeriaHelpers::$arraySelect, $inners, 'factura_mensajeria_consultas');
        
        $consultas_seguro = [];
        foreach ($factura->consultas as $consultas) {

            $informacionConsulta = ConsultaSeguroService::listarConsultasSeguroId($consultas->consulta_seguro_id);
            $consultas_seguro[] = array_merge( (array) $consultas, (array) $informacionConsulta[0] );
        }

        $factura->consultas = $consultas_seguro;

        return $factura;
    }
}