<?php

require_once 'GenericModel.php';

class ConsultaExamenModel extends GenericModel {

    protected $consulta_id;
    protected $examen_id;
    protected $precio_examen_bs;
    protected $precio_examen_usd;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_examen', ConsultaExamenModel::class, $propiedades);
    }
	
    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getExamenId(){return $this->examen_id;}
    public function getPrecioExamenBs(){return $this->precio_examen_bs;}
    public function getPrecioExamenUsd(){return $this->precio_examen_usd;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setExamenId($examen_id){return $this->examen_id = $examen_id;}
    public function setPrecioExamenBs($precio_examen_bs){return $this->precio_examen_bs = $precio_examen_bs;}
    public function setPrecioExamenUsd($precio_examen_usd){return $this->precio_examen_usd = $precio_examen_usd;}
}

?>