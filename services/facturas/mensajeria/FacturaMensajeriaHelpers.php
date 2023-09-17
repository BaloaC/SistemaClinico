<?php

include_once './services/facturas/consulta seguro/ConsultaSeguroService.php';

class FacturaMensajeriaHelpers {

    public static function calcularTotal($consultas) {
        
        $monto = array(
            "monto_total_bs" => 0, 
            "monto_total_usd" => 0
        );

        foreach ($consultas as $consulta) {
            
            $consulta = ConsultaSeguroService::listarConsultasSeguroId($consulta['consulta_seguro_id']);

            $monto['monto_total_usd'] += $consulta[0]['monto_total_usd'];
            $monto['monto_total_bs'] += $consulta[0]['monto_total_bs'];
        }
        
        return $monto;
    }
}