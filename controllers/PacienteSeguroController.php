<?php

class PacienteSeguroController extends Controller{

    public function insertarPacienteSeguro($form){

        $paciente = new PacienteController;
        $pacienteActualizar = $paciente->RetornarID($form['cedula']);
        
        if ( $pacienteActualizar == false ) {

            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);

        } else {

            $form['paciente_id'] = $pacienteActualizar;

            // Creando los strings para las validaciones
            $camposNumericos = array("seguro_id", "empresa_id", "tipo_seguro", "cobertura_general", "saldo_disponible");
            $campoId1 = array("seguro_id");
            $campoId2 = array("empresa_id");
            
            $validarPacienteSeguro = new Validate;
            
            switch($_POST) {
                case ($validarPacienteSeguro->isEmpty($form)):
                    $respuesta = new Response(false, 'Los datos del seguro están vacíos');
                    return $respuesta->json(400);

                case $validarPacienteSeguro->isNumber($form, $camposNumericos):
                    $respuesta = new Response(false, 'Los datos del seguro son inválidos');
                    return $respuesta->json(400);

                case $validarPacienteSeguro->isDate($form['fecha_contra']):
                    $respuesta = new Response(false, 'La fecha indicada en el registro del seguro es inválida');
                    return $respuesta->json(400);

                case !$validarPacienteSeguro->existsInDB($form, $campoId1):   
                    $respuesta = new Response(false, 'No se encontraron resultados del seguro indicado');         
                    return $respuesta->json(404);

                case !$validarPacienteSeguro->existsInDB($form, $campoId2):   
                    $respuesta = new Response(false, 'No se encontraron resultados de la empresa indicada');         
                    return $respuesta->json(404);

                case !$validarPacienteSeguro->isDuplicatedId('empresa_id', 'seguro_id', $form['empresa_id'], $form['seguro_id'], 'seguro_empresa'):
                    $respuesta = new Response(false, 'Ya existe un registro con la misma información');
                    return $respuesta->json(400);

                default: 
                    $data = $validarPacienteSeguro->dataScape($form);
                    $_pacienteSeguroModel = new PacienteSeguroModel();
                    $id = $_pacienteSeguroModel->insert($data);
                    $mensaje = ($id > 0);
                
                    $mensaje = new Response($mensaje ? false : 'INSERCION_FALLIDA');
                    return $mensaje;
            }
        }
    }

    public function actualizarPacienteSeguro($paciente_id){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("seguro_id", "empresa_id", "tipo_seguro", "cobertura_general", "saldo_disponible");
        $campoId1 = array("seguro_id");
        $campoId2 = array("empresa_id");
        
        $validarSeguroPaciente = new Validate;
        
        switch($_POST) {
            case ($validarSeguroPaciente->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarSeguroPaciente->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarSeguroPaciente->isDuplicated('paciente', 'paciente_id', $paciente_id):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case array_key_exists('empresa_id', $_POST):
                if ( !$validarSeguroPaciente->existsInDB($_POST, $campoId2) ) {
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);
                }

            case array_key_exists('seguro_id', $_POST):
                if ( !$validarSeguroPaciente->existsInDB($_POST, $campoId1) ) {
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);
                }

            case array_key_exists('tipo_seguro', $_POST):
                if ( $_POST['tipo_seguro'] > 2 || $_POST['tipo_seguro'] == 0 ) {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                }

            default: 

                $data = $validarSeguroPaciente->dataScape($_POST);
                $_pacienteSeguroModel = new PacienteSeguroModel();

                if ($validarSeguroPaciente->isDuplicated('paciente_seguro', 'paciente_id', $paciente_id)) {
                    
                    $actualizado = $_pacienteSeguroModel->where('paciente_id','=',$paciente_id)->update($data);    
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);
                    return $respuesta->json($mensaje ? 200 : 400);

                } else {
                    $data['paciente_id'] = $paciente_id;
                    $actualizado = $_pacienteSeguroModel->insert($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                    $respuesta->setData($actualizado);
                    return $respuesta->json($mensaje ? 201 : 400);
                }
        }
    }

    public function eliminarPacienteSeguro($paciente_id){

        $_pacienteSeguroModel = new PacienteModel();
        $data = array(
            "estatus_pac" => "2"
        );

        $eliminado = $_pacienteSeguroModel->where('paciente_id','=',$paciente_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>