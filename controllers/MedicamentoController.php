<?php

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

        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposNumericos = array("tipo_medicamento");
        $camposId = array("especialidad_id");
        $validarMedicamento = new Validate;
        
        switch($validarMedicamento) {
            case ($validarMedicamento->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
       
            case !$validarMedicamento->existsInDB($_POST, $camposId):
                $respuesta = new Response(false, 'No se encontraron registros de esa especialidad');
                return $respuesta->json(400);

            case $validarMedicamento->isNumber($_POST, $camposNumericos):
                $respuesta = new Response(false, 'DATOS_INVALIDOS');
                return $respuesta->json(400);

            default:
                
                $data = $validarMedicamento->dataScape($_POST);
                $_medicamentoModel = new MedicamentoModel();
                $id = $_medicamentoModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function actualizarMedicamento($medicamento){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposNumericos = array("tipo_medicamento");
        $camposId = array("especialidad_id");
        $validarMedicamento = new Validate;
        
        switch($validarMedicamento) {
            case ($validarMedicamento->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case !($validarMedicamento->isDuplicated('medicamento', 'medicamento_id', $medicamento)):
                $respuesta = new Response(false, 'No se han encontrado registros del medicamento indicado');
                return $respuesta->json(400);
       
            case $validarMedicamento->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            default:
                
                if ( array_key_exists('especialidad_id', $_POST) && $validarMedicamento->existsInDB($_POST, $camposId) ) {
                    $respuesta = new Response(false, 'No hay registros de la especialidad indicada');
                    return $respuesta->json(400);
                }

                $data = $validarMedicamento->dataScape($_POST);
                $_medicamentoModel = new MedicamentoModel();
                $id = $_medicamentoModel->where('medicamento_id', '=', $medicamento)->update($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function eliminarMedicamento($medicamento_id){
        
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
        $inners = $_medicamentoModel->listInner($this->arrayInner);
        $lista = $_medicamentoModel->where('medicamento.estatus_med', '=', '1')->innerJoin($this->arraySelect, $inners, "medicamento");
        $mensaje = (count($lista) > 0);
        return $this->retornarMensaje($mensaje, $lista);
    }

    public function listarMedicamentosPorEspecialidad($especialidad_id){

        $_medicamentoModel = new MedicamentoModel();
        $lista = $_medicamentoModel->where('estatus_med', '=', '1')->where('especialidad_id', '=', $especialidad_id)->getAll();
        $mensaje = (count($lista) > 0);
        return $this->retornarMensaje($mensaje, $lista);
    }

    public function listarMedicamentoPorId($medicamento_id){

        $_medicamentoModel = new MedicamentoModel();
        $inners = $_medicamentoModel->listInner($this->arrayInner);
        $insumo = $_medicamentoModel->where('medicamento.estatus_med', '=', '1')->where('medicamento.medicamento_id', '=', $medicamento_id)->innerJoin($this->arraySelect, $inners, "medicamento");
        $mensaje = ($insumo != null);
        return $this->retornarMensaje($mensaje, $insumo);
    }

    // Funciones
    public function retornarMensaje($mensaje, $dataReturn) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($dataReturn);
        return $respuesta->json(200);
    }
}
