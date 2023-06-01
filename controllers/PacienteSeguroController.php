<?php

class PacienteSeguroController extends Controller{

    public function insertarPacienteSeguro($form, $id){

        $paciente_id = $id;
        
        foreach ($form as $forms) {
                
            $forms['paciente_id'] = $paciente_id;
            // Creando los strings para las validaciones
            $camposNumericos = array("tipo_seguro", "cobertura_general", "saldo_disponible");
            $campoId1 = array("seguro_id", "empresa_id","paciente_id");
            $validarPacienteSeguro = new Validate;

            switch($forms) {
                case ($validarPacienteSeguro->isEmpty($forms)):
                    $respuesta = new Response(false, 'Los datos del seguro están vacíos');
                    return $respuesta->json(400);

                case $validarPacienteSeguro->isNumber($forms, $camposNumericos):
                    $respuesta = new Response(false, 'Los datos del seguro son inválidos');
                    return $respuesta->json(400);

                case $validarPacienteSeguro->isDate($forms['fecha_contra']):
                    $respuesta = new Response(false, 'La fecha indicada en el registro del seguro es inválida');
                    return $respuesta->json(400);

                case !$validarPacienteSeguro->isToday($forms['fecha_contra'], true):
                    $respuesta = new Response(false, 'La fecha indicada en el registro del seguro es inválida');
                    return $respuesta->json(400);

                // case !$validarPacienteSeguro->existsInDB($forms, $campoId1):   
                //     $respuesta = new Response(false, 'No se encontraron resultados del seguro o la empresa indicada');
                //     return $respuesta->json(404);

                case !$validarPacienteSeguro->isDuplicatedId('empresa_id', 'seguro_id', $forms['empresa_id'], $forms['seguro_id'], 'seguro_empresa'):
                    $respuesta = new Response(false, 'La empresa no se encuentra asociada al seguro indicado');
                    return $respuesta->json(400);

                case $validarPacienteSeguro->isDuplicatedId('paciente_id', 'seguro_id', $forms['paciente_id'], $forms['seguro_id'], 'paciente_seguro'):
                    $respuesta = new Response(false, 'Ya existe un registro con la misma información de seguro y paciente');
                    return $respuesta->json(400);

                case $forms['tipo_seguro'] > 2:
                    $respuesta = new Response(false, 'Tipo de seguro inválido');
                    return $respuesta->json(400);

                default: 

                    $data = $validarPacienteSeguro->dataScape($forms);
                    $_pacienteSeguroModel = new PacienteSeguroModel();
                    $id = $_pacienteSeguroModel->insert($data);
                    $mensaje = ($id > 0);
                    
                    if (!$mensaje) {  

                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json(400);
                    }
            }
        }
        return false;
    }

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
