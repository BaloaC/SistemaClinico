<?php

require_once 'GenericModel.php';

class ConsultaExamenModel extends GenericModel {

    protected $consulta_id;
    protected $examen_id;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_examen', ConsultaExamenModel::class, $propiedades);
    }
	
    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getExamenId(){return $this->examen_id;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setExamenId($examen_id){return $this->examen_id = $examen_id;}
}

?>