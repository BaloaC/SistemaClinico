<?php

require_once 'GenericModel.php';

class ConsultaInsumoModel extends GenericModel {

    protected $consulta_id;
    protected $insumo_id;
    protected $cantidad;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_insumo', ConsultaInsumoModel::class, $propiedades);
    }
	
    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getInsumoId(){return $this->insumo_id;}
    public function getCantidad(){return $this->cantidad;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setInsumoId($insumo_id){return $this->insumo_id = $insumo_id;}
    public function setCantidad($cantidad){return $this->$cantidad = $cantidad;}
}

?>