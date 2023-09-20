<?php

include_once './services/facturas/mensajeria/FacturaMensajeriaHelpers.php';
include_once './services/facturas/consulta seguro/ConsultaSeguroService.php';

class FacturaMensajeriaService {

    public static $arraySelect = array(
        // "factura_mensajeria.factura_mensajeria_id",
        // "factura_mensajeria.fecha_mensajeria",
        // "factura_mensajeria.total_mensajeria_bs",
        // "factura_mensajeria.total_mensajeria_usd",
        // "factura_mensajeria.seguro_id",
        "seguro.nombre AS nombre_seguro",
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

    public static function listarFacturas($facturas) {

        $_facturaMensajeriaConsultas = new FacturaMensajeriaConsultasModel();

        foreach ($facturas as $factura) {

            $inners = $_facturaMensajeriaConsultas->listInner(FacturaMensajeriaService::$arrayInner);
            $factura->consultas = $_facturaMensajeriaConsultas->where('factura_mensajeria_consultas.factura_mensajeria_id', '=', $factura->factura_mensajeria_id)
                                                            ->innerJoin(FacturaMensajeriaService::$arraySelect, $inners, 'factura_mensajeria_consultas');
            
            $consultas_seguro = [];
            foreach ($factura->consultas as $consultas) {

                $informacionConsulta = ConsultaSeguroService::listarConsultasSeguroId($consultas->consulta_seguro_id);
                $consultas_seguro[] = array_merge( (array) $consultas, (array) $informacionConsulta[0] );
            }

            $factura->consultas = $consultas_seguro;
        }
        
        return $factura;
    }
}