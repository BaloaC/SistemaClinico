<?php


class FacturaSeguroHelpers {

    /**
     * Función para calcular facturas por seguro
     */
    public static function innerFacturaSeguro($seguro_id, $mes, $anio) {
        
        $consultaInner = array (
            "consulta" => "consulta_seguro"
        );
    
        $consultaSelect = array(
            "consulta.consulta_id",
            "consulta.fecha_consulta",
            "consulta_seguro.consulta_seguro_id",
            "consulta_seguro.seguro_id",
            "consulta_seguro.tipo_servicio",
            "consulta_seguro.fecha_ocurrencia",
            "consulta_seguro.monto_consulta_usd",
            "consulta_seguro.monto_consulta_bs",
            "consulta_seguro.estatus_con"
        );

        $_consultaSeguro = new ConsultaSeguroModel();
        
        $inners = $_consultaSeguro->listInner($consultaInner);
        $consultaList = $_consultaSeguro->where('consulta_seguro.estatus_con', '=', '1')
                                        ->where('consulta_seguro.seguro_id', '=', $seguro_id)
                                        ->where('YEAR(consulta_seguro.fecha_ocurrencia)', '=', $anio)
                                        ->where('MONTH(consulta_seguro.fecha_ocurrencia)', '=', $mes)
                                        ->innerJoin($consultaSelect, $inners, "consulta_seguro");

        return $consultaList;
    }

    public static function comprobarExistenciaFactura($seguro_id, $mes, $anio) {
        $_facturaSeguro = new FacturaSeguroModel();

        $factura = $_facturaSeguro->where('seguro_id', '=', $seguro_id)
                                    ->where('YEAR(fecha_ocurrencia)', '=', $anio)
                                    ->where('MONTH(fecha_ocurrencia)', '=', $mes)
                                    ->getFirst();

        $siExiste = is_null($factura) ? false : true;
        return $siExiste;
    }

    public static function retornarMensaje($resultadoSentencia) {
        
        $bool = (count($resultadoSentencia) > 0);

        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultadoSentencia);
        return $respuesta->json(200);
    }
}