<?php

require_once 'GenericModel.php';

class FacturaConsultaModel extends GenericModel {

    protected $consulta_id;
    protected $paciente_id;
    protected $metodo_pago;
    // protected $monto_con_iva;
    protected $monto_consulta_bs;
    protected $monto_consulta_usd;
    protected $estatus_fac;

    public function __construct($propiedades = null) {
        parent::__construct('factura_consulta', FacturaConsultaModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getMetodoPago(){return $this->metodo_pago;}
    // public function getMontoConIva(){return $this->monto_con_iva;}
    public function getMontoConsultaBs(){return $this->monto_consulta_bs;}
    public function getMontoConsultaUsd(){return $this->monto_consulta_usd;}
    public function getEstatusFac(){return $this->estatus_fac;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setMetodoPago($metodo_pago){return $this->metodo_pago = $metodo_pago;}
    // public function setMontoConIva($monto_con_iva){return $this->monto_con_iva = $monto_con_iva;}
    public function setMontoConsultaBs($monto_consulta_bs){return $this->monto_consulta_bs = $monto_consulta_bs;}
    public function setMontoConsultaUsd($monto_consulta_usd){return $this->monto_consulta_usd = $monto_consulta_usd;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>