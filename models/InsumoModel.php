<?php

require_once 'GenericModel.php';

class InsumoModel extends GenericModel {

    protected $nombre;
    protected $cantidad;
    protected $stock;
    protected $cantidad_min;
    protected $precio;
    protected $fecha_Insumo;

    public function __construct($propiedades = null) {
        parent::__construct('insumo', InsumoModel::class, $propiedades);
    }

    /* Getters */
    public function getNombre(){return $this->nombre;}
    public function getCantidad(){return $this->cantidad;}
    public function getStock(){return $this->stock;}
    public function getCantidadMin(){return $this->cantidad_min;}
    public function getPrecio(){return $this->precio;}

    /* Setters */
    public function setNombre($nombre){return $this->nombre = $nombre;}
    public function setCantidad($cantidad){return $this->cantidad = $cantidad;}
    public function setStock($stock){return $this->stock = $stock;}
    public function setCantidadMin($cantidad_min){return $this->cantidad_min = $cantidad_min;}
    public function setPrecio($precio){return $this->precio = $precio;}
}

?>