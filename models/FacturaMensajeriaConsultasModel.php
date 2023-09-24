<?php

require_once 'GenericModel.php';

class FacturaMensajeriaConsultasModel extends GenericModel {

    protected $consulta_seguro_id;
    protected $factura_mensajeria_id;
    protected $fecha_mensajeria_consultas;
    
    public function __construct($propiedades = null) {
        parent::__construct('factura_mensajeria_consultas', FacturaMensajeriaConsultasModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaSeguroId(){return $this->consulta_seguro_id;}
    public function getFacturaMensajeriaId(){return $this->factura_mensajeria_id;}
    public function getFechaMensajeriaConsultas(){return $this->fecha_mensajeria_consultas;}

    /* Setters */
    public function setConsultaSeguroId($consulta_seguro_id){return $this->consulta_seguro_id = $consulta_seguro_id;}
    public function setFacturaMensajeriaId($factura_mensajeria_id){return $this->factura_mensajeria_id = $factura_mensajeria_id;}
    public function setFechaMensajeriaConsultas($fecha_mensajeria_consultas){return $this->fecha_mensajeria_consultas = $fecha_mensajeria_consultas;}
}

?>