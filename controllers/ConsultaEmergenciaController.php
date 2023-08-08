<?php

class ConsultaController extends Controller {

    // variables para el inner join de consultas
    protected $selectConsulta = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_titular",
        "seguro.seguro_id",
        "seguro.nombre AS nombre_seguro"
    );

    protected $innerConsulta = array(
        "paciente" => "consulta_emergencia",
        // "medico" => "consulta_emergencia",
        // "especialidad" => "consulta_emergencia"
    );


    //Método index (vista principal)
    public function index() {
        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas() {
        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($consulta_id) {
        return $this->view('consultas/actualizarConsultas', ['consulta_id' => $consulta_id]);
    }

    public function insertarConsulta(/*Request $request*/) {
        $_POST = json_decode(file_get_contents('php://input'), true);

        $campoId = array("paciente_id", "paciente_beneficiado_id");
        $camposNumericos = array("consultas_medicas", "laboratorios", "medicamentos", "area_observacion", "enfermeria");
        $validarConsulta = new Validate;

        switch ($validarConsulta) {
            case !$validarConsulta->existsInDB($_POST, $campoId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarConsulta->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('Campos numéricos enviados como string');
                $respuesta->setData('Los siguientes campos deben ser numéricos: "consultas_medicas", "laboratorios", "medicamentos", "area_observacion", "enfermeria"');
                return $respuesta->json(400);

            case $validarConsulta->isDate($_POST['fecha_emergencia']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarConsulta->isToday($_POST['fecha_consulta'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            default:
                
                $data = $validarConsulta->dataScape($_POST);
                $_consultaEmergencia = new ConsultaEmergenciaModel();
                $id = $_consultaEmergencia->insert($data);
                
                $seInserto = ($id > 0);
                
                $respuesta = new Response($seInserto ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                $respuesta->setData($data);
                return $respuesta->json($seInserto ? 201 : 400);
        }
    }

    public function listarConsultas() {
        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $innerConsulta = $_consultaEmergencia->listInner($this->innerConsulta); 
        $consultaList = $_consultaEmergencia->where('estatus_con', '!=', '2')
                                            ->innerJoin($this->selectConsulta, $innerConsulta, "consulta_emergencia");
        $consultas = [];
        foreach ($consultaList as $consulta) {
            $_pacienteBeneficiado = new PacienteBeneficiadoModel();
            $pacienteBeneficiado = $_pacienteBeneficiado->where('paciente_beneficiado_id', '=', $consulta->paciente_beneficiado_id)->getFirst();

            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('paciente_id', '=', $pacienteBeneficiado->paciente_id)->getFirst();
            
            $consulta['beneficiado'] = $paciente;
            $consultas[] = $consulta;
        }

        $mensaje = (count($consultas) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($consultas);
        return $respuesta->json(200);
    }

    public function listarConsultaPorId($consulta_id) {

        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $innerConsulta = $_consultaEmergencia->listInner($this->innerConsulta); 
        $consulta = $_consultaEmergencia->where('estatus_con', '!=', '2')
                                            ->where('consulta_emergencia_id', '=', $consulta_id)
                                            ->innerJoin($this->selectConsulta, $innerConsulta, "consulta_emergencia");
        $consultas = [];
        // foreach ($consultaList as $consulta) {
            $_pacienteBeneficiado = new PacienteBeneficiadoModel();
            $pacienteBeneficiado = $_pacienteBeneficiado->where('paciente_beneficiado_id', '=', $consulta->paciente_beneficiado_id)->getFirst();

            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('paciente_id', '=', $pacienteBeneficiado->paciente_id)->getFirst();
            
            $consulta['beneficiado'] = $paciente;
            $consultas[] = $consulta;
        // }

        $mensaje = (count($consultas) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($consultas);
        return $respuesta->json(200);
    }
}
