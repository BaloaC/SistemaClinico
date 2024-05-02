<?php

require_once 'GenericModel.php';

class ConsultaModel extends GenericModel {

    protected $cita_id;
    protected $peso;
    protected $altura;
    protected $observaciones;
    protected $fecha_consulta;
    protected $es_emergencia;
    protected $tipo_servicio;
    protected $estatus_con;

    public function __construct($propiedades = null) {
        parent::__construct('consulta', ConsultaModel::class, $propiedades);
    }

    /* Getters */
    public function getCitaId(){return $this->cita_id;}
    public function getPeso(){return $this->peso;}
    public function getAltura(){return $this->altura;}
    public function getObservaciones(){return $this->observaciones;}
    public function getFechaConsulta(){return $this->fecha_consulta;}
    public function getEsEmergencia(){return $this->es_emergencia;}
    public function getTipoServicio(){return $this->tipo_servicio;}
    public function getEstatusCon(){return $this->estatus_con;}

    /* Setters */
    public function setCitaId($cita_id){return $this->cita_id =$cita_id;}
    public function setPeso($peso){return $this->peso =$peso;}
    public function setAltura($altura){return $this->altura =$altura;}
    public function setObservaciones($observaciones){return $this->observaciones =$observaciones;}
    public function setFechaConsulta($fecha_consulta){return $this->fecha_consulta =$fecha_consulta;}
    public function setEsEmergencia($es_emergencia){return $this->es_emergencia =$es_emergencia;}
    public function setTipoServicio($tipo_servicio){return $this->tipo_servicio =$tipo_servicio;}
    public function setEstatusCon($estatus_con){return $this->estatus_con =$estatus_con;}
}

?>