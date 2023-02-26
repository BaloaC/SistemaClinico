<?php

require_once 'GenericModel.php';

class AuditoriaModel extends GenericModel{

    protected $usuario_id;
    protected $accion;
    protected $descripcion;

    public function __construct($propiedades = null){
        parent::__construct('auditoria', AuditoriaModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuario_id;}
    public function getAccion(){return $this->accion;}
    public function getdescripcion(){return $this->descripcion;}

    /* Setters */
    public function setUsuarioId($usuario_id){$this->usuario_id = $usuario_id;}
    public function setAccio($accions){$this->accions = $accions;}
    public function setdescripcion($descripcion){$this->descripcion = $descripcion;}
}


?>