<?php

require_once 'GenericModel.php';

class InsumoModel extends GenericModel {

    protected $nombre;
    protected $cantidad_min;
    
    protected $cantidad_unidad;
    protected $capacidad_unidad;
    protected $cantidad_capacidad;
    protected $es_cobrado;
    protected $tipo_medida;
    protected $tipo_insumo;
    protected $precio;
    protected $fecha_Insumo;
    protected $estatus_ins;

    public function __construct($propiedades = null) {
        parent::__construct('insumo', InsumoModel::class, $propiedades);
    }

    /* Getters */
    public function getNombre(){return $this->nombre;}
    public function getCantidadMin(){return $this->cantidad_min;}

    public function getCantidadUnidad(){return $this->cantidad_unidad;}
    public function getCapacidadUnidad(){return $this->capacidad_unidad;}
    public function getCantidadCapacidad(){return $this->cantidad_capacidad;}
    public function getEsCobrado(){return $this->es_cobrado;}
    public function getTipoMedida(){return $this->tipo_medida;}    
    public function getTipoInsumo(){return $this->tipo_insumo;}    
    
    public function getPrecio(){return $this->precio;}
    public function getEstatusIns(){return $this->estatus_ins;}

    /* Setters */
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setCantidadMin($cantidad_min){return $this->cantidad_min = $cantidad_min;}
    
    public function setCantidadUnidad($cantidad_unidad){return $this->cantidad_unidad = $cantidad_unidad;}
    public function setCapacidadUnidad($capacidad_unidad){return $this->capacidad_unidad = $capacidad_unidad;}
    public function setCantidadCapacidad($cantidad_capacidad){return $this->cantidad_capacidad = $cantidad_capacidad;}
    public function setEsCobrado($es_cobrado){return $this->es_cobrado = $es_cobrado;}
    public function setTipoMedida($tipo_medida){return $this->tipo_medida = $tipo_medida;}
    public function setTipoInsumo($tipo_insumo){return $this->tipo_insumo = $tipo_insumo;}    
    
    
    public function setPrecio($precio){return $this->precio = $precio;}
    public function setEstatusIns($estatus_ins){return $this->estatus_ins = $estatus_ins;}
}

?>