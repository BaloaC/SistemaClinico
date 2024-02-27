<?php

require_once 'GenericModel.php';

class FacturaMedicoModel extends GenericModel {

    protected $medico_id;
    protected $fecha_pago;
    protected $acumulado_seguro_total;
    protected $acumulado_consulta_total;
    protected $sumatoria_consultas_aseguradas;
    protected $sumatoria_consultas_naturales;
    protected $acumulado_medico;
    protected $pago_total;
    protected $pacientes_seguro;
    protected $pacientes_consulta;
    protected $precio_dolar;
    protected $estatus_fac;

    public function __construct($propiedades = null) {
        parent::__construct('factura_medico', FacturaMedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getMedicoId(){return $this->medico_id;}
    public function getFechaPago(){return $this->fecha_pago;}
    public function getAcumuladoSeguro(){return $this->acumulado_seguro;}
    public function getAcumuladoConsulta(){return $this->acumulado_consulta;}
    public function getSumatoriaConsultasAseguradas(){return $this->sumatoria_consultas_aseguradas;}
    public function getSumatoriaConsultasNaturales(){return $this->sumatoria_consultas_naturales;}
    public function getAcumuladoMedico(){return $this->acumulado_medico;}
    public function getPagoTotal(){return $this->pago_total;}
    public function getPacientesSeguro(){return $this->pacientes_seguro;}
    public function getPacientesConsulta(){return $this->pacientes_consulta;}
    public function getPrecioDolar(){return $this->precio_dolar;}
    public function getEstatusFac(){return $this->estatus_fac;} 

    /* Setters */
    public function setMedicoId($medico_id){return $this->medico_id = $medico_id;}
    public function setFechaPago($fecha_pago){return $this->fecha_pago = $fecha_pago;}
    public function setAcumuladoSeguro($acumulado_seguro){return $this->acumulado_seguro = $acumulado_seguro;}
    public function setAcumuladoConsulta($acumulado_consulta){return $this->acumulado_consulta = $acumulado_consulta;}
    public function setSumatoriaConsultasAseguradas($sumatoria_consultas_aseguradas){return $this->sumatoria_consultas_aseguradas = $sumatoria_consultas_aseguradas;}
    public function setSumatoriaConsultasNaturales($sumatoria_consultas_naturales){return $this->sumatoria_consultas_naturales = $sumatoria_consultas_naturales;}
    public function setAcumuladoMedico($acumulado_medico){return $this->acumulado_medico = $acumulado_medico;}
    public function setPagoTotal($pago_total){return $this->pago_total = $pago_total;}
    public function setPacientesSeguro($pacientes_seguro){return $this->pacientes_seguro = $pacientes_seguro;}
    public function setPacientesConsulta($pacientes_consulta){return $this->pacientes_consulta = $pacientes_consulta;}
    public function setPrecioDolar($precio_dolar){return $this->precio_dolar = $precio_dolar;}
    public function setEstatusFac($estatus_fac){return $this->estatus_fac = $estatus_fac;}
}

?>