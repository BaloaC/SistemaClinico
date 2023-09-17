<?php

require_once 'GenericModel.php';

class FacturaMensajeriaModel extends GenericModel {

    protected $seguro_id;
    protected $fecha_mensajeria;
    protected $total_mensajeria_usd;
    protected $total_mensajeria_bs;
    
    public function __construct($propiedades = null) {
        parent::__construct('factura_mensajeria', FacturaMensajeriaModel::class, $propiedades);
    }

    /* Getters */
    public function getSeguroId(){return $this->seguro_id;}
    public function getFechaMensajeria(){return $this->fecha_mensajeria;}
    public function getTotalMensajeriaUsd(){return $this->total_mensajeria_usd;}
    public function getTotalMensajeriaBs(){return $this->total_mensajeria_bs;}

    /* Setters */
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setFechaMensajeria($fecha_mensajeria){return $this->fecha_mensajeria = $fecha_mensajeria;}
    public function setTotalMensajeriaUsd($total_mensajeria_usd){return $this->total_mensajeria_usd = $total_mensajeria_usd;}
    public function setTotalMensajeriaBs($total_mensajeria_bs){return $this->total_mensajeria_bs = $total_mensajeria_bs;}
}

?>