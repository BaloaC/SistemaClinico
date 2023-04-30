<?php

require_once 'GenericModel.php';

class PacienteBeneficiadoModel extends GenericModel {

    protected $paciente_beneficiado_id;
    protected $paciente_id;
    protected $estatus_pac;

    public function __construct($propiedades = null) {
        parent::__construct('paciente_beneficiado', PacienteBeneficiadoModel::class, $propiedades);
    }
	
    /* Getters */
    public function getPacienteBeneficiadoId(){return $this->paciente_beneficiado_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getEstatusPaciente(){return $this->estatus_pac;}

    /* Setters */
    public function setPacienteBeneficiadoId($paciente_beneficiado_id){return $this->paciente_beneficiado_id = $paciente_beneficiado_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setEstatusPaciente($estatus_pac){return $this->estatus_pac = $estatus_pac;}
}

?>