<?php

require_once 'GenericModel.php';

class PacienteSeguroModel extends GenericModel {

    protected $paciente_id;
    protected $seguro_id;
    protected $empresa_id;
    protected $tipo_seguro;
    protected $cobertura_general;
    protected $fecha_contra;
    protected $saldo_disponible;
    protected $estatus_pac;

    public function __construct($propiedades = null) {
        parent::__construct('paciente_seguro', PacienteSeguroModel::class, $propiedades);
    }
	
    /* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getEmpresaId(){return $this->empresa_id;}
    public function getTipo_seguro(){return $this->tipo_seguro;}
    public function getCobertura_general(){return $this->cobertura_general;}
    public function getFechaContra(){return $this->fecha_contra;}
    public function getSaldoDisponible(){return $this->saldo_disponible;}
    public function getEstatusPaciente(){return $this->estatus_pac;}

    /* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setEmpresaId($empresa_id){return $this->empresa_id = $empresa_id;}
    public function setTipo_seguro($tipo_seguro){return $this->tipo_seguro = $tipo_seguro;}
    public function setCobertura_general($cobertura_general){return $this->cobertura_general = $cobertura_general;}
    public function setFechaContra($fecha_contra){return $this->fecha_contra = $fecha_contra;}
    public function setSaldoDisponible($saldo_disponible){return $this->saldo_disponible = $saldo_disponible;}
    public function setEstatusPaciente($estatus_pac){return $this->estatus_pac = $estatus_pac;}
}

?>