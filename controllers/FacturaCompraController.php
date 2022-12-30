<?php

class FacturaCompraController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/index');
    }

    public function formRegistrarFacturas(){

        return $this->view('facturas/registrarFacturas');
    }

    public function formActualizarFactura($idFactura){
        
        return $this->view('facturas/actualizarFacturas', ['idFactura' => $idFactura]);
    } 

    public function insertarFacturaCompra(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        $camposNumericos = array('proveedor_id', 'total_productos', 'monto_con_iva', 'monto_sin_iva', 'excento');
        
        switch ($validarFactura) {
            case ($validarFactura->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarFactura->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarFactura->isDuplicated('proveedor', 'proveedor_id', $_POST["proveedor_id"]):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarFactura->isDate($_POST['fecha_compra']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarFactura->isToday($_POST['fecha_compra'], false):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);
            
            default:
                $insumos = $_POST['insumos'];
                
                unset($_POST['insumos']);
                $data = $validarFactura->dataScape($_POST);

                $_facturaCompraModel = new FacturaCompraModel();
                $id = $_facturaCompraModel->insert($data);
                $mensaje = ($id > 0);

                if ($mensaje) {
                    
                    $_compraInsumoController = new CompraInsumoController;
                    $respuestaInsumo = $_compraInsumoController->insertarCompraInsumo($insumos, $id);
                    
                    if (!$respuestaInsumo) {
                        
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    } else {
                        $_facturaCompraModel->where('factura_compra_id','=',$id)->delete();
                        return $respuestaInsumo;
                    }


                } else {

                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarFacturaCompra(){

        $arrayInner = array(
            "proveedor" => "factura_compra"
        );

        $arraySelect = array(
            "factura_compra.factura_compra_id",
            "factura_compra.fecha_compra",
            "factura_compra.monto_con_iva",
            "factura_compra.monto_sin_iva",
            "factura_compra.iva",
            "factura_compra.excento",
            "factura_compra.estatus_fac",
            "proveedor.nombre AS proveedor_nombre"
        );

        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($arrayInner);
        $factura_compra = $_compraInsumoModel->innerJoin($arraySelect, $inners, "factura_compra");
        
        $resultadoFactura = array();

        foreach ($factura_compra as $facturas) {

            // Codigo para recibir los insumos que fueron comprados con esa factura
            $_compraInsumoController = new CompraInsumoController;
            $insumosFactura = $_compraInsumoController->listarCompraInsumoPorFactura($facturas->factura_compra_id);

            $facturas->insummos = $insumosFactura;
            $resultadoFactura[] = $facturas;
        }
        
        $respuesta = new Response($resultadoFactura ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultadoFactura);
        return $respuesta->json($resultadoFactura ? 200 : 404);
    }

    public function listarFacturaCompraPorId($factura_id){

        $arrayInner = array(
            "proveedor" => "factura_compra"
        );

        $arraySelect = array(
            "factura_compra.factura_compra_id",
            "factura_compra.fecha_compra",
            "factura_compra.monto_con_iva",
            "factura_compra.monto_sin_iva",
            "factura_compra.iva",
            "factura_compra.excento",
            "factura_compra.estatus_fac",
            "proveedor.nombre AS proveedor_nombre"
        );

        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($arrayInner);
        $factura_compra = $_compraInsumoModel->where('factura_compra_id', '=', $factura_id)->innerJoin($arraySelect, $inners, "factura_compra");
        
        // Codigo para recibir los insumos que fueron comprados con esa factura
        $_compraInsumoController = new CompraInsumoController;
        $insumosFactura = $_compraInsumoController->listarCompraInsumoPorFactura($factura_compra[0]->factura_compra_id);
    
        $factura_compra[0]->insumos = $insumosFactura;
        $resultado = $factura_compra[0];
        
        $respuesta = new Response($resultado ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);
        return $respuesta->json($resultado ? 200 : 404);
    }

    public function eliminarFacturaCompra($factura_compra_id){

        $_facturaModel = new FacturaModel();
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_facturaModel->where('factura_compra_id','=',$factura_compra_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>