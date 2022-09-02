<?php

require_once 'GenericModel.php';

class UsuarioModel extends GenericModel{

    protected $usuarios_id;
    protected $nombres;
    protected $apellidos;
    protected $correo;

    public function __construct($propiedades = null){
        
        parent::__construct('usuarios', UsuarioModel::class, $propiedades);
    }

    /* Getters */
    public function getUsuarioId(){return $this->usuarios_id;}
    public function getNombres(){return $this->nombres;}
    public function getApellidos(){return $this->apellidos;}
    public function getCorreo(){return $this->correo;}

    /* Setters */
    public function setUsuarioId($usuario_id){$this->usuarios_id = $usuario_id;}
    public function setNombres($nombres){$this->nombres = $nombres;}
    public function setApellidos($apellidos){$this->apellidos = $apellidos;}
    public function setCorreo($correo){$this->correo = $correo;}
}


?>