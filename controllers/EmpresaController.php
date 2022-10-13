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

    public function insertarEmpresas(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        var_dump($_POST);
        $_EmpresaModel = new EmpresaModel();
        $id = $_EmpresaModel->insert($_POST);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarEmpresas(){

        $_EmpresaModel = new EmpresaModel();
        $lista = $_EmpresaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarEmpresasPorId($idEmpresa){

        $_EmpresaModel = new EmpresaModel();
        $empresa = $_EmpresaModel->where('empresa_id','=',$idEmpresa)->getFirst();
        $mensaje = ($empresa != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($empresa);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarEmpresa(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_EmpresaModel = new EmpresaModel();

        $actualizado = $_EmpresaModel->where('empresa_id','=',$_POST['idEmpresa'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarEmpresa($idEmpresa){

        $_EmpresaModel = new EmpresaModel();

        $eliminado = $_EmpresaModel->where('empresa_id','=',$idEmpresa)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>