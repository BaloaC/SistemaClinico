<?php

require_once 'GenericModel.php';

class MedicoModel extends GenericModel {

    protected $cedula;
    protected $nombre;
    protected $apellidos;
    protected $telefono;
    protected $direccion;
    protected $especialidad_id;
    protected $estatus_med;

    public function __construct($propiedades = null) {
        parent::__construct('medico', MedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getCedula(){return $this->cedula;}
    public function getNombre(){return $this->nombre;}
    public function getApellidos(){return $this->apellidos;}
    public function getTelefono(){return $this->telefono;}
    public function getDireccion(){return $this->direccion;}
    public function getEspecialidadId(){return $this->especialidad_id;}
    public function getEstatusMed(){return $this->estatus_med;}

    /* Setters */
    public function setCedula($cedula){return $this->cedula = $cedula;}
    public function setNombres($nombre){return $this->nombre = $nombre;}
    public function setApellidos($apellidos){return $this->apellidos = $apellidos;}
    public function setTelefono($telefono){return $this->telefono = $telefono;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
    public function setEstatusMed($estatus_med){return $this->estatus_med = $estatus_med;}
}

?>