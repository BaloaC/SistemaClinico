<?php

class MedicoEspecialidadController extends Controller{

    public function insertarMedicoEspecialidad($post){

        $newForm = array_slice($_POST, -1);
        
        $medico = new MedicoController;
        $medicoActualizar = $medico->RetornarID($_POST['cedula']);
        
        if ( $medicoActualizar == false ) {

            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);

        } else {
            
            $newForm['medico_id'] = $medicoActualizar; 
            
            // Creando los strings para las validaciones
            $camposKey1 = array("medico_id");
            $camposNumericos = array("especialidad_id", "medico_id");
            $validarMedicoEspecialidad = new Validate;
            
            switch($newForm) {
                case $validarMedicoEspecialidad->isEmpty($newForm):
                    return $respuesta = new Response('DATOS_INVALIDOS');
                case $validarMedicoEspecialidad->isNumber($newForm, $camposNumericos):
                    return $respuesta = new Response('DATOS_INVALIDOS');
                case !($validarMedicoEspecialidad->existsInDB($newForm, $camposKey1)):   
                    return $respuesta = new Response('NOT_FOUND'); 
                case !($validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $newForm['especialidad_id'])):   
                    return $respuesta = new Response('NOT_FOUND'); 

                default: 
                $data = $validarMedicoEspecialidad->dataScape($newForm);

                $_medicoEspecialidadModel = new MedicoEspecialidadModel();
                $id = $_medicoEspecialidadModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = $mensaje ? true : false;
                
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
        $camposNumericos = array("especialidad_id", "medico_id");
        $validarMedicoEspecialidad = new Validate;
        
        switch($form) {
            case $validarMedicoEspecialidad->isEmpty($form):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedicoEspecialidad->isNumber($form, $camposNumericos):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case !($validarMedicoEspecialidad->existsInDB($form, $camposKey1)):   
                return $respuesta = new Response('NOT_FOUND'); 
            case !($validarMedicoEspecialidad->isDuplicated('especialidad', 'especialidad_id', $form['especialidad_id'])):   
                return $respuesta = new Response('NOT_FOUND'); 

            default: 
            $data = $validarMedicoEspecialidad->dataScape($form);

            $_medicoEspecialidadModel = new MedicoEspecialidadModel();
            $id = $_medicoEspecialidadModel->insert($data);
            $mensaje = ($id > 0);
            $respuesta = $mensaje ? true : false;
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