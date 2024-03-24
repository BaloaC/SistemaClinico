<?php

class AuditHorario extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $accion = '';
        
        $_horario = new HorarioModel();
        $horario = $_horario->where('horario_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();
        $_medico = new MedicoModel();
        $medico = $_medico->where('medico_id', '=', $horario->medico_id)->getFirst();

        if ($this->method == 'DELETE') {
            $row = "El usuario ".$this->usuario->nombre." eliminó el horario_id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." del medico ".$medico->nombre." con cedula  ".$medico->cedula;
            $accion = 'inserción';
        
        } else if ($this->method == 'PUT') {
            $row = "El usuario ".$this->usuario->nombre." actualizó el medicamento_id ".preg_replace('/[^0-9]/', '', $_GET['uri']);
            $accion = 'actualización';

        } else if ($this->method == 'DELETE') {
            $row = "El usuario ".$this->usuario->nombre." eliminó el medicamento_id ".preg_replace('/[^0-9]/', '', $_GET['uri']);
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