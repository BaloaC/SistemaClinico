<?php

include_once './services/consulta/consultaValidaciones.php';

class ConsultaEmergenciaController extends Controller {

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

    public function actualizarConsultaEmergencia($consulta_emergencia_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        ConsultaValidaciones::validarActualizacion($_POST);

        $put = [
            "autorizacion" => $_POST['autorizacion'],
            "monto_aprobado" => $_POST['monto_aprobado']
        ];

        $_consultaEmergenciaModel = new ConsultaEmergenciaModel();
        $se_actualizo = $_consultaEmergenciaModel->where('consulta_emergencia_id', '=', $consulta_emergencia_id)->update($put);

        $respuesta = new Response($se_actualizo <= 0 ? 'ACTUALIZACION_FALLIDA' : 'ACTUALIZACION_EXITOSA');
        return $respuesta->json($se_actualizo <= 0 ? 400 : 200);
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
