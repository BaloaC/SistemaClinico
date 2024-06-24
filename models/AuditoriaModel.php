<?php

require_once 'GenericModel.php';

class AuditoriaModel extends GenericModel{

    protected $usuario_id;
    protected $accion;
    protected $descripcion;
    protected $modulo;
    protected $fecha_creacion;

    public function __construct($propiedades = null){
        parent::__construct('auditoria', AuditoriaModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuario_id;}
    public function getAccion(){return $this->accion;}
    public function getdescripcion(){return $this->descripcion;}
    public function getModulo(){return $this->modulo;}
    public function getFechaCreacion(){return $this->fecha_creacion;}

    /* Setters */
    public function setUsuarioId($usuario_id){$this->usuario_id = $usuario_id;}
    public function setAccion($accions){$this->accions = $accions;}
    public function setdescripcion($descripcion){$this->descripcion = $descripcion;}
    public function setModulo($modulo){$this->modulo = $modulo;}
    public function setFechaCreacion($fecha_creacion){$this->fecha_creacion = $fecha_creacion;}
}


?>