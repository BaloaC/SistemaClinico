<?php

require_once 'GenericModel.php';

class MedicamentoModel extends GenericModel {

    protected $nombre_medicamento;
    protected $especialidad_id;
    protected $tipo_medicamento;
    protected $estatus_med;

    public function __construct($propiedades = null) {
        parent::__construct('medicamento', MedicamentoModel::class, $propiedades);
    }

    /* Getters */
    public function getNombreMedicamento(){return $this->nombre_medicamento;}
    public function getEspecialidadId(){return $this->especialidad_id;}
    public function getTipoMedicamento(){return $this->tipo_medicamento;}
    public function getEstatusMed(){return $this->estatus_med;}

    /* Setters */
    public function setNombreMedicamento($nombre_medicamento){return $this->nombre_medicamento = $nombre_medicamento;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
    public function setTipoMedicamento($tipo_medicamento){return $this->tipo_medicamento = $tipo_medicamento;}
    public function setEstatusMed($estatus_med){return $this->estatus_med = $estatus_med;}
}

?>