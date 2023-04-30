<?php

require_once 'GenericModel.php';

class HorarioModel extends GenericModel {

    protected $medico_id;
    protected $dias_semana;
    protected $hora_entrada;
    protected $hora_salida;
    protected $estatus_hor;

    public function __construct($propiedades = null) {
        parent::__construct('horario', HorarioModel::class, $propiedades);
    }

    /* Getters */
    public function getMedico_id(){return $this->medico_id;}
    public function getDiasSemana(){return $this->dias_semana;}
    public function getHoraEntrada(){return $this->hora_entrada;}
    public function getHoraSalida(){return $this->hora_salida;}
    public function getEstatusHor(){return $this->estatus_hor;}

    /* Setters */
    public function setMedico_id($medico_id){return $this->medico_id = $medico_id;}
    public function setDiasSemana($dias_semana){return $this->dias_semana = $dias_semana;}
    public function setHoraEntrada($hora_entrada){return $this->hora_entrada = $hora_entrada;}
    public function setHoraSalida($hora_salida){return $this->hora_salida = $hora_salida;}
    public function setEstatusHor($estatus_hor){return $this->estatus_hor = $estatus_hor;}
}

?>