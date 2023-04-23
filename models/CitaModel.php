<?php

require_once 'GenericModel.php';

class CitaModel extends GenericModel {

    protected $paciente_id;
    protected $medico_id;
    protected $especialidad_id;
    protected $seguro_id;
    protected $fecha_cita;
    protected $motivo_cita;
    protected $tipo_cita;
    protected $cedula_titular;
    protected $clave;
    protected $estatus_cit;

    public function __construct($propiedades = null) {
        parent::__construct('cita', CitaModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getMedicoId(){return $this->medico_id;}
    public function getEspecialidadId(){return $this->especialidad_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getFechaCita(){return $this->fecha_cita;}
    public function getMotivoCita(){return $this->motivo_cita;}
    public function getTipoCita(){return $this->tipo_cita;}
    public function getCedulaTitular(){return $this->cedula_titular;}
    public function getClave(){return $this->clave;}
    public function getEstatusCit(){return $this->estatus_cit;}

    /* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setMedicoId($medico_id){return $this->medico_id = $medico_id;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setFechaCita($fecha_cita){return $this->fecha_cita = $fecha_cita;}
    public function setMotivoCita($motivo_cita){return $this->motivo_cita = $motivo_cita;}
    public function setTipoCita($tipo_cita){return $this->tipo_cita = $tipo_cita;}
    public function setCedulaTitular($cedula_titular){return $this->cedula_titular = $cedula_titular;}
    public function setClave($clave){return $this->clave = $clave;}
    public function setEstatusCit($estatus_cit){return $this->estatus_cit = $estatus_cit;}
}

?>