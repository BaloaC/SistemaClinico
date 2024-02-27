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
            
            ConsultaSeguroHelpers::actualizarConsultaSeguro($consulta);

            $consulta['factura_mensajeria_id'] = $factura_mensajeria_id;
            $_facturaMensajeriaConsultasModel = new FacturaMensajeriaConsultasModel();
            $consulta = $_facturaMensajeriaConsultasModel->insert($consulta);

            if($consulta <= 0) {
                $respuesta = new Response(false, 'Ha ocurrido un error insertando la consulta_id '.$consulta['consulta_seguro_id']);
                echo $respuesta->json(400);
            }
        }
    }

    public static function actualizarFactura($factura_mensajeria_id) {
        $_facturaMensajeriaModel = new FacturaMensajeriaModel();
        $factura_mensajeria = $_facturaMensajeriaModel->where('factura_mensajeria_id', '=', $factura_mensajeria_id)->getFirst();

        FacturaMensajeriaValidaciones::validarEstatusFactura($factura_mensajeria);
        
        $_facturaMensajeriaConsultasModel = new FacturaMensajeriaConsultasModel();
        $factura_mensajeria_consultas = $_facturaMensajeriaConsultasModel->where('factura_mensajeria_id', '=', $factura_mensajeria_id)->getAll();

        foreach ($factura_mensajeria_consultas as $consultas) {
            $_consultaSeguroModel = new ConsultaSeguroModel();
            $consulta_seguro = $_consultaSeguroModel->where('consulta_seguro_id', '=', $consultas->consulta_seguro_id)->getFirst();

            $seActualizo = $_consultaSeguroModel->update(['estatus_con' => 3]);
            
            if (!$seActualizo) {
                $respuesta = new Response(false, 'Ocurrió un error actualizando la factura mensajería');
                echo $respuesta->json(400);
                exit();
            }
        }
    
        if ($seActualizo) {
            $seActualizoFactura =  $_facturaMensajeriaModel->where('factura_mensajeria_id', '=', $factura_mensajeria_id)->update(['estatus_fac' => 3]);
        }
    }

    public static function listarFacturas($facturas) {

        $facturaLista = [];

        foreach ($facturas as $factura) {
            $facturaLista[] = FacturaMensajeriaHelpers::obtenerDetallesConsulta($factura);
        }
        
        return $facturaLista;
    }

    public static function listarFacturaMensajeriaId($factura) {

        $factura = FacturaMensajeriaHelpers::obtenerDetallesConsulta($factura);        
        return $factura;
    }
}