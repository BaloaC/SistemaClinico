<?php

class FacturaInsumoHelpers {

    public static function insertarCompraInsumo($formulario, $factura_id) {
        
        $validarFactura = new Validate;
        
        foreach ($formulario as $insumo) {
            
            $insumo['factura_compra_id'] = $factura_id;

            $insumoNuevo = $validarFactura->dataScape($insumo);

            $_compraInsumoModel = new CompraInsumoModel();
            
            $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
            $insumoNuevo['precio_unit_usd'] = round( $insumoNuevo['precio_unit_bs'] / $valorDivisa, 2);
            $insumoNuevo['precio_total_usd'] = round( $insumoNuevo['precio_total_bs'] / $valorDivisa, 2);

            $respuesta = $_compraInsumoModel->insert($insumoNuevo);

            $mensaje = ($respuesta > 0);

            if ($mensaje) {

                // Sumando la cantidad de la factura al stock del inventario
                $_insumoModel = new InsumoModel();
                $insumo = $_insumoModel->where('insumo_id', '=', $insumoNuevo['insumo_id'])->getFirst();

                $unidadesPosts = $insumoNuevo['unidades'] + $insumo->cantidad;
                $actualizar = array('cantidad' => $unidadesPosts);
                
                // actualizando el stock del insumo
                $_insumoModel = new InsumoModel();
                $actualizado = $_insumoModel->where('insumo_id', '=', $insumoNuevo['insumo_id'])->update($actualizar);

                if (!$actualizado) {
                    $respuesta = new Response(false, 'Hubo un error en el registro del insumo');
                    $respuesta->setData($insumoNuevo);
                    echo $respuesta->json(400);
                    exit();
                }

            } else if (!$mensaje) {
                $respuesta = new Response(false, 'Hubo un error en el registro del insumo');
                $respuesta->setData($insumoNuevo);
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function listarInsumoPorFactura($factura_id) {
        $arrayInner = array(
            "insumo" => "compra_insumo"
        );

        $arraySelect = array(
            "insumo.nombre AS insumo_nombre", 
            "compra_insumo.unidades", 
            "compra_insumo.precio_unit_bs", 
            "compra_insumo.precio_total_bs",
            "compra_insumo.precio_unit_usd", 
            "compra_insumo.precio_total_usd" 
        );

        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($arrayInner);
        $compra_insumo = $_compraInsumoModel->where('compra_insumo.factura_compra_id','=',$factura_id)->innerJoin($arraySelect, $inners, "compra_insumo");

        return $compra_insumo;
    }
}