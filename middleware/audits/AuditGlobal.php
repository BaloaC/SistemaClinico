<?php

class AuditGlobal extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        global $isEnabledAudit;

        if (array_key_exists('porcentaje_medico', $_POST)) {
            $row = "El usuario ".$this->usuario->nombre." Actualizó el porcentaje de pago al médico a ".$_POST['porcentaje_medico'];
        }
        
        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => 'actualización',
            "descripcion" => $row,
            "modulo" => 'médicos',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}