<?php

require_once 'GenericModel.php';

class EspecialidadModel extends GenericModel {

    protected $nombre;
    protected $estatus_esp;

    public function __construct($propiedades = null) {
        parent::__construct('especialidad', EspecialidadModel::class, $propiedades);
    }

    /* Getters */
    public function getNombres(){return $this->nombres;}
    public function getEstatusEsp(){return $this->estatus_esp;}
    
    /* Setters */
    public function setNombres($nombres){return $this->nombres = $nombres;}
    public function setEstatusEsp($estatus_esp){return $this->estatus_esp = $estatus_esp;}
}

?>