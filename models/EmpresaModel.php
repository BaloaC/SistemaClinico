<?php

require_once 'GenericModel.php';

class EmpresaModel extends GenericModel {

    protected $rif;
    protected $nombre;
    protected $direccion;
    protected $estatus_emp;

    public function __construct($propiedades = null) {
        parent::__construct('empresa', EmpresaModel::class, $propiedades);
    }

    /* Getters */
    public function getRif(){return $this->rif;}
    public function getNombre(){return $this->nombre;}
    public function getDireccion(){return $this->direccion;}
    public function getEstatus_emp(){return $this->estatus_emp;}

    /* Setters */
    public function setRif($rif){return $this->rif =$rif;}
    public function setNombre($nombre){return $this->nombre =$nombre;}
    public function setDireccion($direccion){return $this->direccion =$direccion;}
    public function setEstatus_emp($estatus_emp){return $this->estatus_emp =$estatus_emp;}
}

?>