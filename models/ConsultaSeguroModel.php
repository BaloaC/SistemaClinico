<?php

require_once 'GenericModel.php';

class ConsultaSeguroModel extends GenericModel {

    protected $consulta_id;
    protected $seguro_id;
    protected $fecha_ocurrencia;
    protected $monto_consulta_usd;
    protected $monto_consulta_bs;
    protected $tipo_servicio;
    protected $estatus_con;
    protected $nombre_especialidad;
    protected $cobertura_seguro;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_seguro', ConsultaSeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getFechaOcurrencia(){return $this->fecha_ocurrencia;}
    public function getmontoConsultaUsd(){return $this->monto_consulta_usd;}
    public function getmontoConsultaBs(){return $this->monto_consulta_bs;}
    public function getTipoServicio(){return $this->tipo_servicio;}
    public function getEstatusCon(){return $this->estatus_con;}
    public function getClave(){return $this->clave;}
    public function getNombreEspecialidad(){return $this->nombre_especialidad;}
    public function getCoberturaSeguro(){return $this->cobertura_seguro;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setFechaOcurrencia($fecha_ocurrencia){return $this->fecha_ocurrencia = $fecha_ocurrencia;}
    public function setmontoConsultaUsd($monto_consulta_usd){return $this->monto_consulta_usd = $monto_consulta_usd;}
    public function setmontoConsultaBs($monto_consulta_bs){return $this->monto_consulta_bs = $monto_consulta_bs;}
    public function setTipoServicioa($tipo_servicio){return $this->tipo_servicio = $tipo_servicio;}
    public function setEstatusCon($estatus_con){return $this->estatus_con = $estatus_con;}
    public function setClave($clave){return $this->clave = $clave;}
    public function setNombreEspecialidad($nombre_especialidad){return $this->nombre_especialidad = $nombre_especialidad;}
    public function setCoberturaSeguro($cobertura_seguro){return $this->cobertura_seguro = $cobertura_seguro;}
}

?>