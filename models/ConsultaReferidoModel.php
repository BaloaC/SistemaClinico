<?php

require_once 'GenericModel.php';

class ConsultaReferidoModel extends GenericModel {

    protected $consulta_id;
    protected $especialidad_id;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_referidos', ConsultaReferidoModel::class, $propiedades);
    }
	
    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getEspecialidadId(){return $this->especialidad_id;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
}

?>