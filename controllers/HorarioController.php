<?php

class HorarioController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('consultas/index');
    }

    public function formRegistrarHorarios(){

        return $this->view('consultas/registrarHorarios');
    }

    public function formActualizarHorario($idHorario){
        
        return $this->view('consultas/actualizarHorarios', ['idHorario' => $idHorario]);
    } 

    public function insertarHorario(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        for ($i=0; $i < count($_POST); $i++) { 
            $newForm = array();
            $newForm['medico_id'] = $_POST[$i]['medico_id'];
            $newForm['dias_semana'] = $_POST[$i]['dias_semana'];
            
            $camposNumericos = array("medico_id");
            $camposString = array("dias_semana");
            $validarHorario = new Validate;

            switch($newForm) {
                case ($validarHorario->isEmpty($newForm)):
                    return $respuesta = new Response('DATOS_INVALIDOS');
                case $validarHorario->isNumber($newForm, $camposNumericos):
                    return $respuesta = new Response('DATOS_INVALIDOS');
                case $validarHorario->isString($newForm, $camposString):
                    return $respuesta = new Response('DATOS_INVALIDOS');
                case !($validarHorario->existsInDB($newForm, $camposNumericos)):   
                    return $respuesta = new Response('NOT_FOUND'); 
                default: 
                $data = $validarHorario->dataScape($newForm);

                    return $data;
                $_horarioModel = new HorarioModel();
                $id = $_horarioModel->insert($data);
                $mensaje = ($id > 0);
    
                if (!$mensaje) {
                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json($mensaje ? 200 : 400);
                }
            }
   
        }
    }

    public function listarHorarios(){

        $_horarioModel = new HorarioModel();
        $lista = $_horarioModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarHorariosPorId($idHorario){

        $_horarioModel = new HorarioModel();
        $horario = $_horarioModel->where('horario_id','=',$idHorario)->getFirst();
        $mensaje = ($horario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($horario);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarHorario(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_horarioModel = new HorarioModel();

        $actualizado = $_horarioModel->where('horario_id','=',$_POST['idHorario'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarHorario($idHorario){

        $_horarioModel = new HorarioModel();

        $eliminado = $_horarioModel->where('horario_id','=',$idHorario)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>