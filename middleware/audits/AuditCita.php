<?php

class AuditCita extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $paciente = "";
        $_paciente = new PacienteModel();

        $this->getToken();
        $this->getUsuario();
        $row = '';
        
        if ($this->method == 'POST') {

            if( array_key_exists('accion', $this->POST) && $this->POST['accion'] == "reprogramar") {
                $_citaModel = new CitaModel();
                $cita = $_citaModel->where('cita_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();
                $paciente = $_paciente->where('paciente_id', '=', $cita->paciente_id)->getFirst();

                $row = "El usuario ".$this->usuario->nombre." reprogramó la cita id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." del día $cita->fecha_cita del paciente ".$paciente->nombre." ".$paciente->apellidos." a la fecha ".$this->POST['fecha_cita'];
            } else {
                
                $paciente = $_paciente->where('paciente_id', '=', $this->POST['paciente_id'])->getFirst();
                $row = "El usuario ".$this->usuario->nombre." insertó una cita ".($this->POST['tipo_cita'] == 1 ? 'normal' : 'asegurada')." para el paciente ".$paciente->nombre." ".$paciente->apellidos;
            }

        } else if ($this->method == 'PUT') {
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();
            $paciente = $_paciente->where('paciente_id', '=', $cita->paciente_id)->getFirst();

            $row = "El usuario ".$this->usuario->nombre." insertó la clave de la cita id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." del paciente ".$paciente->nombre." ".$paciente->apellidos." del día $cita->fecha_cita";
        }

        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => $this->method == 'POST' ? 'inserción' : 'actualización',
            "descripcion" => $row,
            "modulo" => 'citas',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}