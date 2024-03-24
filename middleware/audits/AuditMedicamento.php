<?php

class AuditMedicamento extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $accion = '';
        
        if ($this->method == 'POST') {
            $row = "El usuario ".$this->usuario->nombre." insertó un nuevo medicamento de tipo ".$_POST['tipo_medicamento']." llamado ".$_POST['nombre_medicamento'];
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