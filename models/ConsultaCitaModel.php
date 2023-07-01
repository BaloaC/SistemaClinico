<?php

require_once 'GenericModel.php';

class ConsultaCitaModel extends GenericModel {

    protected $consulta_id;
    protected $cita_id;
    protected $estatus_con;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_cita', ConsultaCitaModel::class, $propiedades);
    }

    /* Getters */
    public function getEspecialidadId(){return $this->consulta_id;}
    public function getCitaId(){return $this->cita_id;}
    public function getEstatusCon(){return $this->estatus_con;}

    /* Setters */
    public function setEspecialidadId($consulta_id){return $this->consulta_id =$consulta_id;}
    public function setCitaId($cita_id){return $this->cita_id =$cita_id;}
    public function setEstatusCon($estatus_con){return $this->estatus_con =$estatus_con;}
}

?>