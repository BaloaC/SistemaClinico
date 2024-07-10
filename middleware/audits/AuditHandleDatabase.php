<?php

class AuditHandleDatabase extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        global $isEnabledAudit;

        $accion_realizada = $isEnabledAudit == 'importarBD' ? 'Importó' : 'Exportó';
        $row = "El usuario ".$this->usuario->nombre." ".$accion_realizada." la base de datos";
        
        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => 'respaldo/restauración',
            "descripcion" => $row,
            "modulo" => 'base de datos',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}