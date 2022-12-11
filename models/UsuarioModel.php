<?php

require_once 'GenericModel.php';

class UsuarioModel extends GenericModel{

    protected $usuario_id;
    protected $nombre;
    protected $clave;
    protected $tokken;
    protected $rol;
    protected $fecha_creacion;
    protected $estatus_usu;

    public function __construct($propiedades = null){
        
        parent::__construct('usuario', UsuarioModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuario_id;}
    public function getNombre(){return $this->nombre;}
    public function getClave(){return $this->clave;}
    public function getTokken(){return $this->tokken;}
    public function getRol(){return $this->rol;}
    public function getFecha_creacion(){return $this->fecha_creacion;}
    public function getEstatus_usu(){return $this->estatus_usu;}

    /* Setters */
    public function setUsuarioId($usuario_id){$this->usuario_id = $usuario_id;}
    public function setNombres($nombres){$this->nombres = $nombres;}
    public function setClave($clave){$this->clave = $clave;}
    public function setTokken($tokken){return $this->tokken = $tokken;}
    public function setRol($rol){return $this->rol = $rol;}
    public function setFecha_creacion($fecha_creacion){return $this->fecha_creacion = $fecha_creacion;}
    public function setEstatus_usu($estatus_usu){return $this->estatus_usu = $estatus_usu;}
}


?>