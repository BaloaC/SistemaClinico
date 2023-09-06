<?php

require_once 'GenericModel.php';

class ConsultaInsumoModel extends GenericModel {

    protected $consulta_id;
    protected $insumo_id;
    protected $precio_insumo_bs;
    protected $precio_insumo_usd;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_insumo', ConsultaInsumoModel::class, $propiedades);
    }
	
    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getInsumoId(){return $this->insumo_id;}
    public function getPrecioInsumoBs(){return $this->precio_insumo_bs;}
    public function getPrecioInsumoUsd(){return $this->precio_insumo_usd;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setInsumoId($insumo_id){return $this->insumo_id = $insumo_id;}
    public function setPrecioInsumoBs($precio_insumo_bs){return $this->precio_insumo_bs = $precio_insumo_bs;}
    public function setPrecioInsumoUsd($precio_insumo_usd){return $this->precio_insumo_usd = $precio_insumo_usd;}
}

?>