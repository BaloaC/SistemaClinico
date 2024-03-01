<?php

class AuditMiddleware extends Middleware {
    public $method;
    protected $row;
    protected $POST;
    protected $data;
    protected $code;
    
    public function __construct($data, $code) {
        parent::__construct();

        $this->code = $code;
        $this->data = $data;
        $this->POST = json_decode(file_get_contents('php://input'), true);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function handleRequest($request = null) {
        $this->getToken(); 
        $this->getUsuario(); 
        $this->insertAudit();
        global $isEnabledAudit;
        
        switch ($this->method) {
            case 'POST':
                $this->row = $this->usuario->nombre." ha insertado un nuevo elemento ".$_POST['nombre']." en el módulo $isEnabledAudit";
                break;
            
            case 'PUT':
                $this->row = $this->usuario->nombre." ha actualizado al elemento ".$_POST['nombre']." en el módulo $isEnabledAudit";
                break;
            
            case 'DELETE':
                $this->row = $this->usuario->nombre." ha eliminado al elemento ".$_POST['nombre']." en el módulo $isEnabledAudit";
                break;
        }

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        $accion = "";

        if ( $this->method == 'POST' ) {
            $accion = 'insert';
        } else {
            $accion = $this->method == 'PUT' ? 'update' : 'delete';
        }
        
        $data = [
            "usuario_id" => $this->usuario->usuario_id,
            "descripcion" => $this->row,
            "accion" =>  $accion
        ];

        $_auditModel = new AuditoriaModel();
        $_auditModel->insert($data);
    }

    public function insertAudit() {
        
    }
}