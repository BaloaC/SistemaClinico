<?php

class HorarioController extends Controller{

    public function insertarHorario($form, $id){
        
        $medico_id = $id;
        foreach ($form as $forms) {
            
            $newForm = $forms;
            $newForm['medico_id'] = $medico_id;

            $camposNumericos = array("medico_id");
            $camposString = array("dias_semana");
            $validarHorario = new Validate;

            switch($newForm) {
                case ($validarHorario->isEmpty($newForm)):
                    $respuesta = new Response(false, 'Los datos de los horarios no pueden enviarse vacíos');
                    return $respuesta->json(400);

                case $validarHorario->isString($newForm, $camposString):
                    $respuesta = new Response(false, 'Formato de los días de la semana inválidos');
                    return $respuesta->json(400);

                case !($validarHorario->existsInDB($newForm, $camposNumericos)):   
                    $respuesta = new Response(false, 'El médico señalado no fue encontrado para la asignación del horario'); 
                    return $respuesta->json(404);
                
                case $validarHorario->isDuplicatedId('medico_id', 'dias_semana', $newForm['medico_id'], $newForm['dias_semana'], 'horario'):
                    $respuesta = new Response(false, 'El horario ya se encuentra registrado'); 
                    return $respuesta->json(400);

                default: 
                    $data = $validarHorario->dataScape($newForm);

                    //sreturn $data;
                    $_horarioModel = new HorarioModel();
                    $id = $_horarioModel->insert($data);
                    $mensaje = ($id > 0);
        
                    if (!$mensaje) {
                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json($mensaje ? 201 : 400);
                    }
            }
        }
    }

    public function listarHorarios(){

        $arrayInner = array(
            "medico" => "horario",
        );

        $arraySelect = array(
            "horario.horario_id",
            "horario.dias_semana",
            "horario.medico_id",
            "medico.nombres"
        );

        $_horarioModel = new HorarioModel();
        $inners = $_horarioModel->listInner($arrayInner);
        $mensaje = $_horarioModel->where('estatus_hor','=','1')->innerJoin($arraySelect, $inners, "horario");

        $resultado = (count($mensaje) > 0);
     
        $respuesta = new Response($resultado ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($mensaje);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarHorarioPorId($horario_id){

        $_horarioModel = new HorarioModel();
        $horario = $_horarioModel->where('horario_id','=',$horario_id)->where('estatus_hor','=',"1")->getFirst();
        $mensaje = ($horario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($horario);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    // public function actualizarHorario($horario_id){

    //     $_POST = json_decode(file_get_contents('php://input'), true);

    //     $camposNumericos = array("medico_id");
    //     $camposString = array("dias_semana");
    //     $validarHorario = new Validate;

    //     switch($_POST) {
    //         case ($validarHorario->isEmpty($_POST)):
    //             $respuesta = new Response('DATOS_VACIOS');
    //             return $respuesta->json(400);

    //         case $validarHorario->isEliminated("horario", 'estatus_hor', $horario_id):
    //             $respuesta = new Response('NOT_FOUND');
    //             return $respuesta->json(404);

    //         case !$validarHorario->isNumber($_POST, $camposNumericos):
    //             $respuesta = new Response('DATOS_INVALIDOS');
    //             return $respuesta->json(400);

    //         case $validarHorario->isString($_POST, $camposString):
    //             $respuesta = new Response('DATOS_INVALIDOS');
    //             return $respuesta->json(400);

    //         case !($validarHorario->existsInDB($_POST, $camposNumericos)):   
    //             $respuesta = new Response('NOT_FOUND'); 
    //             return $respuesta->json(404);
            
    //         case $validarHorario->isDuplicatedId('medico_id', 'dias_semana', $_POST['medico_id'], $_POST['dias_semana'], 'horario'):
    //             $respuesta = new Response('DATOS_DUPLICADOS'); 
    //             return $respuesta->json(400);

    //         default: 
    //             $data = $validarHorario->dataScape($_POST);

    //             //sreturn $data;
    //             $_horarioModel = new HorarioModel();
    //             $id = $_horarioModel->where('horario_id','=',$_POST['horario_id'])->update($_POST);
    //             $mensaje = ($id > 0);
                
    //             $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
    //             $respuesta->setData($id);
    //             return $respuesta->json($mensaje ? 201 : 400);
    //     }
    // }

    public function eliminarHorario($horario_id){

        $_horarioModel = new HorarioModel();
        $data = array(
            "estatus_hor" => "2"
        );

        $eliminado = $_horarioModel->where('horario_id','=',$horario_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>