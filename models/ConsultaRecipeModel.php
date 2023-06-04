<?php

require_once 'GenericModel.php';

class ConsultaRecipeModel extends GenericModel {

    protected $consulta_id;
    protected $medicamento_id;
    protected $uso;

    public function __construct($propiedades = null) {
        parent::__construct('consulta_recipe', ConsultaRecipeModel::class, $propiedades);
    }

    /* Getters */
    public function getConsultaId(){return $this->consulta_id;}
    public function getMedicamentoId(){return $this->medicamento_id;}
    public function getUso(){return $this->uso;}

    /* Setters */
    public function setConsultaId($consulta_id){return $this->consulta_id = $consulta_id;}
    public function setMedicamentoId($medicamento_id){return $this->medicamento_id = $medicamento_id;}
    public function setUso($uso){return $this->uso = $uso;}
}

?>