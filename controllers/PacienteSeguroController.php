<?php

class PacienteSeguroController extends Controller{

    public function listarPacienteSeguroPorPaciente($paciente_id) {

        $_pacienteSeguroModel = new PacienteModel();
        $id = $_pacienteSeguroModel->where('estatus_pac', '=',1)->where('paciente_id','=',$paciente_id)->getFirst();

        $respuesta = new Response($id ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json(200);

    }

    public function eliminarPacienteSeguro($paciente_seguro_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'paciente_seguro';

        $_pacienteSeguroModel = new PacienteSeguroModel();
        $data = array(
            "estatus_pac" => "2"
        );

        // $paciente = $_pacienteSeguroModel->where('paciente_seguro_id','=',$paciente_seguro_id)->getFirst();
        $eliminado = $_pacienteSeguroModel->where('paciente_seguro_id','=',$paciente_seguro_id)->update($data);

        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json(200);
    }
}
