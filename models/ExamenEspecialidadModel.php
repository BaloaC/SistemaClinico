<?php

require_once 'GenericModel.php';

class ExamenEspecialidadModel extends GenericModel {

    protected $examen_id;
    protected $especialidad_id;
    protected $estatus_exa;

    public function __construct($propiedades = null) {
        parent::__construct('examen_especialidad', ExamenEspecialidadModel::class, $propiedades);
    }

    /* Getters */
    public function getExamenId(){return $this->examen_id;}
    public function getEspecialidadId(){return $this->especialidad_id;}
    public function getEstatusExa(){return $this->estatus_exa;}
    
    /* Setters */
    public function setExamenId($examen_id){return $this->examen_id = $examen_id;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
    public function setEstatusExa($estatus_exa){return $this->estatus_exa = $estatus_exa;}
}

?>