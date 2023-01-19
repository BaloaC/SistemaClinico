<?php

class InsumoController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('insumos/index');
    }

    public function formRegistrarInsumo(){

        return $this->view('insumos/registrarInsumos');
    }

    public function formActualizarInsumo($insumo_id){
        
        return $this->view('insumos/actualizarInsumos', ['insumo_id' => $insumo_id]);
    } 

    public function insertarInsumo(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $camposNumericos = array("precio");
        $validarInsumo = new Validate;

        switch($validarInsumo) {
            case ($validarInsumo->isEmpty($_POST)):
               $respuesta = new Response('DATOS_VACIOS');
               return $respuesta->json(400);
       
            case $validarInsumo->isDuplicated('insumo', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarInsumo->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(404);

            default:
                
                $data = $validarInsumo->dataScape($_POST);
                $_insumoModel = new InsumoModel();
                $id = $_insumoModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarInsumo(){

        $_insumoModel = new InsumoModel();
        $lista = $_insumoModel->where('estatus_ins', '=', '1')->getAll();
        $mensaje = (count($lista) > 0);
        return $this->retornarMensaje($mensaje, $lista);
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        // $respuesta->setData($lista);
        // return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarInsumoPorId($insumo_id){

        $_insumoModel = new InsumoModel();
        $insumo = $_insumoModel->where('estatus_ins', '=', '1')->where('insumo_id','=',$insumo_id)->getFirst();
        $mensaje = ($insumo != null);
        return $this->retornarMensaje($mensaje, $insumo);
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        // $respuesta->setData($insumo);
        // return $respuesta->json($mensaje ? 200 : 404);
    }

    public function eliminarInsumo($insumo_id){

        $_insumoModel = new InsumoModel();
        $data = array(
            "estatus_ins" => "2"
        );

        $eliminado = $_insumoModel->where('insumo_id','=',$insumo_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);
        return $respuesta->json($mensaje ? 200 : 404);

    }

    // Funciones
    public function retornarMensaje($mensaje, $dataReturn) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($dataReturn);
        return $respuesta->json($mensaje ? 200 : 404);
    }
}



?>