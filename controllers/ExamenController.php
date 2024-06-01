<?php

include_once "./services/examen/ExamenValidaciones.php";
include_once "./services/examen/ExamenHelpers.php";
include_once './services/Helpers.php';

class ExamenController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('examenes/index');
    }

    public function formRegistrarExamenes(){

        return $this->view('examenes/registrarExamenes');
    }

    public function formActualizarExamen($examen_id){
        
        return $this->view('examenes/actualizarExamenes', ['examenes_id' => $examen_id]);
    } 

    public function insertarExamen(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'exámenes';

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $validarExamen = new Validate;
        ExamenValidaciones::validarExamen($_POST);

        if (array_key_exists('especialidades', $_POST)) {
            ExamenValidaciones::validarEspecialidad($_POST['especialidades']);
        }

        $data = $validarExamen->dataScape($_POST);    

        $_examenModel = new ExamenModel();
        $id = $_examenModel->insert($data);
        $mensaje = ($id > 0);

        if (array_key_exists('especialidades', $_POST) && $mensaje) {
            ExamenHelpers::insertarEspecialidad($_POST['especialidades'], $id);
        }

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        return $respuesta->json($mensaje ? 201 : 400);
    }

    public function listarExamen(){

        $_examenModel = new ExamenModel();
        $_examenModel->where('estatus_exa', '=', '1');

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_examenModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_examenModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_examenModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $lista = $_examenModel->getAll();
        $_examenModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_examenModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_examenModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_examenModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_examenModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_examenModel->where('estatus_exa', '=', '1')->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $lista);
    }

    public function listarExamenPorId($examen_id){

        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('examen_id', '=', $examen_id)->where('estatus_exa', '=', '1')->getFirst();

        if (!is_null($lista)) {
            $_examenEspecialidadModel = new ExamenEspecialidadModel();
            $inners = $_examenEspecialidadModel->listInner(["especialidad" => "examen_especialidad"]);
            $select = ['examen_especialidad.examen_especialidad_id','especialidad.especialidad_id', 'especialidad.nombre'];
            $especialidades = $_examenEspecialidadModel->where('examen_especialidad.examen_id', '=', $examen_id)
                                                                ->where('examen_especialidad.estatus_exa', '!=', 2)
                                                                ->where('especialidad.estatus_esp', '!=', 2)
                                                                ->innerJoin($select, $inners, 'examen_especialidad');
            if (!is_null($especialidades)) {
                $lista->especialidades = $especialidades;
            }
            $mensaje = ($lista != null);
            $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($lista);
    
            return $respuesta->json(200);
        }

        $respuesta = new Response('NOT_FOUND');
        return $respuesta->json(400);
    }

    public function listarExamenDeLaboratorios(){
        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('estatus_exa', '=', '1')->where('tipo', '=', '2')->getAll();

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarExamenesPorEspecialidad($especialidad_id) {
        $_examenEspecialidadModel = new ExamenEspecialidadModel();
        $inners = $_examenEspecialidadModel->listInner(["examen" => "examen_especialidad"]);
        $lista = $_examenEspecialidadModel->where('examen.estatus_exa', '!=', 2)
                                        ->where('examen_especialidad.estatus_exa', '!=', 2)
                                        ->where('examen_especialidad.especialidad_id', '=', $especialidad_id)
                                        ->innerJoin(['examen.examen_id', 'examen.nombre', 'examen.precio_examen', 'examen.tipo'], $inners, "examen_especialidad");

        $mensaje = (count($lista) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarExamenRealizados(){
        $_examenModel = new ExamenModel();
        $lista = $_examenModel->where('estatus_exa', '=', '1')->where('hecho_aqui', '=', '1')->getAll();

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function actualizarExamen($examen_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'exámenes';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $exclude = array('hecho_aqui');

        $validarExamen = new Validate();
        ExamenValidaciones::actualizarExamen($_POST);
        if (array_key_exists('especialidades', $_POST)) {
            ExamenValidaciones::validarEspecialidad($_POST['especialidades']);
        }

        $data = $validarExamen->dataScape($_POST);    

        if ( array_key_exists("hecho_aqui", $data) && $data["hecho_aqui"] != 0 && $data["hecho_aqui"] != 1) {
            $respuesta = new Response(false, 'El campo hecho aqui solo permite valores booleanos');
            return $respuesta->json(400);
        }

        if (array_key_exists('especialidades', $_POST)) {
            ExamenHelpers::insertarEspecialidad($_POST['especialidades'], $examen_id);
            unset($_POST['especialidades']);
        }
        
        if ( count($_POST) > 0) {
            $_examenModel = new ExamenModel();
            $id = $_examenModel->where('examen_id', '=', $examen_id)->update($data);
            
            if ($id <= 0) {
                $respuesta = new Response('ACTUALIZACION_FALLIDA');
                return $respuesta->json(400);
            }

        }

        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        return $respuesta->json(200);
    }

    public function eliminarExamen($examen_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'exámenes';

        $_examenModel = new ExamenModel();
        $data = array (
            "estatus_exa" => "2"
        );

        $eliminado = $_examenModel->where('examen_id','=',$examen_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarExamenEspecialidad($examen_especialidad_id) {
        $_examenEspecialidadModel = new ExamenEspecialidadModel();
        $data = array (
            "estatus_exa" => "2"
        );

        $eliminado = $_examenEspecialidadModel->where('examen_especialidad_id','=',$examen_especialidad_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
