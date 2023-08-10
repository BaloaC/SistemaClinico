<?php

require_once 'GenericModel.php';

class ConsultaEmergenciaModel extends GenericModel {

    protected $consulta_id;
    protected $paciente_id;
    protected $paciente_beneficiado_id;
    protected $seguro_id;
    protected $consultas_medicas;
    protected $laboratorios;
    protected $medicamentos;
    protected $area_observacion;
    protected $enfermeria;
    protected $total_consulta;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_emergencia', ConsultaEmergenciaModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getPacienteId(){return $this->paciente_id;}
    public function getPacienteBeneficiadoId(){return $this->paciente_beneficiado_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getConsultasMedicas(){return $this->consultas_medicas;}
    public function getLaboratorios(){return $this->laboratorios;}
    public function getMedicamentos(){return $this->medicamentos;}
    public function getAreaObservacion(){return $this->area_observacion;}
    public function getEnfermeria(){return $this->enfermeria;}
    public function getTotalConsulta(){return $this->total_consulta;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id =$consulta_id;}
    public function setPacienteId($paciente_id){return $this->paciente_id =$paciente_id;}
    public function setPacienteBeneficiadoId($paciente_beneficiado_id){return $this->paciente_beneficiado_id =$paciente_beneficiado_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id =$seguro_id;}
    public function setConsultasMedicas($consultas_medicas){return $this->consultas_medicas =$consultas_medicas;}
    public function setLaboratorios($laboratorios){return $this->laboratorios =$laboratorios;}
    public function setMedicamentos($medicamentos){return $this->medicamentos =$medicamentos;}
    public function setAreaObservacion($area_observacion){return $this->area_observacion =$area_observacion;}
    public function setEnfermeria($enfermeria){return $this->enfermeria =$enfermeria;}
    public function setTotalConsulta($total_consulta){return $this->total_consulta =$total_consulta;}
}

?>