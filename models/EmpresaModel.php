<?php

require_once 'GenericModel.php';

class EmpresaModel extends GenericModel {

    protected $rif;
    protected $nombre;
    protected $direccion;

    public function __construct($propiedades = null) {
        parent::__construct('empresa', EmpresaModel::class, $propiedades);
    }

    /* Getters */
    public function getRif(){return $this->rif;}
    public function getNombre(){return $this->nombre;}
    public function getDireccion(){return $this->direccion;}

    /* Setters */
    public function setRif($rif){return $this->rif =$rif;}
    public function setNombre($nombre){return $this->nombre =$nombre;}
    public function setDireccion($direccion){return $this->direccion =$direccion;}
}

?>