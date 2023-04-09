<?php

class TitularBeneficiadoController extends Controller{

    public function insertarTitularBeneficiado($paciente_beneficiado_id){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposNumericos = array("tipo_relacion");
        $camposKey = array("paciente_id");

        $validarPaciente = new Validate;
        
        foreach ($_POST as $forms) {
            
            switch($forms) {
                case ($validarPaciente->isEmpty($forms)):
                    $respuesta = new Response('DATOS_VACIOS');
                    return $respuesta->json(400);

                case $validarPaciente->isNumber($forms, $camposNumericos):
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                    
                case $forms['tipo_relacion'] > 3:
                    $respuesta = new Response(false, 'El tipo de relación indicado no es válido');
                    return $respuesta->json(400);
                    
                case !$validarPaciente->existsInDB($forms, $camposKey):
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);
                    
                case !$validarPaciente->isDuplicated('paciente_beneficiado', 'paciente_beneficiado_id', $paciente_beneficiado_id):
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);

                case $validarPaciente->isDuplicatedId('paciente_id', 'paciente_beneficiado_id', $forms['paciente_id'], $paciente_beneficiado_id, 'titular_beneficiado'):
                    $respuesta = new Response(false, 'Ese paciente ya se encuentra asociado al titular indicado');
                    return $respuesta->json(404);

                default: 
                
                    $_pacienteModel = new PacienteModel();
                    $pacienteTitular = $_pacienteModel->where('paciente_id', '=', $forms['paciente_id'])->where('tipo_paciente', '=', '2')->orWhere('tipo_paciente', '=', '3')->getFirst();
                    
                    if ( !$pacienteTitular > 0) {
                        $respuesta = new Response(false, 'El paciente indicado no puede ser titular');
                        $respuesta->setData($forms['paciente_id']);
                        return $respuesta->json(400);
                    } else {
                        
                        $data = $validarPaciente->dataScape($forms);
                        $data['paciente_beneficiado_id'] = $paciente_beneficiado_id;
                        $_titularBeneficiadoModel = new TitularBeneficiadoModel();
                        $tb_id = $_titularBeneficiadoModel->insert($data);
                        $mensaje = ($tb_id > 0);

                        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                        return $respuesta->json($mensaje ? 201 : 400);
                    }
            }
        }
    }

    public function listarPacienteBeneficiadoDeTitularId($titular_beneficiado_id){
        
        $arrayInner = array(
            "paciente_beneficiado" => "titular_beneficiado",
            "paciente" => "paciente_beneficiado"
        );
    
        $arraySelect = array(
            "paciente_beneficiado.paciente_beneficiado_id",
            "paciente.paciente_id",
            "paciente.nombre",
            "paciente.apellidos",
            "paciente.cedula",
            "paciente.fecha_nacimiento",
            "paciente.edad",
            "paciente.telefono",
            "paciente.direccion"
        );

        $_titularBeneficiadoModel = new TitularBeneficiadoModel();
        $inners = $_titularBeneficiadoModel->listInner($arrayInner);
        $paciente = $_titularBeneficiadoModel
            ->where('titular_beneficiado.paciente_id','=',$titular_beneficiado_id)
            ->where('titular_beneficiado.estatus_tit','=','1')
            ->where('paciente_beneficiado.estatus_pac','=','1')->innerJoin($arraySelect, $inners, "titular_beneficiado");

        $respuesta = new Response($paciente ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($paciente);
        return $respuesta->json($paciente ? 200 : 404);
    }

    public function listarTitularesDePacienteBeneficiadoId($paciente_beneficiado_id){
        
        $arrayInner = array(
            "paciente" => "titular_beneficiado"
        );
    
        $arraySelect = array(
            "paciente.paciente_id",
            "paciente.nombre",
            "paciente.cedula"
        );

        $_titularBeneficiadoModel = new TitularBeneficiadoModel();
        $inners = $_titularBeneficiadoModel->listInner($arrayInner);
        $titularPaciente = $_titularBeneficiadoModel->where('titular_beneficiado.paciente_beneficiado_id','=',$paciente_beneficiado_id)->where('titular_beneficiado.estatus_tit','=','1')->innerJoin($arraySelect, $inners, "titular_beneficiado");

        $respuesta = new Response($titularPaciente ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($titularPaciente);
        return $respuesta->json($titularPaciente ? 200 : 404);
    }

    public function eliminarTitularBeneficiado($titular_beneficiado_id){

        $_titularBeneficiadoModel = new titularBeneficiadoModel();
        $data = array(
            "estatus_tit" => "2"
        );

        $eliminado = $_titularBeneficiadoModel->where('titular_beneficiado_id','=',$titular_beneficiado_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 404);
    }
}



?>