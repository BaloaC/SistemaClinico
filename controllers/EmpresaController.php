<?php

class EmpresaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('empresas/index');
    }

    public function formRegistrarEmpresas(){

        return $this->view('empresas/registrarEmpresas');
    }

    public function formActualizarEmpresa($idEmpresa){
        
        return $this->view('empresas/actualizarEmpresas', ['idEmpresa' => $idEmpresa]);
    } 

    public function insertarEmpresa(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
         // Creando los strings para las validaciones
         $camposString = array("nombre", "direccion");
         $validarEmpresa = new Validate;
        
         switch($_POST) {
             case ($validarEmpresa->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
                
             case $validarEmpresa->isString($_POST, $camposString):
                 $respuesta = new Response('DATOS_INVALIDOS');
                 return $respuesta->json(400);

             case $validarEmpresa->isDuplicated('empresa', 'nombre', $_POST["nombre"]):
                 $respuesta = new Response('DATOS_DUPLICADOS');
                 return $respuesta->json(400);

            case $validarEmpresa->isDuplicated('empresa', 'rif', $_POST["rif"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

             default:
                $data = $validarEmpresa->dataScape($_POST);
                $newForm = array(
                    "seguro_id" => $data['seguro_id']
                );

                unset($data['seguro_id']);
                $_empresaModel = new EmpresaModel();
                $id = $_empresaModel->insert($data);
 
                 if ($id > 0) {
                     $insertarSeguroEmpresa = new SeguroEmpresaController;
                     $mensaje = $insertarSeguroEmpresa->insertarSeguroEmpresa($data);
                     
                     if ($mensaje == true) {
                        return $mensaje;
                    } else {
                      
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }

                    // $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                    // return $respuesta->json($mensaje ? 201 : 400);
                 }
         }
    }

    public function listarEmpresas(){

        $_EmpresaModel = new EmpresaModel();
        $lista = $_EmpresaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarEmpresasPorId($empresa_id){

        $_EmpresaModel = new EmpresaModel();
        $empresa = $_EmpresaModel->where('empresa_id','=',$empresa_id)->getFirst();
        $mensaje = ($empresa != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($empresa);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarEmpresa($empresa_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

         // Creando los strings para las validaciones
         $camposString = array("nombre", "direccion");
         $validarEmpresa = new Validate;
        
         switch($_POST) {
            case $validarEmpresa->isEmpty($_POST):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
                
            case $validarEmpresa->isString($_POST, $camposString):
                 $respuesta = new Response('DATOS_INVALIDOS');
                 return $respuesta->json(400);

            case array_key_exists('empresa', $_POST):
                if ($validarEmpresa->isDuplicated('empresa', 'nombre', $_POST["nombre"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);
                }

            case array_key_exists('rif', $_POST):
                if ($validarEmpresa->isDuplicated('empresa', 'rif', $_POST["rif"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);
                }

             default:
                $data = $validarEmpresa->dataScape($_POST);
                $_EmpresaModel = new EmpresaModel();

                if ( array_key_exists('seguro_id', $data) ) {
                    $newForm = array(
                        "seguro_id" => $data['seguro_id'],
                        "empresa_id" => $empresa_id
                    );   
                } else {
                    // Verificamos si hay que actualizar el id del seguro, en caso de no hacerlo, enviamos la data
                    $actualizado = $_EmpresaModel->where('empresa_id','=',$empresa_id)->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);
                }

                $actualizarSeguro = new SeguroEmpresaController;
                $mensajeSeguro = $actualizarSeguro->actualizarSeguroEmpresa($newForm);
                
                if ( !$mensajeSeguro ) {
                    
                    $respuesta = new Response('ACTUALIZACION_FALLIDA');
                    return $respuesta->json(400);

                } else {
                    unset($data['seguro_id']);
                    $validarData = empty($data); //Validamos si todavía hay cosas que insertar en la actualización
                    
                    if ( $validarData ) {
                        
                        // Si no quedan más datos en el formulario, enviamos la respuesta de actualización exitosa
                        $respuesta = new Response('ACTUALIZACION_EXITOSA');
                        return $respuesta->json(201);  
                    }
                      
                    //Si hay más data por enviar, se hace el update de la empresa    
                    $actualizado = $_EmpresaModel->where('empresa_id','=',$empresa_id)->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);                

                }

                unset($data['seguro_id']);
                $_empresaModel = new EmpresaModel();
                $id = $_empresaModel->insert($data);
 
                 if ($id > 0) {
                     $insertarSeguroEmpresa = new SeguroEmpresaController;
                     $mensaje = $insertarSeguroEmpresa->insertarSeguroEmpresa($_POST);
                     
                     $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                     return $respuesta->json($mensaje ? 201 : 400);
                 }
         }
        
    }

    public function eliminarEmpresa($idEmpresa){

        $_EmpresaModel = new EmpresaModel();

        $eliminado = $_EmpresaModel->where('empresa_id','=',$idEmpresa)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function RetornarID($rif){

        $_empresaModel = new EmpresaModel();
        $empresa = $_empresaModel->where('rif','=',$rif)->getFirst();
        $mensaje = ($empresa != null);
        $respuesta = $mensaje ? $empresa->empresa_id : false;
        return $respuesta;
        
    }
}



?>