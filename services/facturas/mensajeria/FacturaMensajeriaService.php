<?php

include_once './services/facturas/mensajeria/FacturaMensajeriaHelpers.php';

class FacturaMensajeriaService {

    public static function insertarFactura($formulario) {

        $factura_total = FacturaMensajeriaHelpers::calcularTotal($formulario['consultas']);
        
        $formulario['total_mensajeria_bs'] = $factura_total['monto_total_bs'];
        $formulario['total_mensajeria_usd'] = $factura_total['monto_total_usd'];

        $_facturaMensajeriaModel = new FacturaMensajeriaModel();
        $factura_mensajeria_id = $_facturaMensajeriaModel->insert($formulario);
        
        if ($factura_mensajeria_id <= 0) {
            $respuesta = new Response('INSERCION_FALLIDA');
        return $respuesta->json(201);
        }

        foreach ($formulario['consultas'] as $consulta) {
            
            $consulta['factura_mensajeria_id'] = $factura_mensajeria_id;
            $_facturaMensajeriaConsultasModel = new FacturaMensajeriaConsultasModel();
            $consulta = $_facturaMensajeriaConsultasModel->insert($consulta);

            if($consulta <= 0) {
                $respuesta = new Response(false, 'Ha ocurrido un error insertando la consulta_id '.$consulta['consulta_seguro_id']);
                echo $respuesta->json(400);
            }
        }
    }
}