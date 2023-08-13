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
}

?>