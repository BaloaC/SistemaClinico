<?php

class AuditPacienteSeguro extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $accion = '';
        
        $_pacienteSeguro = new PacienteSeguroModel();
        $select = array('paciente.nombre', 'paciente.apellidos', 'seguro.nombre AS seguro_nombre');
        $inner = $_pacienteSeguro->listInner(["paciente => paciente_seguro", "seguro" => "paciente_seguro"]);
        $paciente_seguro = $_pacienteSeguro->where('estatus_pac', '!=', 2)
                                            ->where('paciente_seguro_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']) )
                                            ->innerJoin($select, $inner, 'paciente_seguro');

        $row = "El usuario ".$this->usuario->nombre." removió la relación del paciente ".$paciente_seguro->nombre." ".$paciente_seguro->apellidos."  con el seguro ".$paciente_seguro->seguro_nombre;
        $accion = 'eliminación';

        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => $accion,
            "descripcion" => $row,
            "modulo" => 'pacientes',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}