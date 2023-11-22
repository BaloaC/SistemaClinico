<?php

class FacturaInsumosValidaciones {

    public static function validacionesFactura($formulario) {
        
        $validarFactura = new Validate;
        $camposNumericos = array('proveedor_id', 'total_productos', 'monto_con_iva', 'monto_sin_iva', 'excento');

        if ( ($validarFactura->isEmpty($formulario)) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarFactura->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            $respuesta->setData('Los siguientes datos deben ser numéricos: '.$camposNumericos);
            echo $respuesta->json(400);
            exit();
        }

        if ( !$validarFactura->isDuplicated('proveedor', 'proveedor_id', $formulario["proveedor_id"]) ) {
            $respuesta = new Response(false, 'No se encontraron registros del proveedor indicado');
            $respuesta->setData('Proveedor_id : '.$formulario["proveedor_id"]);
            echo $respuesta->json(200);
            exit();
        }

        if ( $validarFactura->isDate($formulario['fecha_compra']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            $respuesta->setData($formulario['fecha_compra']);
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarFactura->isToday($formulario['fecha_compra'], false) ) {
            $respuesta = new Response(false, 'La fecha de la factura no puede ser posterior a la fecha actual');
            $respuesta->setData($formulario['fecha_compra']);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarInsumo($formulario) {

        $camposNumericos = array('unidades', 'precio_unit_bs', 'precio_total_bs');
        $validarFactura = new Validate;

        foreach ($formulario as $insumo) {
            
            if ( $validarFactura->isEmpty($insumo) ) {
                $respuesta = new Response(false, 'No se pueden enviar datos vacíos en los insumos');
                $respuesta->setData($insumo);
                echo $respuesta->json(400);
                exit();
            }
    
            if ( $validarFactura->isNumber($insumo, $camposNumericos) ) {
                $respuesta = new Response('DATOS_INVALIDOS');
                $respuesta->setData($insumo);
                echo $respuesta->json(400);
                exit();
            }
            
            if ( !$validarFactura->isDuplicated('insumo', 'insumo_id', $insumo['insumo_id']) ) {
                $respuesta = new Response(false, 'No se encontraron resultados del insumo o la factura indicada');
                $respuesta->setData($insumo['insumo_id']);
                echo $respuesta->json(404);
                exit();
            }
        }
    }
}