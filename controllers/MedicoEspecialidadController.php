<?php

class MedicoEspecialidadController extends Controller{

    public function insertarMedicoEspecialidad($form, $id){
        
        $medico_id = $id;
        foreach ($form as $forms) {
            
            $newForm = $forms;
            $newForm['medico_id'] = $medico_id;
            
            // Creando los strings para las validaciones
            $camposKey = array();
            $camposNumericos = array("especialidad_id", "medico_id");
            $validarMedicoEspecialidad = new Validate;
            
            switch($newForm) {
                case $validarMedicoEspecialidad->isEmpty($newForm):
                    $respuesta = new Response(false, 'Los datos de especialidad están vacíos');
                    return $respuesta->json(400);

                // case !$validarMedicoEspecialidad->existsInDB($newForm, $camposKey):   
                //     $respuesta = new Response(false, 'No se encontraron resultados del médico o la especialidad indicada');
                //     return $respuesta->json(404);

                // --> si llega a dar error de especialida_id no encontrada, descomenten este código y eliminen especialidad_id de camposkey <--
                // case !($validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $newForm['especialidad_id'])):   
                //     $respuesta = new Response(false, 'No se encontraron resultados de la especialidad indicada');
                //     return $respuesta->json(400);

                case $validarMedicoEspecialidad->isDuplicatedId('medico_id', 'especialidad_id', $newForm['medico_id'], $newForm['especialidad_id'], 'medico_especialidad'):
                    $respuesta = new Response(false,'Ya existe un registro con esa información');
                    return $respuesta->json(400);

                default: 
                    $data = $validarMedicoEspecialidad->dataScape($newForm);

                    $_medicoEspecialidadModel = new MedicoEspecialidadModel();
                    $id = $_medicoEspecialidadModel->insert($data);
                    $mensaje = ($id > 0);

                    if (!$mensaje) {  

                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json(400);
                    }
            }

        }
        return false;
    }

    public function eliminarMedicoEspecialidad($medico_especialidad_id){

        $_medicoEspecialidadModel = new MedicoEspecialidadModel();
        $data = array(
            "estatus_med" => "2"
        );

        $eliminado = $_medicoEspecialidadModel->where('medico_especialidad_id','=',$medico_especialidad_id)->update($data);
        
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
?>