<?php

require_once 'GenericModel.php';

class SeguroExamenModel extends GenericModel {

    protected $seguro_id;
    protected $examenes;
    protected $costos;
    protected $estatus_seg;

    public function __construct($propiedades = null) {
        parent::__construct('seguro_examen', SeguroExamenModel::class, $propiedades);
    }

    /* Getters */
    public function getSeguroId(){return $this->seguro_id;}
    public function getExamenes(){return $this->examenes;}
    public function getCostos(){return $this->costos;}
    public function getEstatusSeg(){return $this->estatus_seg;}

    /* Setters */
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setExamenes($examenes){return $this->examenes = $examenes;}
    public function setCostos($costos){return $this->costos = $costos;}
    public function setEstatusSeg($estatus_seg){return $this->estatus_seg = $estatus_seg;}
}

?>