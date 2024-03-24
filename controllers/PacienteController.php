<?php

include_once './services/pacientes/paciente/PacienteService.php';

class PacienteController extends Controller{

    protected $arrayInner = array(
        "seguro" => "paciente_seguro",
        "empresa" => "paciente_seguro"
    );

    protected $arraySelect = array(
        "empresa.nombre AS nombre_empresa",
        "seguro.nombre AS nombre_seguro",
        "seguro.seguro_id",
        "seguro.rif",
        "empresa.empresa_id",
        "paciente_seguro.paciente_seguro_id"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('pacientes/index');
    }

    public function historialMedico(){

        return $this->view('pacientes/historialMedico');
    }

    public function formRegistrarPacientes(){

        return $this->view('pacientes/registrarPacientes');
    }

    public function formActualizarPaciente($paciente_id){
        
        return $this->view('pacientes/actualizarPacientes', ['paciente_id' => $paciente_id]);
    } 

    public function insertarPaciente(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'pacientes';

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        PacienteValidaciones::validacionesGenerales($_POST);
        PacienteValidaciones::validarNuevoPaciente($_POST);
        PacienteValidaciones::validarPacienteSeguro($_POST);
        
        PacienteService::insertarPaciente($_POST);
        
        $respuesta = new Response('INSERCION_EXITOSA');
        $respuesta->setData($_POST);
        return $respuesta->json(200);
    }

    public function actualizarPaciente($paciente_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'pacientes';

        $_POST = json_decode(file_get_contents('php://input'), true);
                
        PacienteService::actualizarPaciente($_POST, $paciente_id);

        $respuesta = new Response('ACTUALIZACION_EXITOSA');
        $respuesta->setData($_POST);
        return $respuesta->json(200);
    }

    public function listarPacientes(){
        
        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('estatus_pac', '=', '1')->getAll();

        if ($paciente) {
            $resultado = array();

            foreach ($paciente as $pacientes) {
                
                $_medicoModel = new MedicoModel();
                $inners = $_medicoModel->listInner($this->arrayInner);
                $pacienteSeguro = $_medicoModel->where('paciente_seguro.paciente_id','=',$pacientes->paciente_id)->where('paciente_seguro.estatus_pac','=','1')->innerJoin($this->arraySelect, $inners, "paciente_seguro");
                
                if ($pacienteSeguro) { $pacientes->seguro = $pacienteSeguro; }
                $resultado[] = $pacientes;
            }
            return $this->retornarMensaje($resultado);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function listarPacientePorId($paciente_id){
        
        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->where('estatus_pac', '=', '1')->where('paciente_id', '=', $paciente_id)->getFirst();

        if ($paciente) {

            if ($paciente->tipo_paciente == 3) { // Tratamos la informacion si es titular
                // Agregamos datos de seguro
                $_pacienteSeguroModel = new PacienteSeguroModel();
                $inners = $_pacienteSeguroModel->listInner($this->arrayInner);
                $pacienteSeguro = $_pacienteSeguroModel->where('paciente_seguro.paciente_id','=',$paciente_id)->where('seguro.estatus_seg','=','1')->where('paciente_seguro.estatus_pac','=','1')->innerJoin($this->arraySelect, $inners, "paciente_seguro");
                $paciente->seguro = $pacienteSeguro; 

                if ($pacienteSeguro) { $paciente->seguro = $pacienteSeguro; } // Agregamos el seguro si existe

                // Agregamos datos del beneficiado
                $_titularBeneficiado = new TitularBeneficiadoModel();
                $titularBeneficiado = $_titularBeneficiado->where('paciente_id','=',$paciente_id)
                                                        ->where('estatus_tit','=',1)
                                                        ->getAll();
                
                if (count($titularBeneficiado) > 0) {

                    $beneficiadosList = array();
                    foreach ($titularBeneficiado as $beneficiado) {
                        
                        $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();
                        $pacienteBeneficiado = $_pacienteBeneficiadoModel->where('paciente_beneficiado_id','=',$beneficiado->paciente_beneficiado_id)
                                                            ->where('estatus_pac','=',1)
                                                            ->getFirst();

                        $_pacienteModel = new PacienteModel();
                        $infoBeneficiado = $_pacienteModel->where('paciente_id','=',$pacienteBeneficiado->paciente_id)
                                                            ->where('estatus_pac','=',1)
                                                            ->getAll();
                                                            
                        $infoBeneficiado[0]->tipo_familiar = $beneficiado->tipo_familiar;
                        $beneficiadosList[] = $infoBeneficiado[0];
                    }
                    
                    if (count($beneficiadosList) > 0) {// Agregamos el beneficiado si existe
                        $paciente->beneficiados = $beneficiadosList;
                    }
                }

            } else if ($paciente->tipo_paciente == 4) { // Tratamos la información si es beneficiado
                // Agregamos datos de seguro
                $_pacienteBeneficiado = new PacienteBeneficiadoModel();
                $pacienteBeneficiado = $_pacienteBeneficiado->where('paciente_id','=',$paciente_id)
                                                            ->where('estatus_pac','=',1)
                                                            ->getFirst();

                $_titularBeneficiado = new TitularBeneficiadoModel();
                $titularBeneficiado = $_titularBeneficiado->where('paciente_beneficiado_id','=',$pacienteBeneficiado->paciente_beneficiado_id)
                                                        ->where('estatus_tit','=',1)
                                                        ->getAll();

                // Agregamos datos del titular
                $titularesList = array();
                foreach ($titularBeneficiado as $titular) {
                    // Obtenemos datos del titular
                    $_pacienteModel = new PacienteModel();
                    $infoTitular = $_pacienteModel->where('paciente_id','=',$titular->paciente_id)
                                                    ->where('estatus_pac','=',1)
                                                    ->getFirst();

                    $infoTitular->tipo_familiar = $titular->tipo_familiar;

                    // Obtenemos los seguros del titular
                    $_pacienteSeguroModel = new PacienteSeguroModel();
                    $inners = $_pacienteSeguroModel->listInner($this->arrayInner);
                    $pacienteSeguro = $_pacienteSeguroModel->where('paciente_seguro.paciente_id','=',$infoTitular->paciente_id)
                                                            ->where('seguro.estatus_seg','=','1')
                                                            ->where('paciente_seguro.estatus_pac','=','1')
                                                            ->innerJoin($this->arraySelect, $inners, "paciente_seguro");

                    if ($pacienteSeguro) { $infoTitular->seguro = $pacienteSeguro; } // Agregamos el seguro si existe

                    $titularesList[] = $infoTitular; // Agregamos todo al objeto mayor
                }
                
                if (count($titularesList) > 0) {// Agregamos el beneficiado si existe
                    $paciente->titulares = $titularesList;
                }                
            }            
            
            return $this->retornarMensaje($paciente);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function eliminarPaciente($paciente_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'pacientes';

        $_pacienteModel = new PacienteModel();
        $data = array(
            "estatus_pac" => "2"
        );

        $eliminado = $_pacienteModel->where('paciente_id','=',$paciente_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json(200);
    }
    
    public function retornarMensaje($mensaje) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);
        return $respuesta->json(200);
    }
}
