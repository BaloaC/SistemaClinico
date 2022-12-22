<?php

class ProveedorController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('proveedores/index');
    }

    public function formRegistrarProveedor(){

        return $this->view('proveedores/registrarProveedores');
    }

    public function formActualizarProveedor($proveedor_id){
        
        return $this->view('proveedores/actualizarProveedores', ['proveedor_id' => $proveedor_id]);
    } 

    public function insertarProveedor(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validacion = $this->validacion($_POST);

        if (!$validacion) {
        
            $validarProveedor = new Validate;
            $data = $validarProveedor->dataScape($_POST);

            $_proveedorModel = new ProveedorModel();
            $id = $_proveedorModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
            return $respuesta->json($mensaje ? 201 : 400);

        } else { return $validacion; }
    }
    
    public function actualizarProveedor($proveedor_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validacion = $this->validacion($_POST);

        if (!$validacion) {
        
            $validarProveedor = new Validate;
            $data = $validarProveedor->dataScape($_POST);

            $_proveedorModel = new ProveedorModel();
            $actualizado = $_proveedorModel->where('estatus_pro','=','1')->where('proveedor_id','=',$proveedor_id)->update($_POST);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
            return $respuesta->json($mensaje ? 200 : 400);

        } else { return $validacion; }
    }

    public function listarProveedor(){

        $_proveedorModel = new ProveedorModel();
        $lista = $_proveedorModel->where('estatus_pro', '=', '1')->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarProveedorPorId($proveedor_id){

        $_proveedorModel = new ProveedorModel();
        $proveedor = $_proveedorModel->where('estatus_pro', '=', '1')->where('proveedor_id','=',$proveedor_id)->getFirst();
        $mensaje = ($proveedor != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($proveedor);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function eliminarProveedor($proveedor_id){

        $_proveedorModel = new ProveedorModel();
        $data = array(
            "estatus_pro" => "2"
        );

        $eliminado = $_proveedorModel->where('proveedor_id','=',$proveedor_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    // Método con las validaciones generales de los formularios
    public function validacion($data) {

        $validarProveedor = new Validate;

        switch($_POST) {
            case ($validarProveedor->isEmpty($_POST)):
               $respuesta = new Response('DATOS_VACIOS');
               return $respuesta->json(400);
       
            case $validarProveedor->isDuplicated('proveedor', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
                return false;
        }

    }
}



?>