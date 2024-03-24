<?php

class AuditConsulta extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $tipoConsulta = "";

        if ( isset($_POST['cita_id']) ) {
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', $_POST['cita_id'])->getFirst();
            $tipoConsulta = $cita->tipo_cita == 1 ? 'natural' : 'asegurada';

        } else {
            $tipoConsulta = 'natural';
        }
        
        if (isset($_POST['es_emergencia']) && $_POST['es_emergencia']) {
            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('cedula', '=', $_POST['cedula_beneficiado'])->getFirst();
            $row = "El usuario ".$this->usuario->nombre." insertó la consulta por emergencia del paciente con cédula ".$paciente->cedula;

        } else if (isset($_POST['cita_id'])) {
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', $_POST['cita_id'])->getFirst();

            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('paciente_id', '=', $cita->paciente_id)->getFirst();
            $row = "El usuario ".$this->usuario->nombre." insertó la consulta ".$tipoConsulta." del paciente con cédula ".$paciente->cedula;

        } else if (isset($_POST['paciente_id'])) {
            
            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('paciente_id', '=', $_POST['paciente_id'])->getFirst();
            $row = "El usuario ".$this->usuario->nombre." insertó la consulta ".$tipoConsulta." del paciente con cédula ".$paciente->cedula;
        }

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => 'inserción',
            "descripcion" => $row
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}