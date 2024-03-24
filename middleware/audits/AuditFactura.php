<?php

class AuditFactura extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();

        $request = $request;
        global $isEnabledAudit;
        $nombre_orden = explode(' ', $isEnabledAudit);
        $row = '';
        $accion = '';
        
        if ($this->method == 'DELETE') {
            if (isset($request['factura_id'])) {
                $row = "El usuario ".$this->usuario->nombre." insertó la orden de ".$nombre_orden[ count($nombre_orden) - 1 ]." con id ".$request['factura_id'];
                $accion = 'inserción';

            } else {
                $mes = date("n"); // Obtener el número de mes actual
                $mes_nombre = date("F", mktime(0, 0, 0, $mes, 1));

                $row = "El usuario ".$this->usuario->nombre." ha insertado las ordenes de ".$nombre_orden[ count($nombre_orden) - 1 ]."s del mes de ".$mes_nombre;
                $accion = 'inserción';
            }

        } else if ($this->method == 'DELETE') {
            $row = "El usuario ".$this->usuario->nombre." cambio a cancelada la orden de ".$nombre_orden[ count($nombre_orden) - 1 ]." con id ".preg_replace('/[^0-9]/', '', $_GET['uri']);
            $accion = 'actualización';
        
        } else if ($this->method == 'PUT') {
            $row = "El usuario ".$this->usuario->nombre." cambio a pagada la orden de ".$nombre_orden[ count($nombre_orden) - 1 ]." con id ".preg_replace('/[^0-9]/', '', $_GET['uri']);
            $accion = 'actualización';
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