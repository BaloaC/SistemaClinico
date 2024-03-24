<?php

include_once './services/medico/especialidad/especialidadValidaciones.php';
include_once './services/Helpers.php';

class EspecialidadController extends Controller{

    protected $arrayInner = array(
        "medico" => "medico_especialidad",
        "especialidad" => "medico_especialidad",
    );

    protected $arraySelect = array(
        "medico.medico_id",
        "medico.nombre",
        "medico.apellidos"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('especialidades/index');
    }

    public function formRegistrarEspecialidades(){

        return $this->view('especialidades/registrarEspecialidades');
    }

    public function formActualizarEspecialidad($especialidad_id){

        return $this->view('especialidades/actualizarEspecialidades', ['especialidad_id' => $especialidad_id]);
    }

    public function insertarEspecialidad(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'especialidad';
        $_POST = json_decode(file_get_contents('php://input'), true);
        EspecialidadValidaciones::validacionesGenerales($_POST);
        
        $validarEspecialidad = new Validate;
        $data = $validarEspecialidad->dataScape($_POST);

        $_especialidadModel = new EspecialidadModel();
        $id = $_especialidadModel->insert($data);

        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        $respuesta->setData($data);
        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarEspecialidades(){
        $_especialidadModel = new EspecialidadModel();
        $_especialidadModel->where('estatus_esp', '=', '1');

        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_especialidadModel->limit([$primer_registro, $size]);
            }

            if (strlen($_GET['search']['value']) > 0) {
                $_especialidadModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            }
        }

        $especialidades =  $_especialidadModel->getAll();
        $_especialidadModel->resetValues();

        if (strlen($_GET['search']['value']) > 0) {
            $_especialidadModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        } else {
            $_especialidadModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_especialidadModel->where('estatus_esp', '=', '1')->getAll();
        
        Helpers::retornarGet(($_GET['draw'] ? $_GET['draw'] : 0), $total_registros[0]->total, $especialidades);
    }

    public function listarEspecialidadPorId($especialidad_id){

        $_especialidadModel = new EspecialidadModel();
        $medico = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->where('estatus_esp', '=', '1')->getFirst();
        $mensaje = ($medico != null);

        Helpers::retornarMensaje($mensaje, $medico);
    }

    public function actualizarEspecialidad($especialidad_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'especialidad';

        $_POST = json_decode(file_get_contents('php://input'), true);
        EspecialidadValidaciones::validacionesGenerales($_POST);
        EspecialidadValidaciones::validarExistenciaEspecialidad($especialidad_id);

        $validarEspecialidad = new Validate;
        $data = $validarEspecialidad->dataScape($_POST);

        $_especialidadModel = new EspecialidadModel();
        $actualizado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->update($data);

        $mensaje = ($actualizado > 0);
        
        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);
        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarEspecialidad($especialidad_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'especialidad';

        $_especialidadModel = new EspecialidadModel();
        $data = array(
            "estatus_esp" => "2"
        );

        $eliminado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
