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

        $arrayInner = array(
            "empresa" => "seguro_empresa",
            "seguro" => "seguro_empresa",
        );

        $arraySelect = array(
            "empresa.empresa_id",
            "empresa.nombre AS nombre_empresa",
            "empresa.rif",
            "empresa.direccion"
        );
                     
        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('estatus_seg', '=', '1')->getAll();
        $resultado = array();   

        foreach ($seguro as $seguros) {
        
            $id = $seguros->seguro_id;
            $validarSeguro = new Validate;
            // Verificamos si hay que aplicarle un inner join a ese seguro en específico
            $respuesta = $validarSeguro->isDuplicated('seguro_empresa', 'seguro_id', $id);
            $newArray = get_object_vars($seguros);
            
            if($respuesta){
                
                $newArray['empresas'] = '';
                $_seguroModel = new SeguroModel();
                $inners = $_seguroModel->listInner($arrayInner);
                $EmpresaSeguro = $_seguroModel->where('seguro.seguro_id','=',$id)->where('seguro.estatus_seg', '=', '1')->innerJoin($arraySelect, $inners, "seguro_empresa");
                $arraySeguro = array();

                foreach ($EmpresaSeguro as $empresas) {
                    // Guardamos cada empresa en un array
                    $arraySeguro[] = $empresas;
                }
                // Agregamos las empresas en el seguro al que pertenecen
                $newArray['empresas'] = $arraySeguro;
                $resultado[] = $newArray;

            } else { $resultado[] = $newArray; } // Si no necesita inner join, lo agregamos tal cual como está
        }

        $mensaje = ($resultado != null);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarSeguroPorId($seguro_id){

        $arrayInner = array(
            "empresa" => "seguro_empresa",
            "seguro" => "seguro_empresa",
        );

        $arraySelect = array(
            "empresa.empresa_id",
            "empresa.nombre AS nombre_empresa",
            "empresa.rif",
            "empresa.direccion"
        );

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('estatus_seg', '=', '1')->getFirst();

        if ($seguro) {

            $arraySeguro = get_object_vars($seguro);

            $inners = $_seguroModel->listInner($arrayInner);
            $empresa = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('estatus_seg', '=', '1')->innerJoin($arraySelect, $inners, "seguro_empresa");
            $mensaje = ($empresa != null);

            if ( $mensaje ) {
                
                $arraySeguro['empresas'] = $empresa;
            } 
            
            $respuesta = new Response($arraySeguro ? 'CORRECTO' : 'ERROR');
            $respuesta->setData($arraySeguro);
            return $respuesta->json($arraySeguro ? '200' : '400');
            
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
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

            case $validarSeguro->isEliminated("seguro", 'estatus_seg', $seguro_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

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
        $data = array(
            "estatus_seg" => "2"
        );

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>