<?php

require_once 'GenericModel.php';

class FacturaModel extends GenericModel {

    protected $consulta_id;
    protected $paciente_id;
    protected $medico_id;
    protected $monto_con_iva;
    protected $monto_sin_iva;
    protected $Iva;
    protected $autorizacion;
    protected $seguro_id;
    protected $fecha_ingreso;
    protected $fecha_egreso;
    protected $fecha_emitida;
    protected $fecha_enviada;
    protected $fecha_pago_limite;

    public function __construct($propiedades = null) {
        parent::__construct('factura', FacturaModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getMedico_id(){return $this->medico_id;}
    public function getMontoConIva(){return $this->monto_con_iva;}
    public function getMontoSinIva(){return $this->monto_sin_iva;}
    public function getIva(){return $this->Iva;}
    public function getAutorizacion(){return $this->autorizacion;}
    public function getseguroId(){return $this->seguro_id;}
    public function getFechaIngreso(){return $this->fecha_ingreso;}
    public function getFechaEgreso(){return $this->fecha_egreso;}
    public function getFechaEmitida(){return $this->fecha_emitida;}
    public function getFechaEnviada(){return $this->fecha_enviada;}
    public function getFechaPagoLimite(){return $this->fecha_pago_limite;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id = $paciente_id;}
    public function setMedico_id($medico_id){return $this->medico_id = $medico_id;}
    public function setMontoConIva($monto_con_iva){return $this->monto_con_iva = $monto_con_iva;}
    public function setMontoSinnIva($monto_sin_iva){return $this->monto_sin_iva = $monto_sin_iva;}
    public function setIva($Iva){return $this->Iva = $Iva;}
    public function setAutorizacion($autorizacion){return $this->autorizacion = $autorizacion;}
    public function setseguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setFechaIngreso($fecha_ingreso){return $this->fecha_ingreso = $fecha_ingreso;}
    public function setFechaEgreso($fecha_egreso){return $this->fecha_egreso = $fecha_egreso;}
    public function setFechaEmitida($fecha_emitida){return $this->fecha_emitida = $fecha_emitida;}
    public function setFechaEnviada($fecha_enviada){return $this->fecha_enviada = $fecha_enviada;}
    public function setFechaPagoLimite($fecha_pago_limite){return $this->fecha_pago_limite = $fecha_pago_limite;}
}

?>


	