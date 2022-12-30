<?php

require_once 'GenericModel.php';

class LoginModel extends GenericModel {

    protected $usuario_id;
    protected $nombre;
    protected $clave;
    protected $fecha_creacion;

    public function __construct($propiedades = null) {
        parent::__construct('usuario', LoginModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuario_id;}
    public function getNombre(){return $this->nombre;}
    public function getClave(){return $this->clave;}
    public function getFecha_creacion(){return $this->fecha_creacion;}

    /* Setters */
    public function setUsuarioId($usuario_id){return $this->usuario_id = $usuario_id;}
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setClave($clave){return $this->clave = $clave;}
    public function setFecha_creacion($fecha_creacion){return $this->fecha_creacion = $fecha_creacion;}
}

?>