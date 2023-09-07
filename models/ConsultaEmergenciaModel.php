<?php

require_once 'GenericModel.php';

class ConsultaEmergenciaModel extends GenericModel {

    protected $consulta_id;
    protected $paciente_id;
    protected $cedula_beneficiado;
    protected $seguro_id;
    protected $cantidad_consultas_medicas;
    protected $consultas_medicas;
    protected $cantidad_laboratorios;
    protected $laboratorios;
    protected $cantidad_medicamentos;
    protected $medicamentos;
    protected $area_observacion;
    protected $enfermeria;
    protected $total_examenes;
    protected $total_examenes_bs;
    protected $total_insumos;
    protected $total_consulta;
    protected $consultas_medicas_bs;
    protected $laboratorios_bs;
    protected $medicamentos_bs;
    protected $area_observacion_bs;
    protected $enfermeria_bs;
    protected $total_insumos_bs;
    protected $total_consulta_bs;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_emergencia', ConsultaEmergenciaModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getCedulaBeneficiado(){return $this->cedula_beneficiado;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getCantidadConsultasMedicas(){return $this->cantidad_consultas_medicas;}
    public function getConsultasMedicas(){return $this->consultas_medicas;}
    public function getCantidadLaboratorios(){return $this->cantidad_laboratorios;}
    public function getLaboratorios(){return $this->laboratorios;}
    public function getCantidadMedicamentos(){return $this->cantidad_medicamentos;}
    public function getMedicamentos(){return $this->medicamentos;}
    public function getAreaObservacion(){return $this->area_observacion;}
    public function getEnfermeria(){return $this->enfermeria;}
    public function getTotalExamenes(){return $this->total_examenes;}
    public function getTotalExamenesBs(){return $this->total_examenes_bs;}
    public function getTotalInsumos(){return $this->total_insumos;}
    public function getTotalConsulta(){return $this->total_consulta;}
    public function getConsultasMedicasBs(){return $this->consultas_medicas_bs;}
    public function getLaboratoriosBs(){return $this->laboratorios_bs;}
    public function getMedicamentosBs(){return $this->medicamentos_bs;}
    public function getareaObservacionBs(){return $this->area_observacion_bs;}
    public function getenfermeriaBs(){return $this->enfermeria_bs;}
    public function getTotalInsumosBs(){return $this->total_insumos_bs;}
    public function getTotalConsultaBs(){return $this->total_consulta_bs;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id =$consulta_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id =$paciente_id;}
    public function setCedulaBeneficiado($cedula_beneficiado){return $this->cedula_beneficiado =$cedula_beneficiado;}
    public function setSeguroId($seguro_id){return $this->seguro_id =$seguro_id;}
    public function setCantidadConsultasMedicas($cantidad_consultas_medicas){return $this->$cantidad_consultas_medicas =$cantidad_consultas_medicas;}
    public function setConsultasMedicas($consultas_medicas){return $this->consultas_medicas =$consultas_medicas;}
    public function setCantidadLaboratorios($cantidad_laboratorios){return $this->cantidad_laboratorios =$cantidad_laboratorios;}
    public function setLaboratorios($laboratorios){return $this->laboratorios =$laboratorios;}
    public function setCantidadMedicamentos($cantidad_medicamentos){return $this->cantidad_medicamentos =$cantidad_medicamentos;}
    public function setMedicamentos($medicamentos){return $this->medicamentos =$medicamentos;}
    public function setAreaObservacion($area_observacion){return $this->area_observacion =$area_observacion;}
    public function setEnfermeria($enfermeria){return $this->enfermeria =$enfermeria;}
    public function setTotalExamenes($total_examenes){return $this->total_examenes =$total_examenes;}
    public function setTotalExamenesBs($total_examenes_bs){return $this->total_examenes_bs =$total_examenes_bs;}
    public function setTotalInsumos($total_insumos){return $this->total_insumos =$total_insumos;}
    public function setTotalConsulta($total_consulta){return $this->total_consulta =$total_consulta;}
    public function setConsultasMedicasBs($consultas_medicas_bs){return $this->consultas_medicas_bs = $consultas_medicas_bs;}
    public function setLaboratoriosBs($laboratorios_bs){return $this->laboratorios_bs = $laboratorios_bs;}
    public function setMedicamentosBs($medicamentos_bs){return $this->medicamentos_bs = $medicamentos_bs;}
    public function setareaObservacionBs($area_observacion_bs){return $this->area_observacion_bs = $area_observacion_bs;}
    public function setenfermeriaBs($enfermeria_bs){return $this->enfermeria_bs = $enfermeria_bs;}
    public function setTotalInsumosBs($total_insumos_bs){return $this->total_insumos_bs = $total_insumos_bs;}
    public function setTotalConsultaBs($total_consulta_bs){return $this->total_consulta_bs = $total_consulta_bs;}
}

?>