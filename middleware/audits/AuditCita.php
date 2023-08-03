<?php

class AuditCita extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $paciente = "";
        $_paciente = new PacienteModel();

        if (array_key_exists('cedula_titular', $this->POST)) {    
            $paciente = $_paciente->where('cedula', '=', $this->POST['cedula_titular']);
        
        } else {
            $citaId = preg_replace('/[^0-9]/', '', $_GET['uri']);
            $_citaModel = new CitaModel();
            $cita = $_citaModel->where('cita_id', '=', $citaId)->getFirst();
            $paciente = $_paciente->where('cedula', '=', $cita->cedula_titular);
        }

        $function = explode("@", $request['function']);

        if ($this->method == 'POST') {

            if( $function[1] == 'reprogramarCita' ) {
                $this->row = "El usuario $this->usuario['nombre'] reprogramó la cita del paciente $paciente->nombre a la fecha $this->POST['fecha_cita']";
            } else {
                
                $this->row = "El usuario $this->usuario['nombre'] insertó cita ".$this->POST['tipo_cita'] == 1 ? 'normal' : 'asegurada'." para el paciente $paciente->nombre";
            }

        } else if ($this->method == 'PUT') {
            $this->row = "El usuario $this->usuario['nombre'] insertó la clave de la cita del paciente $paciente->nombre";
        }
    }

    public function handleResponse($request = null) {
        $this->insertAudit();
    }
}