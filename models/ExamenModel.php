<?php

require_once 'GenericModel.php';

class ExamenModel extends GenericModel {

    protected $nombre;
    protected $tipo;
    protected $estatus_exa;

    public function __construct($propiedades = null) {
        parent::__construct('examen', ExamenModel::class, $propiedades);
    }

    /* Getters */
    public function getNombre(){return $this->nombre;}
    public function getEstatusExa(){return $this->estatus_exa;}

    /* Setters */
    public function setNombre($nombre){return $this->nombre =$nombre;}
    public function setEstatusExa($estatus_exa){return $this->estatus_exa =$estatus_exa;}
}

?>