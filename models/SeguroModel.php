<?php

require_once 'GenericModel.php';

class SeguroModel extends GenericModel {

    protected $rif;
    protected $nombre;
    protected $direccion;
    protected $porcentaje;
    protected $tipo_seguro;

    public function __construct($propiedades = null) {
        parent::__construct('seguro', SeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getRif(){return $this->rif;}
    public function getNombre(){return $this->nombre;}
    public function getDireccion(){return $this->direccion;}
    public function getPorcentaje(){return $this->porcentaje;}
    public function getTipoSeguro(){return $this->tipo_seguro;}

    /* Setters */
    public function setRif($rif){return $this->rif = $rif;}
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setPorcentaje($porcentaje){return $this->porcentaje = $porcentaje;}
    public function setTipoSeguro($tipo_seguro){return $this->tipo_seguro = $tipo_seguro;}
}

?>