<?php

include_once './services/medicamento/MedicamentoValidaciones.php';
include_once './services/Helpers.php';

class MedicamentoController extends Controller{

    protected $arrayInner = array(
        "especialidad" => "medicamento",
    );

    protected $arraySelect = array(
        "medicamento.medicamento_id",
        "medicamento.nombre_medicamento",
        "medicamento.tipo_medicamento",
        "medicamento.estatus_med",
        "especialidad.especialidad_id",
        "especialidad.nombre as nombre_especialidad",

    );

    //Método index (vista principal)
    public function index(){
        return $this->view('medicamentos/index');
    }

    public function formRegistrarMedicamento(){

        return $this->view('medicamentos/registrarMedicamentos');
    }

    public function formActualizarMedicamento($medicamento_id){
        
        return $this->view('medicamentos/actualizarMedicamentos', ['medicamento_id' => $medicamento_id]);
    } 

    public function insertarMedicamento(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'medicamentos';

        $_POST = json_decode(file_get_contents('php://input'), true);

        MedicamentoValidaciones::validacionesGenerales($_POST);
        MedicamentoValidaciones::validarEspecialidadId($_POST['especialidad_id']);

        $validarMedicamento = new Validate;
        
        $data = $validarMedicamento->dataScape($_POST);
        $_medicamentoModel = new MedicamentoModel();
        $id = $_medicamentoModel->insert($data);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        return $respuesta->json($mensaje ? 201 : 400);
    }

    public function actualizarMedicamento($medicamento){
        global $isEnabledAudit;
        $isEnabledAudit = 'medicamentos';

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarMedicamento = new Validate();

        MedicamentoValidaciones::validacionesGenerales($_POST);

        if ( array_key_exists('especialidad_id', $_POST) ) {
            MedicamentoValidaciones::validarEspecialidadId($_POST['especialidad_id']);
        }

        $data = $validarMedicamento->dataScape($_POST);
        $_medicamentoModel = new MedicamentoModel();
        $id = $_medicamentoModel->where('medicamento_id', '=', $medicamento)->update($data);
        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($mensaje ? 201 : 400);
    }

    public function eliminarMedicamento($medicamento_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'medicamentos';
        
        $_medicamentoModel = new MedicamentoModel();
        $data = array(
            "estatus_med" => "2"
        );

        $eliminado = $_medicamentoModel->where('medicamento_id','=',$medicamento_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarMedicamentos(){
        $_medicamentoModel = new MedicamentoModel();

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ) {
            if (isset($_GET['start'])  || isset($_GET['page'])) {

                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_medicamentoModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_medicamentoModel->where('CONCAT(medicamento.nombre_medicamento, especialidad.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_medicamentoModel->where('CONCAT(medicamento.nombre_medicamento)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $inners = $_medicamentoModel->listInner($this->arrayInner);
        $lista = $_medicamentoModel->where('medicamento.estatus_med', '=', '1')->innerJoin($this->arraySelect, $inners, "medicamento");
        
        $_medicamentoModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_medicamentoModel->setSelect('COUNT(*) AS total')->where('CONCAT(medicamento.nombre_medicamento)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_medicamentoModel->setSelect('COUNT(*) AS total')->where('CONCAT(medicamento.nombre_medicamento, especialidad.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_medicamentoModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_medicamentoModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_medicamentoModel->where('medicamento.estatus_med', '=', '1')->innerJoin($this->arraySelect, $inners, "medicamento");
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $lista);
    }

    public function listarMedicamentosPorEspecialidad($especialidad_id){

        $_medicamentoModel = new MedicamentoModel();
        $_medicamentoModel->where('estatus_med', '=', '1')->where('especialidad_id', '=', $especialidad_id);

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ) {
            if (isset($_GET['start'])  || isset($_GET['page'])) {

                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_medicamentoModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_medicamentoModel->where('CONCAT(nombre_medicamento)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_medicamentoModel->where('CONCAT(nombre_medicamento)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $lista = $_medicamentoModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($lista), $lista);
    }

    public function listarMedicamentoPorId($medicamento_id){

        $_medicamentoModel = new MedicamentoModel();
        $inners = $_medicamentoModel->listInner($this->arrayInner);
        $insumo = $_medicamentoModel->where('medicamento.estatus_med', '=', '1')->where('medicamento.medicamento_id', '=', $medicamento_id)->innerJoin($this->arraySelect, $inners, "medicamento");
        $mensaje = ($insumo != null);
        helpers::retornarMensaje($mensaje, $insumo);
    }
}
