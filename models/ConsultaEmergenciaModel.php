<?php

require_once 'GenericModel.php';

class ConsultaEmergenciaModel extends GenericModel {

    protected $paciente_id;
    protected $seguro_id;
    protected $consultas_medicas;
    protected $laboratorios;
    protected $medicamentos;
    protected $area_observacion;
    protected $enfermeria;
    protected $fecha_consulta;
    protected $estatus_con;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_emergencia', ConsultaEmergenciaModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getConsultasMedicas(){return $this->consultas_medicas;}
    public function getLaboratorios(){return $this->laboratorios;}
    public function getMedicamentos(){return $this->medicamentos;}
    public function getAreaObservacion(){return $this->area_observacion;}
    public function getEnfermeria(){return $this->enfermeria;}
    public function getFechaConsulta(){return $this->fecha_consulta;}
    public function getEstatusCon(){return $this->estatus_con;}

    /* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id =$paciente_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id =$seguro_id;}
    public function setConsultasMedicas($consultas_medicas){return $this->consultas_medicas =$consultas_medicas;}
    public function setLaboratorios($laboratorios){return $this->laboratorios =$laboratorios;}
    public function setMedicamentos($medicamentos){return $this->medicamentos =$medicamentos;}
    public function setAreaObservacion($area_observacion){return $this->area_observacion =$area_observacion;}
    public function setEnfermeria($enfermeria){return $this->enfermeria =$enfermeria;}
    public function setFechaConsulta($fecha_consulta){return $this->fecha_consulta =$fecha_consulta;}
    public function setEstatusCon($estatus_con){return $this->estatus_con =$estatus_con;}
}

?>