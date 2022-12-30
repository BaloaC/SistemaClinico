<?php

require_once 'GenericModel.php';

class PacienteModel extends GenericModel {

    protected $cedula;
    protected $nombres;
    protected $apellidos;
    protected $fecha_nacimiento;
    protected $edad;
    protected $telefono;
    protected $direccion;
    protected $tipo_paciente;
    protected $estatus_pac;

    public function __construct($propiedades = null) {
        parent::__construct('paciente', PacienteModel::class, $propiedades);
    }

    /* Getters */
    public function getCedula(){return $this->cedula;}
    public function getNombres(){return $this->nombres;}
    public function getApellidos(){return $this->apellidos;}
    public function getFechaNacimiento(){return $this->fecha_nacimiento;}
    public function getEdad(){return $this->edad;}
    public function getTelefono(){return $this->telefono;}
    public function getDireccion(){return $this->direccion;}
    public function getTipoPaciente(){return $this->tipo_paciente;}
    public function getEstatusPac(){return $this->estatus_pac;}

    /* Setters */
    public function setCedula($cedula){return $this->cedula = $cedula;}
    public function setNombres($nombres){return $this->nombres = $nombres;}
    public function setApellidos($apellidos){return $this->apellidos = $apellidos;}
    public function setFechaNacimiento($fecha_nacimiento){return $this->fecha_nacimiento = $fecha_nacimiento;}
    public function setEdad($edad){return $this->edad = $edad;}
    public function setTelefono($telefono){return $this->telefono = $telefono;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setTipoPaciente($tipo_paciente){return $this->tipo_paciente = $tipo_paciente;}
    public function setEstatusPac($estatus_pac){return $this->estatus_pac = $estatus_pac;}
}

?>