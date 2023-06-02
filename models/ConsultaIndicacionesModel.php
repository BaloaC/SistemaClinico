<?php

require_once 'GenericModel.php';

class ConsultaIndicacionesModel extends GenericModel {

    protected $consulta_id;
    protected $descripcion;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_indicaciones', ConsultaIndicacionesModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getDescripcion(){return $this->descripcion;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setDescripcion($descripcion){return $this->descripcion = $descripcion;}
}

?>