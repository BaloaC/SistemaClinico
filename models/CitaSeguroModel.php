<?php

require_once 'GenericModel.php';

class CitaSeguroModel extends GenericModel {

    protected $cita_id;
    protected $seguro_id;
    protected $clave;
    // protected $estatus_cit;

    public function __construct($propiedades = null) {
        parent::__construct('cita_seguro', CitaSeguroModel::class, $propiedades);
    }

    /* Getters */
    public function getCitaId(){return $this->cita_id;}
    public function getSeguroId(){return $this->seguro_id;}
    public function getClave(){return $this->clave;}
    // public function getEstatusCit(){return $this->estatus_cit;}

    /* Setters */
    public function setCitaId($cita_id){return $this->cita_id = $cita_id;}
    public function setSeguroId($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setClave($clave){return $this->clave = $clave;}
    // public function setEstatusCit($estatus_cit){return $this->estatus_cit = $estatus_cit;}
}

?>