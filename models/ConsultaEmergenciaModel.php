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
    protected $total_insumos;
    protected $total_consulta;

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
    public function getTotalInsumos(){return $this->total_insumos;}
    public function getTotalConsulta(){return $this->total_consulta;}

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
    public function setTotalInsumos($total_insumos){return $this->total_insumos =$total_insumos;}
    public function setTotalConsulta($total_consulta){return $this->total_consulta =$total_consulta;}
}

?>