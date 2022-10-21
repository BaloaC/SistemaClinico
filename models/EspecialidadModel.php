<?php

require_once 'GenericModel.php';

class EspecialidadModel extends GenericModel {

    protected $nombre;

    public function __construct($propiedades = null) {
        parent::__construct('especialidad', EspecialidadModel::class, $propiedades);
    }

    /* Getters */
    public function getNombres(){return $this->nombres;}
    
    /* Setters */
    public function setNombres($nombres){return $this->nombres = $nombres;}
}

?>