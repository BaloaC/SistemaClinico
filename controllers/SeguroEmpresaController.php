<?php

class SeguroEmpresaController extends Controller{

    public function insertarSeguroEmpresa($post){
        
        $Empresa = new EmpresaController;
        $empresaActualizar = $Empresa->RetornarID($post['rif']);
        
        if ( $empresaActualizar == false ) {

            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);

        } else {
            
            $post['empresa_id'] = $empresaActualizar; 
            
            // Creando los strings para las validaciones
            $camposKey1 = array("seguro_id");
            $camposNumericos = array("empresa_id", "seguro_id");
            $validarSeguroEmpresa = new Validate;
            
            switch($post) {
                case $validarSeguroEmpresa->isEmpty($post):
                    return false;
                case $validarSeguroEmpresa->isNumber($post, $camposNumericos):
                    return false;
                case !($validarSeguroEmpresa->existsInDB($post, $camposKey1)):   
                    return false; 
                // case !($validarSeguroEmpresa->isDuplicated('especialidad', 'especialidad_id', $post['especialidad_id'])):   
                //     return false; 

                default: 
                $data = $validarSeguroEmpresa->dataScape($post);

                $_seguroEmpresaModel = new SeguroEmpresaModel();
                $id = $_seguroEmpresaModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = $mensaje ? true : false;
                
                return $respuesta;
            }
        }
    }

    public function actualizarSeguroEmpresa($form){
            
            // Creando los strings para las validaciones
            $camposKey1 = array("seguro_id");
            $validarSeguroEmpresa = new Validate;

            switch($form) {
                case $validarSeguroEmpresa->isEmpty($form):
                    return false;
                case !($validarSeguroEmpresa->existsInDB($form, $camposKey1)):   
                    return false; 
                case $validarSeguroEmpresa->isDuplicatedId('empresa_id', 'seguro_id', $form['empresa_id'], $form['seguro_id'], 'seguro_empresa'):
                    return false;

                default: 
                $data = $validarSeguroEmpresa->dataScape($form);

                $_seguroEmpresaModel = new SeguroEmpresaModel();
                $id = $_seguroEmpresaModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = $mensaje ? true : false;
                return $respuesta;            
        }
    }

    public function eliminarSeguroEmpresa($seguro_empresa_id){

        $_SeguroEmpresaModel = new SeguroEmpresaModel();

        $eliminado = $_SeguroEmpresaModel->where('seguro_empresa_id','=',$seguro_empresa_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
?>