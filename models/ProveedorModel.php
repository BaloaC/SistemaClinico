<?php

require_once 'GenericModel.php';

class ProveedorModel extends GenericModel {

    protected $nombre;
    protected $ubicacion;

    public function __construct($propiedades = null) {
        parent::__construct('proveedor', ProveedorModel::class, $propiedades);
    }

    /* Getters */
    public function getNombre(){return $this->nombre;}
    public function getUbicacion(){return $this->ubicacion;}

    /* Setters */
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setUbicacion($ubicacion){return $this->ubicacion = $ubicacion;}
}

?>