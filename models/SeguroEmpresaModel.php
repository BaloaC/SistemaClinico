<?php

require_once 'GenericModel.php';

class SeguroEmpresaModel extends GenericModel {

    protected $seguro_id;
    protected $empresa_id;

    public function __construct($propiedades = null) {
        parent::__construct('seguro_empresa', SeguroEmpresaModel::class, $propiedades);
    }

    /* Getters */
    public function getSeguro_id(){return $this->seguro_id;}
    public function getEmpresa_id(){return $this->empresa_id;}
    
    /* Setters */
    public function setSeguro_id($seguro_id){return $this->seguro_id = $seguro_id;}
    public function setEmpresa_id($empresa_id){return $this->empresa_id = $empresa_id;}
}

?>