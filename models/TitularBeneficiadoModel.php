<?php

require_once 'GenericModel.php';

class TitularBeneficiadoModel extends GenericModel {

    protected $titular_beneficiado_id;
    protected $paciente_beneficiado_id;
    protected $paciente_id;
    protected $tipo_relacion;
    protected $estatus_tit;

    public function __construct($propiedades = null) {
        parent::__construct('titular_beneficiado', TitularBeneficiadoModel::class, $propiedades);
    }
	
    /* Getters */
    public function getTitularBeneficiadoId(){return $this->titular_beneficiado_id;}
    public function getPacienteBeneficiadoId(){return $this->paciente_beneficiado_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getTipoRelacion(){return $this->tipo_relacion;}
    public function getEstatusPaciente(){return $this->estatus_tit;}

    /* Setters */
    public function setTitularBeneficiadoId($titular_beneficiado_id){return $this->titular_beneficiado_id = $titular_beneficiado_id;}
    public function setPacienteBeneficiadoId($paciente_beneficiado_id){return $this->paciente_beneficiado_id = $paciente_beneficiado_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setTipoRelacion($tipo_relacion){return $this->tipo_relacion = $tipo_relacion;}
    public function setEstatusPaciente($estatus_tit){return $this->estatus_tit = $estatus_tit;}
}

?>