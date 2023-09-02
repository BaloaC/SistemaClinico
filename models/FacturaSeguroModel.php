<?php

require_once 'GenericModel.php';

class FacturaSeguroModel extends GenericModel {

    protected $factura_seguro_id;
    protected $seguro_id;
    protected $mes;
    protected $monto_usd;
    protected $monto_bs;
    protected $fecha_ocurrencia;
    protected $fecha_vencimiento;
    protected $estatus_fac;

    public function __construct($propiedades = null) {
        parent::__construct('factura_seguro', FacturaSeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->factura_seguro_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getTipoServicio(){return $this->mes;}
    public function getMontoUsd(){return $this->monto_usd;}
    public function getMontoBs(){return $this->monto_bs;}
    public function getFechaOcurrencia(){return $this->fecha_ocurrencia;}
    public function getFechaPagoLimite(){return $this->fecha_vencimiento;}
    public function getEstatusFac(){return $this->estatus_fac;}

    /* Setters */
    public function setConsultaId($factura_seguro_id){return $this->factura_seguro_id = $factura_seguro_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setTipoServicioa($mes){return $this->mes = $mes;}
    public function setMontoUsd($monto_usd){return $this->monto_usd = $monto_usd;}
    public function setMontoBs($monto_bs){return $this->monto_bs = $monto_bs;}
    public function setFechaOcurrencia($fecha_ocurrencia){return $this->fecha_ocurrencia = $fecha_ocurrencia;}
    public function setFechaPagoLimite($fecha_vencimiento){return $this->fecha_vencimiento = $fecha_vencimiento;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>