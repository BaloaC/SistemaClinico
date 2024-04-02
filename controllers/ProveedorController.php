<?php

class ProveedorController extends Controller
{

    //Método index (vista principal)
    public function index()
    {

        return $this->view('proveedores/index');
    }

    public function formRegistrarProveedor()
    {

        return $this->view('proveedores/registrarProveedores');
    }

    public function formActualizarProveedor($proveedor_id)
    {

        return $this->view('proveedores/actualizarProveedores', ['proveedor_id' => $proveedor_id]);
    }

    public function insertarProveedor(/*Request $request*/) {
        global $isEnabledAudit;
        $isEnabledAudit = 'proveedores';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarProveedor = new Validate;

        switch ($_POST) {
            case ($validarProveedor->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarProveedor->isDuplicated('proveedor', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
                $data = $validarProveedor->dataScape($_POST);

                $_proveedorModel = new ProveedorModel();
                $id = $_proveedorModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function actualizarProveedor($proveedor_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'proveedores';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarProveedor = new Validate;

        switch ($_POST) {
            case ($validarProveedor->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

                // ** Enrique
            case !$validarProveedor->isDuplicated('proveedor', 'proveedor_id', $proveedor_id):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            default:
                if (array_key_exists('nombre', $_POST)) {
                    if ($validarProveedor->isDuplicated('proveedor', 'nombre', $_POST["nombre"])) {
                        $respuesta = new Response('DATOS_DUPLICADOS');
                        return $respuesta->json(400);
                    }
                }

                $data = $validarProveedor->dataScape($_POST);

                $_proveedorModel = new ProveedorModel();
                $id = $_proveedorModel->where('proveedor_id', '=', $proveedor_id)->update($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                return $respuesta->json($mensaje ? 200 : 404);
        }
    }

    public function listarProveedor()
    {

        $_proveedorModel = new ProveedorModel();
        $lista = $_proveedorModel->where('estatus_pro', '=', '1')->getAll();
        $mensaje = (count($lista) > 0);
        return $this->retornarLista($mensaje, $lista);
    }

    public function listarProveedorPorId($proveedor_id)
    {

        $_proveedorModel = new ProveedorModel();
        $proveedor = $_proveedorModel->where('estatus_pro', '=', '1')->where('proveedor_id', '=', $proveedor_id)->getFirst();
        $mensaje = ($proveedor != null);
        return $this->retornarLista($mensaje, $proveedor);
    }

    public function eliminarProveedor($proveedor_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'proveedores';
        
        $_proveedorModel = new ProveedorModel();
        $data = array(
            "estatus_pro" => "2"
        );

        $eliminado = $_proveedorModel->where('proveedor_id', '=', $proveedor_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    // Funciones
    public function retornarLista($mensaje, $dataReturn)
    {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($dataReturn);
        return $respuesta->json(200);
    }
}
