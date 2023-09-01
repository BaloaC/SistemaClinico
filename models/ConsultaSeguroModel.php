<?php

require_once 'GenericModel.php';

class ConsultaSeguroModel extends GenericModel {

    protected $consulta_id;
    protected $seguro_id;
    protected $fecha_ocurrencia;
    // protected $fecha_pago_limite;
    protected $monto_consulta;
    protected $tipo_servicio;
    protected $estatus_con;
    protected $nombre_especialidad;
    // protected $nombre_paciente;
    // protected $nombre_titular;
    // protected $clave;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_seguro', ConsultaSeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getFechaOcurrencia(){return $this->fecha_ocurrencia;}
    // public function getFechaPagoLimite(){return $this->fecha_pago_limite;}
    public function getmontoConsulta(){return $this->monto_consulta;}
    public function getTipoServicio(){return $this->tipo_servicio;}
    public function getEstatusCon(){return $this->estatus_con;}
    public function getClave(){return $this->clave;}
    public function getNombreEspecialidad(){return $this->nombre_especialidad;}
    // public function getNombrePaciente(){return $this->nombre_paciente;}
    // public function getNombreTitular(){return $this->nombre_titular;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setFechaOcurrencia($fecha_ocurrencia){return $this->fecha_ocurrencia = $fecha_ocurrencia;}
    // public function setFechaPagoLimite($fecha_pago_limite){return $this->fecha_pago_limite = $fecha_pago_limite;}
    public function setmontoConsulta($monto_consulta){return $this->monto_consulta = $monto_consulta;}
    public function setTipoServicioa($tipo_servicio){return $this->tipo_servicio = $tipo_servicio;}
    public function setEstatusCon($estatus_con){return $this->estatus_con = $estatus_con;}
    public function setClave($clave){return $this->clave = $clave;}
    public function setNombreEspecialidad($nombre_especialidad){return $this->nombre_especialidad = $nombre_especialidad;}
    // public function setNombrePaciente($nombre_paciente){return $this->nombre_paciente = $nombre_paciente;}
    // public function setNombreTitular($nombre_titular){return $this->nombre_titular = $nombre_titular;}
}

?>