<?php

class SeguroController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('seguros/index');
    }

    public function formRegistrarSeguros(){

        return $this->view('seguros/registrarSeguros');
    }

    public function formActualizarSeguro($idSeguro){
        
        return $this->view('seguros/actualizarSeguros', ['idSeguro' => $idSeguro]);
    } 

    public function insertarSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("porcentaje", "tipo_seguro", "telefono");
        $camposString = array("nombre", "direccion");
        $validarSeguro = new Validate;

        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isDuplicated('seguro', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarSeguro->isDuplicated('seguro', 'rif', $_POST["rif"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default: 
            $data = $validarSeguro->dataScape($_POST);

            $_seguroModel = new SeguroModel();
            $id = $_seguroModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

            return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarSeguros(){

        // $_seguroModel = new SeguroModel();
        // $lista = $_seguroModel->getAll();
        // $mensaje = (count($lista) > 0);
     
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        // $respuesta->setData($lista);

        // return $respuesta->json(200);

        $arrayInner = array(
            "empresa" => "seguro_empresa",
            "seguro" => "seguro_empresa",
        );

        $arraySelect = array(
            "empresa.empresa_id",
            "empresa.nombre AS nombre_empresa",
            "seguro.nombre AS nombre_seguro",
            "seguro.seguro_id",
            "seguro.rif",
            "seguro.direccion",
            "seguro.telefono",
            "seguro.porcentaje",
            "seguro.tipo_seguro"
        );

        $_seguroModel = new SeguroModel();
        $inners = $_seguroModel->listInner($arrayInner);
        //return $inners;
        $seguro = $_seguroModel->innerJoin($arraySelect, $inners, "seguro_empresa");
        $resultado = array();   
             
        $_seguroModel = new SeguroModel();
        $seguro2 = $_seguroModel->getAll();

        foreach ($seguro2 as $seguros) {
        
            $id = $seguros->seguro_id;
            $validarSeguro = new Validate;
            $respuesta = $validarSeguro->isDuplicated('seguro_empresa', 'seguro_id', $id);
            
            if($respuesta){
                    
                continue;
            } else {

                array_push($seguro, $seguros);
            }
        }

        array_push($resultado, $seguro);
        $mensaje = ($resultado != null);
        
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarSeguroPorId($seguro_id){

        // $_seguroModel = new SeguroModel();
        // $seguro = $_seguroModel->where('seguro_id','=',$idSeguro)->getFirst();
        // $mensaje = ($seguro != null);

        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        // $respuesta->setData($seguro);

        // return $respuesta->json($mensaje ? 200 : 400);

        $arrayInner = array(
            "empresa" => "seguro_empresa",
            "seguro" => "seguro_empresa",
        );

        $arraySelect = array(
            "empresa.empresa_id",
            "empresa.nombre AS nombre_empresa",
            "seguro.nombre AS nombre_seguro",
            "seguro.seguro_id",
            "seguro.rif",
            "seguro.direccion",
            "seguro.telefono",
            "seguro.porcentaje",
            "seguro.tipo_seguro"
        );

        $_seguroModel = new SeguroModel();
        $inners = $_seguroModel->listInner($arrayInner);
        
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->innerJoin($arraySelect, $inners, "seguro_empresa");
        $mensaje = ($seguro != null);

        if ( $mensaje ) {
            
            $respuesta = new Response('CORRECTO');
            $respuesta->setData($seguro);
            return $respuesta->json(200);

        } else {

            $_seguroModel = new SeguroModel();
            $seguro = $_seguroModel->where('seguro_id','=',$seguro_id)->getFirst();
            $mensaje = ($seguro != null);

            $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($seguro);
            return $respuesta->json($mensaje ? 200 : 404);
        }
    }

    public function actualizarSeguro($seguro_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("porcentaje", "tipo_seguro", "telefono");
        $camposString = array("nombre", "direccion");
        $validarSeguro = new Validate;

        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case array_key_exists('nombre', $_POST):
                if ($validarSeguro->isDuplicated('seguro', 'nombre', $_POST["nombre"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);  
                };
            
            default: 

            if (array_key_exists('rif', $_POST)) {
                if ($validarSeguro->isDuplicated('seguro', 'rif', $_POST["rif"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(404);  
                }
            }

            $data = $validarSeguro->dataScape($_POST);
                
            $_seguroModel = new SeguroModel();

            $actualizado = $_seguroModel->where('seguro_id','=',$seguro_id)->update($data);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
            
            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarSeguro($idSeguro){

        $_seguroModel = new SeguroModel();

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>