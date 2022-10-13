<?php

require_once 'GenericModel.php';

class ConsultaModel extends GenericModel {

    protected $paciente_id;
    protected $medico_id;
    protected $peso;
    protected $altura;
    protected $observaciones;
    protected $fecha_consulta;

    public function __construct($propiedades = null) {
        parent::__construct('consulta', ConsultaModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId(){return $this->paciente_id;}
    public function getMedicoId(){return $this->medico_id;}
    public function getPeso(){return $this->peso;}
    public function getAltura(){return $this->altura;}
    public function getObservaciones(){return $this->observaciones;}
    public function getFechaConsulta(){return $this->fecha_consulta;}

    /* Setters */
    public function setPacienteId($paciente_id){return $this->paciente_id =$paciente_id;}
    public function setMedicoId($medico_id){return $this->medico_id =$medico_id;}
    public function setPeso($peso){return $this->peso =$peso;}
    public function setAltura($altura){return $this->altura =$altura;}
    public function setObservaciones($observaciones){return $this->observaciones =$observaciones;}
    public function setFechaConsulta($fecha_consulta){return $this->fecha_consulta =$fecha_consulta;}
}

?>