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
        $paciente = $_paciente->where('paciente_id', '=', $_POST['paciente_id'])->getFirst();
        
        if ($this->method == 'POST') {
            $row = "El usuario ".$this->usuario->nombre." insertó un nuevo antecedente médico de tipo ".$_POST['tipo_antecedente_id']." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'inserción';
        
        } else if ($this->method == 'PUT') {
            $row = "El usuario ".$this->usuario->nombre." actualizó el antecedente_id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'actualización';

        } else if ($this->method == 'DELETE') {
            $row = "El usuario ".$this->usuario->nombre." eliminó el antecedente_id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." al paciente ".$paciente->nombre." con cédula ".$paciente->cedula;
            $accion = 'eliminación';
        }
        
        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => $accion,
            "descripcion" => $row
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}