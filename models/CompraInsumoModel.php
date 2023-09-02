<?php

require_once 'GenericModel.php';

class CompraInsumoModel extends GenericModel {

    protected $insumo_id;
    protected $factura_compra_id;
    protected $unidades;
    protected $precio_unit_bs;
    protected $precio_total_bs;
    protected $precio_unit_usd;
    protected $precio_total_usd;

    public function __construct($propiedades = null) {
        parent::__construct('compra_insumo', CompraInsumoModel::class, $propiedades);
    }

    /* Getters */
    public function getInsumoId(){return $this->insumo_id;}
    public function getFacturaCompraId(){return $this->factura_compra_id;}
    public function getUnidades(){return $this->unidades;}
    public function getPrecioUnitBs(){return $this->precio_unit_bs;}
    public function getPrecioTotalBs(){return $this->precio_total_bs;}
    public function getPrecioUnitUsd(){return $this->precio_unit_usd;}
    public function getPrecioTotalUsd(){return $this->precio_total_usd;}

    /* Setters */
    public function setInsumoId($insumo_id){return $this->insumo_id = $insumo_id;}
    public function setFacturaCompraId($factura_compra_id){return $this->factura_compra_id = $factura_compra_id;}
    public function setUnidades($unidades){return $this->unidades = $unidades;}
    public function setPrecioUnitBs($precio_unit_bs){return $this->precio_unit_bs = $precio_unit_bs;}
    public function setPrecioTotalBs($precio_total_bs){return $this->precio_total_bs = $precio_total_bs;}
    public function setPrecioUnitUsd($precio_unit_usd){return $this->precio_unit_usd = $precio_unit_usd;}
    public function setPrecioTotalUsd($precio_total_usd){return $this->precio_total_usd = $precio_total_usd;}
}

?>