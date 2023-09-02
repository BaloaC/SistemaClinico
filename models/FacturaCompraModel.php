<?php

require_once 'GenericModel.php';

class FacturaCompraModel extends GenericModel {

    protected $proveedor_id;
    protected $fecha_compra;
    // protected $monto_total;
    protected $monto_con_iva;
    protected $monto_sin_iva;
    protected $monto_usd;
    // protected $Iva;
    protected $total_productos;
    protected $excento;
    protected $estatus_fac;

    public function __construct($propiedades = null) {
        parent::__construct('factura_compra', FacturaCompraModel::class, $propiedades);
    }

    /* Getters */
    public function getProveedorId(){return $this->proveedor_id;}
    public function getFechaCompra(){return $this->fecha_compra;}
    public function getMontoConIva(){return $this->monto_con_iva;}
    public function getMontoSinIva(){return $this->monto_sin_iva;}
    public function getMontoUsd(){return $this->monto_usd;}
    public function getTotalProductos(){return $this->total_productos;}
    public function getExcento(){return $this->excento;}   
    public function getEstatusFac(){return $this->estatus_fac;} 

    /* Setters */
    public function setProveedorId($proveedor_id){return $this->proveedor_id = $proveedor_id;}
    public function setFechaCompra($fecha_compra){return $this->fecha_compra = $fecha_compra;}
    public function setMontoConIva($monto_con_iva){return $this->monto_con_iva = $monto_con_iva;}
    public function setMontoSinnIva($monto_sin_iva){return $this->monto_sin_iva = $monto_sin_iva;}
    public function setMontoUsd($monto_usd){return $this->monto_usd = $monto_usd;}
    public function setTotalProductos($total_productos){return $this->total_productos = $total_productos;}
    public function setExcento($excento){return $this->excento = $excento;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>