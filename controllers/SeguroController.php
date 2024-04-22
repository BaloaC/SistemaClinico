<?php

include_once './services/Helpers.php';
include_once './services/seguros/seguro/SeguroService.php';
include_once './services/seguros/seguro/SeguroHelpers.php';
include_once './services/seguros/seguro/SeguroValidaciones.php';

class SeguroController extends Controller{

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
        global $isEnabledAudit;
        $isEnabledAudit = 'seguros';

        $_POST = json_decode(file_get_contents('php://input'), true);
        SeguroService::insertarSeguro($_POST);
    }

    public function listarSeguros(){

        $_seguroModel = new SeguroModel();
        $_seguroModel->where('estatus_seg', '=', '1');
        
        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_seguroModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_seguroModel->where("CONCAT(nombre, ' ', rif)", 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_seguroModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
                }
            }

            // if (strlen($_GET['search']['value']) > 0) {
            //     $_seguroModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            // }
        }

        $seguros = $_seguroModel->getAll();
        $seguro_lista = array();

        foreach ($seguros as $seguro) {
            $_seguroExamenModel = new SeguroExamenModel();
            $seguroExamen = $_seguroExamenModel->where('seguro_id', '=', $seguro->seguro_id)->getFirst();
            $lista_examenes = explode(',', $seguroExamen->examenes);
            $seguro->cantidad_examenes = count($lista_examenes);
            // $seguro_lista[] = SeguroService::ListarTodos($seguro);
            $seguro_lista[] = $seguro;
        }

        $_seguroModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_seguroModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_seguroModel->setSelect('COUNT(*) AS total')->where("CONCAT(nombre, ' ', rif)", 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_seguroModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_seguroModel->setSelect('COUNT(*) AS total');
        }

        // if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
        //     $_seguroModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        // } else {
        //     $_seguroModel->setSelect('COUNT(*) AS total');
        // }

        $total_registros = $_seguroModel->where('estatus_seg', '=', '1')->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $seguro_lista);
    }

    public function listarSeguroPorId($seguro_id){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->getFirst();

        if ($seguro) {

            $seguro_lista = array();   

            $seguro_lista = SeguroService::ListarTodos($seguro);

            $mensaje = ($seguro_lista != null);
            SeguroHelpers::retornarMensaje($mensaje, $seguro_lista);
            
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarSeguro($seguro_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'seguros';

        $_POST = json_decode(file_get_contents('php://input'), true);
        SeguroService::actualizarSeguro($_POST, $seguro_id);

        $validarSeguro = new Validate();
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        $respuesta->setData($validarSeguro->dataScape($_POST));
        return $respuesta->json(200);
    }

    public function eliminarSeguro($idSeguro){
        global $isEnabledAudit;
        $isEnabledAudit = 'seguros';

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

    public function insertarSeguroExamen($form) { // form puede ser el seguro_id o un array de datos
        SeguroService::insertarSeguroExamen($form);
    }

    public function eliminarSeguroExamen($seguro_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'seguro examen';

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        SeguroValidaciones::validarExistenciaSeguro($seguro_id);
        SeguroService::eliminarSeguroExamen($_POST, $seguro_id);
        
        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        return $respuesta->json(200);
    }
}