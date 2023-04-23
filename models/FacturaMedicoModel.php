<?php

require_once 'GenericModel.php';

class FacturaMedicoModel extends GenericModel {

    protected $medico_id;
    protected $fecha_pago;
    protected $acumulado_seguro_total;
    protected $acumulado_consulta_total;
    protected $pago_total;
    protected $pacientes_seguro;
    protected $pacientes_consulta;
    protected $estatus_fac;

    public function __construct($propiedades = null) {
        parent::__construct('factura_medico', FacturaMedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getMedicoId(){return $this->medico_id;}
    public function getFechaPago(){return $this->fecha_pago;}
    public function getAcumuladoSeguro(){return $this->acumulado_seguro;}
    public function getAcumuladoConsulta(){return $this->acumulado_consulta;}
    public function getTotalProductos(){return $this->monto_total;}
    public function getPacientesSeguro(){return $this->pacientes_seguro;}
    public function getPacientesConsulta(){return $this->pacientes_consulta;}
    public function getEstatusFac(){return $this->estatus_fac;} 

    /* Setters */
    public function setMedicoId($medico_id){return $this->medico_id = $medico_id;}
    public function setFechaPago($fecha_pago){return $this->fecha_pago = $fecha_pago;}
    public function setAcumuladoSeguro($acumulado_seguro){return $this->acumulado_seguro = $acumulado_seguro;}
    public function setAcumuladoConsulta($acumulado_consulta){return $this->acumulado_consulta = $acumulado_consulta;}
    public function setTotalProductos($monto_total){return $this->monto_total = $monto_total;}
    public function setPacientesSeguro($pacientes_seguro){return $this->pacientes_seguro = $pacientes_seguro;}
    public function setPacientesConsulta($pacientes_consulta){return $this->pacientes_consulta = $pacientes_consulta;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>