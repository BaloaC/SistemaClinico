<?php

require_once 'GenericModel.php';

class ConsultaSinCitaModel extends GenericModel {

    protected $consulta_id;
    protected $paciente_id;
    protected $medico_id;
    protected $especialidad_id;
    protected $estatus_con;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_sin_cita', ConsultaSinCitaModel::class, $propiedades);
    }

    
    public function getConsultaId(){return $this->consulta_id;}/* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getMedicoId(){return $this->medico_id;}
    public function getEspecialidadId(){return $this->especialidad_id;}
    public function getEstatusCon(){return $this->estatus_con;}

    
    public function setConsultaId($consulta_id){return $this->consulta_id =$consulta_id;}/* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id =$paciente_id;}
    public function setMedicoId($medico_id){return $this->medico_id =$medico_id;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id =$especialidad_id;}
    public function setEstatusCon($estatus_con){return $this->estatus_con =$estatus_con;}
}

?>