<?php

require_once 'GenericModel.php';

class CompraInsumoModel extends GenericModel {

    protected $insumo_id;
    protected $factura_compra_id;
    protected $unidades;
    protected $precio_unit;
    protected $precio_total;

    public function __construct($propiedades = null) {
        parent::__construct('compra_insumo', CompraInsumoModel::class, $propiedades);
    }

    /* Getters */
    public function getInsumoId(){return $this->insumo_id;}
    public function getFacturaCompraId(){return $this->factura_compra_id;}
    public function getUnidades(){return $this->unidades;}
    public function getPrecioUnit(){return $this->precio_unit;}
    public function getPrecioTotal(){return $this->precio_total;}

    /* Setters */
    public function setInsumoId($insumo_id){return $this->insumo_id = $insumo_id;}
    public function setFacturaCompraId($factura_compra_id){return $this->factura_compra_id = $factura_compra_id;}
    public function setUnidades($unidades){return $this->unidades = $unidades;}
    public function setPrecioUnit($precio_unit){return $this->precio_unit = $precio_unit;}
    public function setPrecioTotal($precio_total){return $this->precio_total = $precio_total;}
}

?>