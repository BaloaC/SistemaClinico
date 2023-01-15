<?php

require_once 'GenericModel.php';

class SeguroEmpresaModel extends GenericModel {

    protected $seguro_id;
    protected $empresa_id;
    protected $estatus_seg;

    public function __construct($propiedades = null) {
        parent::__construct('seguro_empresa', SeguroEmpresaModel::class, $propiedades);
    }

    /* Getters */
    public function getSeguro_id(){return $this->seguro_id;}
    public function getEmpresa_id(){return $this->empresa_id;}
    public function getEstatusSeguro(){return $this->estatus_seg;}
    
    /* Setters */
    public function setSeguro_id($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setEmpresa_id($empresa_id){return $this->empresa_id = $empresa_id;}
    public function setEstatusSeguro($estatus_seg){return $this->estatus_seg = $estatus_seg;}
}

?>