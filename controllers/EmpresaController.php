<?php

include_once './services/seguros/empresa/EmpresaValidaciones.php';

include_once './services/seguros/empresa/EmpresaService.php';
include_once './services/Helpers.php';

class EmpresaController extends Controller{

    protected $arrayInner = array(
        "seguro" => "seguro_empresa",
    );

    protected $arraySelect = array(
        "seguro.nombre",
        "seguro.seguro_id",
        "seguro_empresa.seguro_empresa_id"
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
        global $isEnabledAudit;
        $isEnabledAudit = 'empresas';

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $empresa = EmpresaService::insertarEmpresa($_POST);
        Helpers::retornarMensaje(true, $empresa);
    }

    public function actualizarEmpresa($empresa_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        EmpresaService::actualizarEmpresa($_POST, $empresa_id);

        $validarEmpresa = new Validate;
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        $respuesta->setData($validarEmpresa->dataScape($_POST));
        return $respuesta->json(200);
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

        $validarEmpresa = new Validate;

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
