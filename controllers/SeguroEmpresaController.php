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
                    $respuesta = new Response(false, 'No existen datos del seguro');
                    return $respuesta->json(400);

                case !$validarSeguroEmpresa->isDuplicated('seguro', 'seguro_id', $_POST['seguro_id']):
                    $respuesta = new Response(false, 'El seguro indicado no existe o es inválido');
                    return $respuesta->json(400);

                case $validarSeguroEmpresa->isNumber($post, $camposNumericos):
                    $respuesta = new Response(false, 'Información de empresa o seguro erróneos');
                    return $respuesta->json(400);

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
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);

                case !($validarSeguroEmpresa->existsInDB($form, $camposKey1)):   
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
                    
                case $validarSeguroEmpresa->isDuplicatedId('empresa_id', 'seguro_id', $form['empresa_id'], $form['seguro_id'], 'seguro_empresa'):
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);

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