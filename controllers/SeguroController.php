<?php

class SeguroController extends Controller{

    protected $arrayInner = array(
        "empresa" => "seguro_empresa",
        "seguro" => "seguro_empresa",
    );

    protected $arraySelect = array(
        "empresa.empresa_id",
        "empresa.nombre AS nombre_empresa",
        "empresa.rif",
        "empresa.direccion"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('seguros/index');
    }

    public function formRegistrarSeguros(){

        return $this->view('seguros/registrarSeguros');
    }

    public function formActualizarSeguro($seguro_id){
        
        return $this->view('seguros/actualizarSeguros', ['seguro$seguro_id' => $seguro_id]);
    } 

    public function insertarSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("telefono");
        $validarSeguro = new Validate;
        
        $token = $validarSeguro->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
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
            $_seguroModel->byUser($token);
            $id = $_seguroModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

            return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarSeguros(){
                     
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
                $inners = $_seguroModel->listInner($this->arrayInner);
                $EmpresaSeguro = $_seguroModel->where('seguro.seguro_id','=',$id)->where('seguro.estatus_seg', '=', '1')->innerJoin($this->arraySelect, $inners, "seguro_empresa");
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
        return $this->retornarMensaje($mensaje, $resultado);
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        // $respuesta->setData($resultado);
        // return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarSeguroPorId($seguro_id){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->getFirst();

        if ($seguro) {

            $arraySeguro = get_object_vars($seguro);

            $inners = $_seguroModel->listInner($this->arrayInner);
            $empresa = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->innerJoin($this->arraySelect, $inners, "seguro_empresa");
            $mensaje = ($empresa != null);

            if ( $mensaje ) { $arraySeguro['empresas'] = $empresa; } 
            return $this->retornarMensaje($arraySeguro, $arraySeguro);
            // $respuesta = new Response($arraySeguro ? 'CORRECTO' : 'ERROR');
            // $respuesta->setData($arraySeguro);
            // return $respuesta->json($arraySeguro ? '200' : '400');
            
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarSeguro($seguro_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("telefono");

        $validarSeguro = new Validate;
        $token = $validarSeguro->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarSeguro->isDuplicated("seguro", 'seguro_id', $seguro_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

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
            $_seguroModel->byUser($token);

            $actualizado = $_seguroModel->where('seguro_id','=',$seguro_id)->update($data);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
            
            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarSeguro($idSeguro){

        $validarSeguro = new Validate;
        $token = $validarSeguro->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_seguroModel = new SeguroModel();
        $_seguroModel->byUser($token);
        $data = array(
            "estatus_seg" => "2"
        );

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones
    public function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        return $respuesta->json(200);
    }
}
