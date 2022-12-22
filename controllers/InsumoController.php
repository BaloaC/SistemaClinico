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
        $validacion = $this->validacion($_POST);

        if (!$validacion) {
            
            $validarInsumo = new Validate;
            $data = $validarInsumo->dataScape($_POST);

            $_insumoModel = new InsumoModel();
            $id = $_insumoModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
            return $respuesta->json($mensaje ? 201 : 400);

        } else { return $validacion; }        
    }

    public function actualizarInsumo($insumo_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validacion = $this->validacion($_POST);

        if (!$validacion) {
            
            $validarInsumo = new Validate;
            $data = $validarInsumo->dataScape($_POST);

            $_insumoModel = new InsumoModel();
            $actualizado = $_insumoModel->where('estatus_ins','=','2')->where('insumo_id','=',$insumo_id)->update($_POST);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);

            return $respuesta->json($mensaje ? 200 : 404);

        } else { return $validacion; }
    }

    public function listarInsumo(){

        $_insumoModel = new InsumoModel();
        $lista = $_insumoModel->where('estatus_ins', '=', '2')->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);
        return $respuesta->json($mensaje ? 200 : 404);

    }

    public function listarInsumoPorId($insumo_id){

        $_insumoModel = new InsumoModel();
        $insumo = $_insumoModel->where('estatus_ins', '=', '1')->where('insumo_id','=',$insumo_id)->getFirst();
        $mensaje = ($insumo != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($insumo);
        return $respuesta->json($mensaje ? 200 : 404);
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

    // Método con las validaciones generales de los formularios
    public function validacion($data) {

        $camposNumericos = array("precio");
        $validarInsumo = new Validate;

        switch($data) {
            case ($validarInsumo->isEmpty($data)):
               $respuesta = new Response('DATOS_VACIOS');
               return $respuesta->json(400);
       
            case $validarInsumo->isDuplicated('insumo', 'nombre', $data["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarInsumo->isNumber($data, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            default:
                return false;
        }

    }
}



?>