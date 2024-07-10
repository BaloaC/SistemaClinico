<?php

class AuditAntecedente extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $accion = '';

        $_paciente = new PacienteModel();
        $paciente = "";

        if (isset($_POST['paciente_id'])) {
            $paciente = $_paciente->where('paciente_id', '=', $_POST['paciente_id'])->getFirst();
        } else {
            $_antecedenteModel = new AntecedenteMedicoModel();
            $antecedente = $_antecedenteModel->where('antecedentes_medicos_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();

            $_pacienteModel = new PacienteModel();
            $paciente = $_pacienteModel->where('paciente_id', '=', $antecedente->paciente_id)->getFirst();
        }
        
        if ($this->method == 'POST') {

            $tipo_medicamento = "";

            switch ($_POST['tipo_antecedente_id']) {
                case '1':
                    $tipo_medicamento = "antecedente patológico";
                    break;
                
                case '2':
                    $tipo_medicamento = "antecedentes psicológicos";
                    break;
    
                case '3':
                    $tipo_medicamento = "antecedentes médicos familiares";
                    break;
    
                case '4':
                    $tipo_medicamento = "cirugía/traumatismo";
                    break;

                case '5':
                    $tipo_medicamento = "alergia";
                    break;

                case '6':
                    $tipo_medicamento = "reacción a medicamentos";
                    break;
                
                case '7':
                    $tipo_medicamento = "enfermedad Padecida";
                    break;

                case '8':
                    $tipo_medicamento = "tratamiento";
                    break;
                
                case '9':
                    $tipo_medicamento = "hábito de salud";
                    break;
                    
                default:
                    $tipo_medicamento = "";
                    break;
            }

            $row = "El usuario ".$this->usuario->nombre." insertó un nuevo antecedente médico de tipo ".$tipo_medicamento." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'inserción';
        
        } else if ($this->method == 'PUT') {
            $row = "El usuario ".$this->usuario->nombre." actualizó el antecedente_id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'actualización';

        } else if ($this->method == 'DELETE') {
            $row = "El usuario ".$this->usuario->nombre." eliminó el antecedente_id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'eliminación';
        }
        
        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => $accion,
            "descripcion" => $row,
            "modulo" => 'antecedentes',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}