<?php

class CompraInsumoController extends Controller {

    public function insertarCompraInsumo($POST, $facturaId){

        
        $id = $facturaId;
        $validarFactura = new Validate;
        $camposNumericos = array('unidades','precio_unit','precio_total');
        $camposKey = array('insumo_id');

        $token = $validarFactura->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        foreach ($POST as $POSTS) {
            
            $POSTS['factura_compra_id'] = $id;

            switch ($POSTS) {
                case ($validarFactura->isEmpty($POSTS)):
                    $respuesta = new Response(false, 'No se pueden enviar datos vacíos en los insumos');
                    return $respuesta->json(400);
    
                case $validarFactura->isNumber($POSTS, $camposNumericos):
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                
                case (!$validarFactura->existsInDB($POSTS, $camposKey)):
                    $respuesta = new Response(false, 'No se encontraron resultados del insumo o la factura indicada');
                    return $respuesta->json(404);

                case $validarFactura->isEliminated('insumo', 'estatus_ins',$id):
                    $respuesta = new Response(false, 'No se encontraron resultados del insumo indicado');
                    return $respuesta->json(404);
                
                default:
                    $data = $validarFactura->dataScape($POSTS);

                    $_compraInsumoModel = new CompraInsumoModel();
                    $_compraInsumoModel->byUser($token);
                    $respuesta = $_compraInsumoModel->insert($data);

                    $mensaje = ($respuesta > 0);

                    if ($mensaje) {

                        // Sumando la cantidad de la factura al stock del inventario
                        $_insumoModel = new InsumoModel();
                        $insumo = $_insumoModel->where('insumo_id', '=', $POSTS['insumo_id'])->getFirst();
                        $unidadesPosts = $POSTS['unidades'] + $insumo->stock;
                        $actualizar = array('stock' => $unidadesPosts);
                        
                        // actualizando el stock del insumo
                        $_insumoModel = new InsumoModel();
                        $_insumoModel->byUser($token);
                        $actualizado = $_insumoModel->where('insumo_id', '=', $POSTS['insumo_id'])->update($actualizar);
                        if (!$actualizado) {
                            $this->mensajeError($POSTS);
                        }

                    } else if (!$mensaje) {
                        $this->mensajeError($POSTS);
                    }
            }
        }
        return false;
    }

    public function listarCompraInsumoPorFactura($factura_id){

        $arrayInner = array(
            "insumo" => "compra_insumo"
        );

        $arraySelect = array(
            "insumo.nombre AS insumo_nombre", 
            "compra_insumo.unidades", 
            "compra_insumo.precio_unit", 
            "compra_insumo.precio_total" 
        );

        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($arrayInner);
        $compra_insumo = $_compraInsumoModel->where('compra_insumo.factura_compra_id','=',$factura_id)->innerJoin($arraySelect, $inners, "compra_insumo");

        return $compra_insumo;
    }

    // funciones para reutilizar
    public function mensajeError($POSTS) {
        $respuesta = new Response(false, 'Hubo un error en el registro del insumo');
        $respuesta->setData($POSTS);
        return $respuesta->json(400);
    }
}
?>