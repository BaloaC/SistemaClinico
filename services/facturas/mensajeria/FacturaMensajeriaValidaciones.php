<?php

class FacturaMensajeriaValidaciones {

    /**
     * Validaciones para insertar consultas por emergencia
     */
    public static function validarFactura($formulario) {
        
        $camposId = array("seguro_id");
        $validarFactura = new Validate;
        
        if ( !$validarFactura->existsInDB($formulario, $camposId) ) {
            $respuesta = new Response('NOT_FOUND');
            echo $respuesta->json(400);
            exit();

        } else if ( $validarFactura->isEmpty($formulario) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        // Validamos las consultas
        foreach ($formulario['consultas'] as $consulta) {
            
            if ( !$validarFactura->isDuplicated('consulta_seguro', 'consulta_seguro_id', $consulta['consulta_seguro_id']) ) {
                $respuesta = new Response(false, 'La consulta indicada no se encuentra en el sistema');
                $respuesta->setData('Problemas con la consulta '.$consulta['consulta_seguro_id']);
                echo $respuesta->json(400);
                exit();

            } else {

                $_consultaSeguroModel = new ConsultaSeguroModel();
                $consulta_seguro = $_consultaSeguroModel->where('consulta_seguro_id', '=', $consulta['consulta_seguro_id'])->getFirst();
                
                if ($consulta_seguro->seguro_id != $formulario['seguro_id']) {
                    $respuesta = new Response(false, 'La consulta indicada no está relacionada a ese seguro');
                    $respuesta->setData('La consulta_seguro_id '.$consulta['consulta_seguro_id'].' no está facturada con ese seguro');
                    echo $respuesta->json(400);
                    exit();     
                }
            }
        }
    }

    public static function validarEstatusFactura($factura) {
        if ($factura->estatus_fac == 2) {
            $respuesta = new Response(false, 'Esa factura ya se encuentra marcada como pagada');
            echo $respuesta->json(400);
            exit();
        }
    }
}