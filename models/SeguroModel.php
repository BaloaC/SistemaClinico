<?php

require_once 'GenericModel.php';

class SeguroModel extends GenericModel {

    protected $rif;
    protected $nombre;
    protected $direccion;
    protected $telefono;
    protected $porcentaje;
    protected $costo_consulta;
    protected $estatus_seg;
    protected $maximo_dias;

    public function __construct($propiedades = null) {
        parent::__construct('seguro', SeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getRif(){return $this->rif;}
    public function getNombre(){return $this->nombre;}
    public function getDireccion(){return $this->direccion;}
    public function getTelefono(){return $this->telefono;}
    public function getPorcentaje(){return $this->porcentaje;}
    public function getCostoConsulta(){return $this->costo_consulta;}
    public function getEstatusSeg(){return $this->estatus_seg;}
    public function getMaximoDias(){return $this->maximo_dias;}

    /* Setters */
    public function setRif($rif){return $this->rif = $rif;}
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setTelefono($telefono){return $this->telefono = $telefono;}
    public function setPorcentaje($porcentaje){return $this->porcentaje = $porcentaje;}
    public function setCostoConsulta($costo_consulta){return $this->costo_consulta = $costo_consulta;}
    public function setEstatusSeg($estatus_seg){return $this->estatus_seg = $estatus_seg;}
    public function setMaximoDias($maximo_dias){return $this->maximo_dias = $maximo_dias;}
}

?>