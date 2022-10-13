<?php

require_once 'GenericModel.php';

class CitaModel extends GenericModel {

    protected $paciente_id;
    protected $medico_id;
    protected $fecha_cita;
    protected $motivo_cita;
    protected $cedula_titular;

    public function __construct($propiedades = null) {
        parent::__construct('cita', CitaModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getMedicoId(){return $this->medico_id;}
    public function getFechaCita(){return $this->fecha_cita;}
    public function getMotivoCita(){return $this->motivo_cita;}
    public function getCedulaTitular(){return $this->cedula_titular;}

    /* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setMedicoId($medico_id){return $this->medico_id = $medico_id;}
    public function setFechaCita($fecha_cita){return $this->fecha_cita = $fecha_cita;}
    public function setMotivoCita($motivo_cita){return $this->motivo_cita = $motivo_cita;}
    public function setCedulaTitular($cedula_titular){return $this->cedula_titular = $cedula_titular;}
}

?>