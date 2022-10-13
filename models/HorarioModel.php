<?php

require_once 'GenericModel.php';

class HorarioModel extends GenericModel {

    protected $medico_id;
    protected $dias_semana_id;
    protected $hora_entrada;
    protected $hora_salida;
    protected $fecha_Horario;

    public function __construct($propiedades = null) {
        parent::__construct('horario', HorarioModel::class, $propiedades);
    }

    /* Getters */
    public function getMedico_id(){return $this->medico_id;}
    public function getDiasSemanaId(){return $this->dias_semana_id;}
    public function getHoraEntrada(){return $this->hora_entrada;}
    public function getHoraSalida(){return $this->hora_salida;}

    /* Setters */
    public function setMedico_id($medico_id){return $this->medico_id = $medico_id;}
    public function setDiasSemanaId($dias_semana_id){return $this->dias_semana_id = $dias_semana_id;}
    public function setHoraEntrada($hora_entrada){return $this->hora_entrada = $hora_entrada;}
    public function setHoraSalida($hora_salida){return $this->hora_salida = $hora_salida;}
}

?>