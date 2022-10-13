<?php

require_once 'GenericModel.php';

class MedicoModel extends GenericModel {

    protected $cedula;
    protected $nombres;
    protected $apellidos;
    protected $telefono;
    protected $direccion;
    protected $especialidad_id;

    public function __construct($propiedades = null) {
        parent::__construct('medico', MedicoModel::class, $propiedades);
    }

    /* Getters */
    public function getCedula(){return $this->cedula;}
    public function getNombres(){return $this->nombres;}
    public function getApellidos(){return $this->apellidos;}
    public function getTelefono(){return $this->telefono;}
    public function getDireccion(){return $this->direccion;}
    public function getEspecialidadId(){return $this->especialidad_id;}

    /* Setters */
    public function setCedula($cedula){return $this->cedula = $cedula;}
    public function setNombres($nombres){return $this->nombres = $nombres;}
    public function setApellidos($apellidos){return $this->apellidos = $apellidos;}
    public function setTelefono($telefono){return $this->telefono = $telefono;}
    public function setDireccion($direccion){return $this->direccion = $direccion;}
    public function setEspecialidadId($especialidad_id){return $this->especialidad_id = $especialidad_id;}
}

?>