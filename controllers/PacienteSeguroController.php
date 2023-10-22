<?php

class PacienteSeguroController extends Controller{

    // public function insertarPacienteSeguro($form, $id){

    //     $paciente_id = $id;
        
    //     foreach ($form as $forms) {
                
    //         $forms['paciente_id'] = $paciente_id;
    //         $validarPacienteSeguro = new validate();
    //         // Creando los strings para las validaciones
            
    //         $data = $validarPacienteSeguro->dataScape($forms);
    //         $_pacienteSeguroModel = new PacienteSeguroModel();
    //         $id = $_pacienteSeguroModel->insert($data);
    //         $mensaje = ($id > 0);
            
    //         if (!$mensaje) {  

    //             $respuesta = new Response('INSERCION_FALLIDA');
    //             return $respuesta->json(400);
    //         }
    //     }
    //     return false;
    // }

    public function listarPacienteSeguroPorPaciente($paciente_id) {

        $_pacienteSeguroModel = new PacienteModel();
        $id = $_pacienteSeguroModel->where('estatus_pac', '=',1)->where('paciente_id','=',$paciente_id)->getFirst();

        $respuesta = new Response($id ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($id);
        return $respuesta->json(200);

    }

    public function eliminarPacienteSeguro($paciente_seguro_id){

        $_pacienteSeguroModel = new PacienteSeguroModel();
        $data = array(
            "estatus_pac" => "2"
        );

        $eliminado = $_pacienteSeguroModel->where('paciente_seguro_id','=',$paciente_seguro_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json(200);
    }
}
