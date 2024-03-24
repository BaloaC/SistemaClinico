<?php

class HorarioController extends Controller{

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

        return $respuesta->json(200);
    }

    public function eliminarHorario($horario_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'horarios';

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
