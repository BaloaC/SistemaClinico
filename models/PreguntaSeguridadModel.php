<?php

require_once 'GenericModel.php';

class PreguntaSeguridadModel extends GenericModel{

    protected $usuario_id;
    protected $pregunta;
    protected $respuesta;

    public function __construct($propiedades = null){
        
        parent::__construct('pregunta_seguridad', PreguntaSeguridadModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuario_id;}
    public function getPregunta(){return $this->pregunta;}
    public function getRespuesta(){return $this->respuesta;}

    /* Setters */
    public function setUsuarioId($usuario_id){$this->usuario_id = $usuario_id;}
    public function setPreguntas($pregunta){$this->pregunta = $pregunta;}
    public function setRespuesta($respuesta){$this->respuesta = $respuesta;}
}


?>