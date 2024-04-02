<?php

class AuditGlobal extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        global $isEnabledAudit;

        if ($this->method == 'PUT') {
            $row = "El usuario ".$this->usuario->nombre." actualizó el valor de  la orden de ".$isEnabledAudit;
        }
        
        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => 'actualización',
            "descripcion" => $row
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}