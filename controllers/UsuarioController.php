<?php

include_once './services/cuenta/CuentaValidaciones.php';
include_once './services/cuenta/CuentaHelpers.php';
include_once './services/cuenta/CuentaService.php';
include_once './services/Helpers.php';

class UsuarioController extends Controller{

    public function __construct(){

    }

    //Método index (vista principal)
    public function index(){

        return $this->view('usuarios/index');
    }

    public function formRegistrarUsuario(){

        return $this->view('usuarios/registrarUsuario');
    }

    public function formActualizarUsuarios($usuario_id){
        
        return $this->view('usuarios/actualizarUsuario', ['usuario_id' => $usuario_id]);
    } 

    public function insertarUsuario(/*Request $request*/){
        if(isset(apache_request_headers()['Authorization'])) {
            global $isEnabledAudit;
            $isEnabledAudit = 'usuarios';
        } else {
            global $isEnabledAudit;
            $isEnabledAudit = 'cuentas';
        }

        $_POST = json_decode(file_get_contents('php://input'), true);
        CuentaValidaciones::validarNuevoUsuario($_POST);

        $id = CuentaService::insertarNuevoUsuario($_POST);
        $preguntasSeguridad = $_POST['preguntas'];

        if ($id != 0) {
            
            CuentaHelpers::insertarPreguntaSeguridad($preguntasSeguridad, $id);
            
            $respuesta = new Response('INSERCION_EXITOSA');
            $respuesta->setData(['usuario_id' => $id]);
            return $respuesta->json(201);

        } else {

            $respuesta = new Response('INSERCION_FALLIDA');
            return $respuesta->json(400);
        }
    }

    public function listarUsuarios(){
        $_usuarioModel = new UsuarioModel();

        if (isset($_GET['status'])) {
            $_usuarioModel->where('estatus_usu', '=', $_GET['status']);
        }

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                
                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_usuarioModel->limit([$primer_registro, $size]);
            }
            
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_usuarioModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_usuarioModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $lista = $_usuarioModel->getAll();
        $_usuarioModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_usuarioModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_usuarioModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_usuarioModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_usuarioModel->setSelect('COUNT(*) AS total');
        }

        if (isset($_GET['status'])) {
            $_usuarioModel->where('estatus_usu', '=', $_GET['status']);
        }

        $total_registros = $_usuarioModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $lista);

        // $mensaje = (count($lista) > 0);

        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        // $respuesta->setData($lista);

        // return $respuesta->json(200);
    }

    public function listarUsuarioPorId($usuario_id){

        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('usuario_id','=',$usuario_id)->getFirst();
        $mensaje = ($usuario != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($usuario);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarUsuario($usuario_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'usuarios';

        $_POST = json_decode(file_get_contents('php://input'), true);
        // Creando los strings para las validaciones
        $camposNumericos = array("rol");
        $validarUsuario = new Validate;

        switch($_POST) {
            case ($validarUsuario->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
        
            case $validarUsuario->isEliminated("usuario", 'estatus_usu', $usuario_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case $validarUsuario->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case array_key_exists('nombre', $_POST):
                if ($validarUsuario->isDuplicated('usuario', 'nombre', $_POST["nombre"])) {
                    $respuesta = new Response(false, 'Ese nombre de usuario ya existe');
                    return $respuesta->json(400);
                }
            default: 
                $data = $validarUsuario->dataScape($_POST);
                if (array_key_exists('clave', $_POST)) {
                    $data["clave"] = password_hash($data["clave"], PASSWORD_DEFAULT);
                }

                $_usuarioModel = new UsuarioModel();

                $actualizado = $_usuarioModel->where('usuario_id','=',$usuario_id)->update($data);
                $mensaje = ($actualizado > 0);
        
                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);
        
                return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarUsuario($usuario_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'usuarios';

        $_usuarioModel = new UsuarioModel();

        $data = array(
            "estatus_usu" => "2"
        );

        $eliminado = $_usuarioModel->where('usuario_id','=',$usuario_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
