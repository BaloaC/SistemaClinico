<?php

require_once 'GenericModel.php';

class ExamenModel extends GenericModel {

    protected $nombre;
    protected $precio_examen;
    protected $tipo;
    protected $hecho_aqui;
    protected $estatus_exa;

    public function __construct($propiedades = null) {
        parent::__construct('examen', ExamenModel::class, $propiedades);
    }

    /* Getters */
    public function getNombre(){return $this->nombre;}
    public function getPrecioExamen(){return $this->precio_examen;}
    public function getEstatusExa(){return $this->estatus_exa;}
    public function getHechoAqui(){return $this->hecho_aqui;}

    /* Setters */
    public function setNombre($nombre){return $this->nombre =$nombre;}
    public function setPrecioExamen($precio_examen){return $this->precio_examen =$precio_examen;}
    public function setEstatusExa($estatus_exa){return $this->estatus_exa =$estatus_exa;}
    public function setHechoAqui($hecho_aqui){return $this->hecho_aqui =$hecho_aqui;}
}

?>