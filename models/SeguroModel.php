<?php

require_once 'GenericModel.php';

class SeguroModel extends GenericModel {

    protected $rif;
    protected $nombre;
    protected $direccion;
    protected $telefono;
    protected $estatus_seg;

    public function __construct($propiedades = null) {
        parent::__construct('seguro', SeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getRif(){return $this->rif;}
    public function getNombre(){return $this->nombre;}
    public function getDireccion(){return $this->direccion;}
    public function getTelefono(){return $this->telefono;}
    public function getEstatusSeg(){return $this->estatus_seg;}

    /* Setters */
    public function setRif($rif){return $this->rif = $rif;}
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setTelefono($telefono){return $this->telefono = $telefono;}
    public function setEstatusSeg($estatus_seg){return $this->estatus_seg = $estatus_seg;}
}

?>