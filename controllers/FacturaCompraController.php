<?php

class FacturaCompraController extends Controller
{

    protected $arrayInner = array(
        "proveedor" => "factura_compra"
    );

    protected $arraySelect = array(
        "factura_compra.factura_compra_id",
        "factura_compra.fecha_compra",
        "factura_compra.monto_con_iva",
        "factura_compra.monto_sin_iva",
        "factura_compra.excento",
        "factura_compra.estatus_fac",
        "proveedor.nombre AS proveedor_nombre"
    );

    //Método index (vista principal)
    public function index() {
        return $this->view('facturas/index');
    }

    public function formRegistrarFacturas() {
        return $this->view('facturas/registrarFacturas');
    }

    public function formActualizarFactura($idFactura) {
        return $this->view('facturas/actualizarFacturas', ['idFactura' => $idFactura]);
    }

    public function insertarFacturaCompra(/*Request $request*/) {

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
                return $respuesta->json(200);

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
                        $_facturaCompraModel->where('factura_compra_id', '=', $id)->delete();
                        return $respuestaInsumo;
                    }
                } else {

                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function actualizarFacturaCompra($factura_id) {
                
        $_compraInsumoController = new FacturaCompraModel();
        $factura_compra = $_compraInsumoController->where('factura_compra_id', '=', $factura_id)->getFirst();

        if ($factura_compra->estatus_fac != '1') {
            $respuesta = new Response(false, 'No puede realizar operaciones con una factura ya cancelada o eliminada');
            $respuesta->setData("Error al actualizar la factura $factura_id con estatus ".($factura_compra->estatus_fac == '2' ? 'anulada' : 'pagado'));
            return $respuesta->json(400);
        }

        $data = array(
            'estatus_fac' => '3'
        );
        
        $actualizado = $_compraInsumoController->where('factura_compra_id', '=', $factura_id)->update($data);
        return $this->mensajeActualizaciónExitosa($actualizado);
    }

    public function listarFacturaCompra() {
        
        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($this->arrayInner);

        if ( array_key_exists('date', $_GET) ) {
            
            $fecha_mes = DateTime::createFromFormat('Y-m-d', $_GET['date']);
            $fecha_mes->modify('first day of this month');
            $fecha_inicio = $fecha_mes->format("Y-m-d");
            
            $fecha_mes->modify('last day of this month');
            $fecha_fin = $fecha_mes->format("Y-m-d");
            
            $factura_compra = $_compraInsumoModel->whereDate('fecha_compra', $fecha_inicio, $fecha_fin)
                                                ->innerJoin($this->arraySelect, $inners, "factura_compra");

        } else {
            $factura_compra = $_compraInsumoModel->innerJoin($this->arraySelect, $inners, "factura_compra");
        }

        $resultadoFactura = array();

        if ($factura_compra) {

            $total_factura_iva = 0;
            $total_factura = 0;
            foreach ($factura_compra as $facturas) {

                if ( array_key_exists('date', $_GET) ) { // Si es el reporte por mes añadimos el total
                    $total_factura_iva += $facturas->monto_con_iva;
                    $total_factura += $facturas->monto_sin_iva;
                }

                // Codigo para recibir los insumos que fueron comprados con esa factura
                $_compraInsumoController = new CompraInsumoController;
                $insumosFactura = $_compraInsumoController->listarCompraInsumoPorFactura($facturas->factura_compra_id);

                $facturas->insummos = $insumosFactura;

                if ( array_key_exists('date', $_GET) ) { // Si es el reporte por mes añadimos el total
                    $resultadoFactura['facturas'][] = $facturas;

                } else {
                    $resultadoFactura[] = $facturas;
                }
            }

            if ( array_key_exists('date', $_GET) ) { // Si es el reporte por mes añadimos el total
                $resultadoFactura['monto_total'] = round($total_factura, 2);
                $resultadoFactura['monto_total_iva'] = round($total_factura_iva, 2);
            }

            return $this->retornarMensaje($resultadoFactura);
        } else {

            return $this->retornarMensaje($factura_compra);
        }
    }

    public function listarFacturaCompraPorId($factura_id) {

        $_compraInsumoModel = new CompraInsumoModel();
        $inners = $_compraInsumoModel->listInner($this->arrayInner);
        $factura_compra = $_compraInsumoModel->where('factura_compra_id', '=', $factura_id)->innerJoin($this->arraySelect, $inners, "factura_compra");

        if ($factura_compra) {
            // Codigo para recibir los insumos que fueron comprados con esa factura
            $_compraInsumoController = new CompraInsumoController;
            $insumosFactura = $_compraInsumoController->listarCompraInsumoPorFactura($factura_compra[0]->factura_compra_id);

            $factura_compra[0]->insumos = $insumosFactura;
            $resultado = $factura_compra[0];

            return $this->retornarMensaje($resultado);
        } else {

            return $this->retornarMensaje($factura_compra);
        }
    }

    public function eliminarFacturaCompra($factura_compra_id) {
        
        $_compraInsumoController = new FacturaCompraModel();
        $data = array(
            'estatus_fac' => '2'
        );

        $eliminado = $_compraInsumoController->where('factura_compra_id', '=', $factura_compra_id)->update($data);
        return $this->mensajeActualizaciónExitosa($eliminado);
    }

    // funciones
    public function retornarMensaje($resultado) {

        $respuesta = new Response($resultado ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);
        return $respuesta->json(200);
    }

    public function mensajeActualizaciónExitosa($update) {
        $isTrue = ($update > 0);
        $respuesta = new Response($isTrue ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($isTrue ? 200 : 400);
    }
}
