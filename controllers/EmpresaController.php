<?php

class EmpresaController extends Controller{

    protected $arrayInner = array(
        "seguro" => "seguro_empresa",
    );

    protected $arraySelect = array(
        "seguro.nombre",
        "seguro.seguro_id"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('empresas/index');
    }

    public function formRegistrarEmpresas(){

        return $this->view('empresas/registrarEmpresas');
    }

    public function formActualizarEmpresa($empresa_id){
        
        return $this->view('empresas/actualizarEmpresas', ['empresa_id' => $empresa_id]);
    } 

    public function insertarEmpresa(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
         $validarEmpresa = new Validate;
        
         switch($_POST) {
             case ($validarEmpresa->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
        
            case $validarEmpresa->isDuplicated('empresa', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarEmpresa->isDuplicated('empresa', 'rif', $_POST["rif"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
             
                $seguro = $_POST['seguro'];
                unset($_POST['seguro']);
                $data = $validarEmpresa->dataScape($_POST);
                
                $_empresaModel = new EmpresaModel();
                $id = $_empresaModel->insert($data);
 
                 if ($id > 0) {
                    $insertarSeguroEmpresa = new SeguroEmpresaController;
                    $mensaje = $insertarSeguroEmpresa->insertarSeguroEmpresa($seguro, $id);

                    if ($mensaje == true) { return $mensaje;
                    } else {
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }
                }
        }
    }

    public function actualizarEmpresa($empresa_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $camposKey = array($empresa_id);
        $validarEmpresa = new Validate;
        
         switch($_POST) {
            case $validarEmpresa->isEmpty($_POST):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
            
            case $validarEmpresa->existsInDB($_POST, $camposKey):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarEmpresa->isDuplicated('empresa', 'empresa_id', $empresa_id):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            // case $validarEmpresa->isEliminated("empresa", 'estatus_emp', $empresa_id):
            //     $respuesta = new Response('NOT_FOUND');
            //     return $respuesta->json(404);

            default:

                if (array_key_exists('nombre', $_POST)) {
                    if ($validarEmpresa->isDuplicated('empresa', 'nombre', $_POST["nombre"])) {
                        $respuesta = new Response('DATOS_DUPLICADOS');
                        return $respuesta->json(400);
                    }
                }  

                if (array_key_exists('rif', $_POST)) {
                    if ($validarEmpresa->isDuplicated('empresa', 'rif', $_POST["rif"])) {
                        $respuesta = new Response('DATOS_DUPLICADOS');
                        return $respuesta->json(400);
                    }
                }
                
                if ( array_key_exists('seguro', $_POST) ) {
                    $newForm = $_POST['seguro'];
                    unset($_POST['seguro']);

                    $actualizarSeguro = new SeguroEmpresaController;
                    $mensajeSeguro = $actualizarSeguro->insertarSeguroEmpresa($newForm, $empresa_id);

                    if ( $mensajeSeguro ) { return $mensajeSeguro; } 
                }
                
                if ( !$validarEmpresa->isEmpty($_POST) ) { //Validamos si todavía hay cosas que insertar en la actualización
                    
                    $data = $validarEmpresa->dataScape($_POST);

                    //Si hay más data por enviar, se hace el update de la empresa    
                    $_empresaModel = new EmpresaModel();
                    $actualizado = $_empresaModel->where('empresa_id','=',$empresa_id)->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);                
                } else {
                    $respuesta = new Response('ACTUALIZACION_EXITOSA');
                    return $respuesta->json(200);
                }
                
        }
        
    }

    public function listarEmpresas(){

        $_empresaModel = new EmpresaModel();
        $empresa = $_empresaModel->where('estatus_emp','=','1')->getAll();
        
        if ($empresa) {
            $resultado = array();

            foreach ($empresa as $empresas) {
                
                $_empresaModel = new EmpresaModel();
                $inners = $_empresaModel->listInner($this->arrayInner);
                $empresa = $_empresaModel->where('seguro_empresa.estatus_seg', '=', '1')->where('seguro_empresa.empresa_id', '=', $empresas->empresa_id)->innerJoin($this->arraySelect, $inners, "seguro_empresa");

                if ($empresa) { $empresas->seguro = $empresa; }

                $resultado[] = $empresas;
            }

            $respuesta = new Response($resultado ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($resultado);
            return $respuesta->json($resultado ? 200 : 404);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
        }
    }

    public function listarEmpresaPorId($empresa_id){


        $_empresaModel = new EmpresaModel();
        $empresa = $_empresaModel->where('estatus_emp','=','1')->where('empresa_id', '=', $empresa_id)->getFirst();
        
        if ($empresa) {

            $_empresaModel = new EmpresaModel();
            $inners = $_empresaModel->listInner($this->arrayInner);
            $seguro = $_empresaModel->where('seguro_empresa.estatus_seg', '=', '1')->where('seguro_empresa.empresa_id', '=', $empresa_id)->innerJoin($this->arraySelect, $inners, "seguro_empresa");

            if ($seguro) { $empresa->seguro = $seguro; }

            $respuesta = new Response($empresa ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($empresa);
            return $respuesta->json($empresa ? 200 : 404);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
        }
    }



    public function eliminarEmpresa($empresa_id){

        $_EmpresaModel = new EmpresaModel();
        $data = array(
            "estatus_emp" => "2"
        );
        
        $eliminado = $_EmpresaModel->where('empresa_id','=',$empresa_id)->update($data);
        $mensaje = ($eliminado > 0);
        
        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>