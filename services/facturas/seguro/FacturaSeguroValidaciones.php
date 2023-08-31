<?php


class FacturaSeguroValidaciones {

    public static function validarFacturaId($factura_seguro_id) {
        $validarFactura = new Validate;

        if ( !$validarFactura->isDuplicated('factura_seguro', 'factura_seguro_id', $factura_seguro_id) ) {
            $respuesta = new Response(false, 'No se encontró la factura indicada en la base de datos');
            $respuesta->setData("Error en factura seguros con el id $factura_seguro_id");
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarLengthFactura($facturas) {
        if(empty($facturas["factura"])) {
            $respuesta = new Response(false, 'No se encontró factura en la fecha solicitada');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarEstatusFactura($factura_seguro) {
        if ($factura_seguro->estatus_fac != '1') {
            $respuesta = new Response(false, 'No puede realizar operaciones con una factura ya cancelada o eliminada');
            $respuesta->setData("Error al actualizar la factura $factura_seguro->factura_seguro_id con estatus ".($factura_seguro->estatus_fac == '2' ? 'anulada' : 'pagado'));
            echo $respuesta->json(400);
            exit();
        }
    }
}