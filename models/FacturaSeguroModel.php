<?php

require_once 'GenericModel.php';

class FacturaSeguroModel extends GenericModel {

    protected $factura_seguro_id;
    protected $seguro_id;
    protected $mes;
    protected $monto;
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
    public function getMonto(){return $this->monto;}
    public function getFechaOcurrencia(){return $this->fecha_ocurrencia;}
    public function getFechaPagoLimite(){return $this->fecha_vencimiento;}
    public function getEstatusFac(){return $this->estatus_fac;}

    /* Setters */
    public function setConsultaId($factura_seguro_id){return $this->factura_seguro_id = $factura_seguro_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setTipoServicioa($mes){return $this->mes = $mes;}
    public function setMonto($monto){return $this->monto = $monto;}
    public function setFechaOcurrencia($fecha_ocurrencia){return $this->fecha_ocurrencia = $fecha_ocurrencia;}
    public function setFechaPagoLimite($fecha_vencimiento){return $this->fecha_vencimiento = $fecha_vencimiento;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>