<?php

require_once 'GenericModel.php';

class MedicoEspecialidadModel extends GenericModel {

    protected $medico_id;
    protected $especialidad_id;
    protected $estatus_med;

    public function __construct($propiedades = null) {
        parent::__construct('medico_especialidad', MedicoEspecialidadModel::class, $propiedades);
    }

    /* Getters */
    public function getMedico_id(){return $this->medico_id;}
    public function getEspecialidad_id(){return $this->especialidad_id;}
    public function getEstatusMedico(){return $this->estatus_med;}
    
    /* Setters */
    public function setMedico_id($medico_id){return $this->medico_id = $medico_id;}
    public function setEspecialidad_id($especialidad_id){return $this->especialidad_id = $especialidad_id;}
    public function setEstatusMedico($estatus_med){return $this->estatus_med = $estatus_med;}
}

?>