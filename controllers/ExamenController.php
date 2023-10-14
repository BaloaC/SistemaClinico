<?php

include_once "./services/examen/ExamenValidaciones.php";

class ExamenController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('examenes/index');
    }

    public function formRegistrarExamenes(){

        return $this->view('examenes/registrarExamenes');
    }

    public function formActualizarExamen($examen_id){
        
        return $this->view('examenes/actualizarExamenes', ['examenes_id' => $examen_id]);
    } 

    public function insertarExamen(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $validarExamen = new Validate;
        ExamenValidaciones::validarExamen($_POST);

        $data = $validarExamen->dataScape($_POST);    

        $_examenModel = new ExamenModel();
        $id = $_examenModel->insert($data);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        return $respuesta->json($mensaje ? 201 : 400);
    }

    public function listarExamen(){

        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('estatus_exa', '=', '1')->getAll();

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarExamenPorId($examen_id){

        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('examen_id', '=', $examen_id)->where('estatus_exa', '=', '1')->getFirst();

        $mensaje = ($lista != null);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarExamenDeLaboratorios(){
        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('estatus_exa', '=', '1')->where('tipo', '=', '2')->getAll();

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function actualizarExamen($examen_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $exclude = array('hecho_aqui');
        $validarExamen = new Validate;

        switch ($validarExamen) {
            case $validarExamen->isEmpty($_POST, $exclude):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
            
            case !($validarExamen->isDuplicated('examen', 'examen_id', $examen_id)):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case ($validarExamen->isDuplicated('examen', 'nombre', isset($_POST['nombre']))):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
                $data = $validarExamen->dataScape($_POST);    

                if ( array_key_exists("hecho_aqui", $data) && $data["hecho_aqui"] != 0 && $data["hecho_aqui"] != 1) {
                    $respuesta = new Response(false, 'El campo hecho aqui solo permite valores booleanos');
                    return $respuesta->json(400);
                }

                $_examenModel = new ExamenModel();
                $id = $_examenModel->where('examen_id', '=', $examen_id)->update($data);
                $mensaje = ($id > 0);
        
                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        
                return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarExamen($examen_id){

        $validarExamen = new Validate;

        $_examenModel = new ExamenModel();
        $data = array (
            "estatus_exa" => "2"
        );

        $eliminado = $_examenModel->where('examen_id','=',$examen_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
