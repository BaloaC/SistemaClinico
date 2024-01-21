<?php

class GlobalController extends Controller{

    //Método index (vista principal)
    // public function index(){

    //     return $this->view('facturas/index');
    // }

    // public function formRegistrarFacturas(){

    //     return $this->view('facturas/registrarFacturas');
    // }

    // public function formActualizarFactura($idFactura){
        
    //     return $this->view('facturas/actualizarFacturas', ['idFactura' => $idFactura]);
    // } 
    public function obtenerGlobals() {
        $_globalModel = new GlobalModel();
        $global_lista = $_globalModel->getAll();
        $respuesta = new Response($global_lista != null ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($global_lista);
        return $respuesta->json($global_lista != null ? 200 : 400);
    }

    public function actualizarPorcentaje(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if (!is_numeric($_POST['porcentaje_medico'])) {
            $respuesta = new Response(false, 'El porcentaje debe ser numérico');
            return $respuesta->json(400);
        }

        $_globalModel = new GlobalModel();
        $fueActualizado = $_globalModel->where('global.key', '=', "porcentaje_medico")->update(array("value" => $_POST['porcentaje_medico']));
        
        $bool = ($fueActualizado > 0);

        $respuesta = new Response($bool ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($bool ? 200 : 400);
    }

    public function actualizarValorDivisa() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        if (!is_numeric($_POST['cambio_divisa'])) {
            $respuesta = new Response(false, 'El valor debe ser numérico');
            return $respuesta->json(400);
        }

        $_globalModel = new GlobalModel();
        $fueActualizado = $_globalModel->where('global.key', '=', "cambio_divisa")->update(array("value" => $_POST['cambio_divisa']));
        
        $bool = ($fueActualizado > 0);

        $respuesta = new Response($bool ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($bool ? 200 : 400);
    }
}

?>