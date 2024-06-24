<?php

class AuditCuenta extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        // $this->getToken();
        // $this->getUsuario();
        $row = '';
        $accion = '';
        $usuario = '';
        
        if ($this->method == 'POST') {
            
            if (array_key_exists('auth', $_POST) || array_key_exists('preguntas', $_POST)) {
                
                $_usuarioModel = new UsuarioModel();
                $usuario = $_usuarioModel->where('usuario_id','=',preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();
                
                $row = "El usuario id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." con nombre ".$usuario->nombre." ha reestablecido su clave mediante recuperación de usuario";
                $accion = 'actualización';
                $usuario = $usuario->usuario_id;

            } else {
                $row = "Se ha registrado un nuevo usuario ".$_POST['nombre']." en el sistema";
                $usuario = $request['usuario_id'];
                $accion = 'inserción';
            }
        
        } else {
            return;
        }

        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');
        
        $this->row = [
            "usuario_id" => $usuario,
            "accion" => $accion,
            "descripcion" => $row,
            "modulo" => 'usuarios',
            "fecha_creacion" => $hoy_formateado,
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}