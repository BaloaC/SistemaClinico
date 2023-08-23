<?php

require_once 'GenericModel.php';

class GlobalModel extends GenericModel {

    protected $key;
    protected $value;

    public function __construct($propiedades = null) {
        parent::__construct('global', GlobalModel::class, $propiedades);
    }

    /* Getters */
    public function getKey(){return $this->key;}
    public function getValue(){return $this->value;}

    /* Setters */
    public function setKey($key){return $this->key = $key;}
    public function setValue($value){return $this->value = $value;}
}

?>