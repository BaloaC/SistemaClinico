<?php

class MedicoEspecialidadController extends Controller{

    public function insertarMedicoEspecialidad($form){
      
        $medico = new MedicoController;
        $medicoActualizar = $medico->RetornarID($_POST['cedula']);
        
        if ( $medicoActualizar == false ) {

            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);

        } else {
            
            $form['medico_id'] = $medicoActualizar; 
            
            // Creando los strings para las validaciones
            $camposKey1 = array("medico_id");
            $camposNumericos = array("especialidad_id", "medico_id");
            $validarMedicoEspecialidad = new Validate;
            
            switch($form) {
                case $validarMedicoEspecialidad->isEmpty($form):
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);

                case $validarMedicoEspecialidad->isNumber($form, $camposNumericos):
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);

                case !($validarMedicoEspecialidad->existsInDB($form, $camposKey1)):   
                    $respuesta = new Response('NOT_FOUND');         
                    return $respuesta->json(404);

                case !($validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $form['especialidad_id'])):   
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);

                case $validarMedicoEspecialidad->isDuplicatedId('medico_id', 'especialidad_id', $form['medico_id'], $form['especialidad_id'], 'medico_especialidad'):
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);

                default: 
                    $data = $validarMedicoEspecialidad->dataScape($form);

                    $_medicoEspecialidadModel = new MedicoEspecialidadModel();
                    $id = $_medicoEspecialidadModel->insert($data);
                    $mensaje = ($id > 0);

                    $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                    return $respuesta->json($mensaje ? 201 : 400);
                
                return $respuesta;
            }
        }
    }

    // public function listarMedicosEspecialidades(){

    //     $_medicoEspecialidadModel = new MedicoEspecialidadModel();
    //     $lista = $_medicoEspecialidadModel->getAll();
    //     $mensaje = (count($lista) > 0);
     
    //     $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
    //     $respuesta->setData($lista);

    //     return $respuesta->json(200);
    // }

    // public function listarMedicoEspecialidadPorId($medico_especialidad_id){

    //     $_medicoEspecialidadModel = new MedicoEspecialidadModel();
    //     $medico = $_medicoEspecialidadModel->where('medico_especialidad_id','=',$medico_especialidad_id)->getFirst();
    //     $mensaje = ($medico != null);

    //     $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
    //     $respuesta->setData($medico);

    //     return $respuesta->json($mensaje ? 200 : 400);
    // }

    public function actualizarMedicoEspecialidad($form){

        // Creando los strings para las validaciones
        $camposKey1 = array("medico_id");

        $validarMedicoEspecialidad = new Validate;
        
        switch($form) {
            case $validarMedicoEspecialidad->isEmpty($form):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
                
            case !($validarMedicoEspecialidad->existsInDB($form, $camposKey1)):   
                $respuesta = new Response('NOT_FOUND');         
                return $respuesta->json(404);
                                
                case !$validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $form['especialidad_id']):
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);

            case $validarMedicoEspecialidad->isDuplicatedId('medico_id', 'especialidad_id', $form['medico_id'], $form['especialidad_id'], 'medico_especialidad'):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default: 

            $data = $validarMedicoEspecialidad->dataScape($form);
            $_medicoEspecialidadModel = new MedicoEspecialidadModel();
            $id = $_medicoEspecialidadModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = ($mensaje ? false : new Response('INSERCION_FALLIDA'));
            return $respuesta;
        }
    }

    public function eliminarMedicoEspecialidad($medico_especialidad_id){

        $_medicoEspecialidadModel = new MedicoEspecialidadModel();

        $eliminado = $_medicoEspecialidadModel->where('medico_especialidad_id','=',$medico_especialidad_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
?>