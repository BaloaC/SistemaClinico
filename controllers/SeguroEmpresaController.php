<?php

class SeguroEmpresaController extends Controller{

    public function insertarSeguroEmpresa($form, $id){
        
        $empresa_id = $id;
        foreach ($form as $forms) {
            
            $newForm = $forms;
            $newForm['empresa_id'] = $empresa_id;

            // Creando los strings para las validaciones
            $camposKey = array("seguro_id");
            $validarSeguroEmpresa = new Validate;
            
            switch($newForm) {
                case $validarSeguroEmpresa->isEmpty($newForm):
                    $respuesta = new Response(false, 'No existen datos del seguro');
                    return $respuesta->json(400);

                // case !$validarSeguroEmpresa->existsInDB($newForm, $camposKey):
                //     $respuesta = new Response(false, 'El seguro indicado no existe o es inválido');
                //     $respuesta->setData($forms['seguro_id']);
                //     return $respuesta->json(400);

                case !$validarSeguroEmpresa->isDuplicated('seguro', 'seguro_id', $forms['seguro_id']):
                    $respuesta = new Response(false, 'El seguro indicado no existe o es inválido');
                    return $respuesta->json(400);

                case $validarSeguroEmpresa->isDuplicatedId('seguro_id', 'empresa_id', $newForm['seguro_id'], $newForm['empresa_id'], 'seguro_empresa'): 
                    $respuesta = new Response(false, 'La empresa ya está asociada a ese seguro');
                    $respuesta->setData($forms['seguro_id']);
                    return $respuesta->json(400);

                default: 
                    $data = $validarSeguroEmpresa->dataScape($newForm);
                    
                    $_seguroEmpresaModel = new SeguroEmpresaModel();
                    $id = $_seguroEmpresaModel->insert($data);
                    
                    $mensaje = ($id > 0);
                    
                    if (!$mensaje) {  

                        $respuesta = new Response(false, 'Hubo un error insertando el seguro');
                        $respuesta->setData($forms['seguro_id']);
                        return $respuesta->json(400);
                    }
            }
        }
        return false;
    }

    public function eliminarSeguroEmpresa($seguro_empresa_id){

        $_SeguroEmpresaModel = new SeguroEmpresaModel();
        $data = array(
            "estatus_seg" => "2"
        );

        $eliminado = $_SeguroEmpresaModel->where('seguro_empresa_id','=',$seguro_empresa_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 404);
    }
}
?>