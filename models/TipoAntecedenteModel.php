<?php

require_once 'GenericModel.php';

class TipoAntecedenteModel extends GenericModel {

    protected $nombre;

    public function __construct($propiedades = null) {
        parent::__construct('antecedentes_medicos', AntecedenteMedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getPacienteId (){return $this->nombre;}

    /* Setters */
    public function setPacienteId ($nombre ){return $this->nombre = $nombre;}
}

?>