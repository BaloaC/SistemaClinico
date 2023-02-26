<?php

class AuditoriaController extends Controller{

    //Método index (vista principal)
    public function index(){
        return $this->view('auditoria/index');
    }

    
    public function listarAuditoria(){

        $_auditoriaModel = new AuditoriaModel();
        $lista = $_auditoriaModel->getAll();
        return $this->retornarMensaje($lista);
    }

    public function listarAuditoriaPorFecha(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarAuditoria = new Validate;

        if ( $validarAuditoria->isDate($_POST['fecha_inicio']) || $validarAuditoria->isDate($_POST['fecha_fin']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);

        } else if ( $_POST['fecha_inicio'] > $_POST['fecha_fin']) {
            $respuesta = new Response(false, 'La fecha de inicio no puede ser mayor a la fecha final');
            return $respuesta->json(400);

        } else {

            $_auditoriaModel = new AuditoriaModel();
            $id = $_auditoriaModel->whereDate('fecha_accion',$_POST['fecha_inicio'],$_POST['fecha_fin'])->getAll();
            return $this->retornarMensaje($id);
        }        
    }

    public function listarAuditoriaPorAccion() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        $auditoria = $_auditoriaModel->where('accion', '=', $_POST['accion'])->getAll();
        return $this->retornarMensaje($auditoria);
    }

    public function listarAuditoriaPorUsuario($usuario_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        $auditoria = $_auditoriaModel->where('usuario_id', '=', $usuario_id)->getAll();
        return $this->retornarMensaje($auditoria);
    }

    // utils
    public function retornarMensaje($id) {
        $mensaje = (count($id) > 0);

        if ($mensaje) {
            $respuesta = new Response('CORRECTO');
        } else {
            $respuesta = new Response(false, 'No existen registros auditables para esa fecha o acción');
        }
        $respuesta->setData($id);
        return $respuesta->json($mensaje ? 200 : 400);
    }
}

?>