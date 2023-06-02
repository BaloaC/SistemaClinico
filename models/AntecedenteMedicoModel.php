<?php

require_once 'GenericModel.php';

class AntecedenteMedicoModel extends GenericModel {

    protected $paciente_id;
    protected $tipo_antecedente_id;
    protected $descripcion;
    protected $estatus_ant;

    public function __construct($propiedades = null) {
        parent::__construct('antecedentes_medicos', AntecedenteMedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId (){return $this->paciente_id ;}
    public function getTipoAntecedenteId (){return $this->tipo_antecedente_id ;}
    public function getDescripcion(){return $this->descripcion;}
    public function getEstatusAnt(){return $this->estatus_ant;}

    /* Setters */
    public function setPacienteId ($paciente_id ){return $this->paciente_id  =$paciente_id ;}
    public function setTipoAntecedenteId ($tipo_antecedente_id ){return $this->tipo_antecedente_id  =$tipo_antecedente_id ;}
    public function setDescripcion($descripcion){return $this->descripcion =$descripcion;}
    public function setEstatusAnt($estatus_ant){return $this->estatus_ant =$estatus_ant;}
}

?>