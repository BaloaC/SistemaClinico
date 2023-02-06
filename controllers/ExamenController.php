<?php

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

        switch ($validarExamen) {
            case ($validarExamen->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
            
            case ($validarExamen->isDuplicated('examen', 'nombre', $_POST['nombre'])):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
                $data = $validarExamen->dataScape($_POST);    

                $_examenModel = new ExamenModel();
                $id = $_examenModel->insert($data);
                $mensaje = ($id > 0);
        
                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarExamen(){

        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('estatus_exa', '=', '1')->getAll();

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarExamenPorId($examen_id){

        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('examen_id', '=', $examen_id)->where('estatus_exa', '=', '1')->getFirst();

        $mensaje = ($lista != null);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function actualizarExamen($examen_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $validarExamen = new Validate;

        switch ($validarExamen) {
            case ($validarExamen->isEmpty($_POST)):
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

                $_examenModel = new ExamenModel();
                $id = $_examenModel->where('examen_id', '=', $examen_id)->update($data);
                $mensaje = ($id > 0);
        
                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        
                return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarExamen($examen_id){

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



?>