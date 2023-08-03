<?php

class AuditMiddleware extends Middleware {
    public $method;
    protected $row;
    protected $POST;
    
    public function __construct() {
        parent::__construct();

        $this->POST = json_decode(file_get_contents('php://input'), true);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function handleRequest($request = null) {}

    public function handleResponse($request = null) {
        $this->insertAudit();
    }

    public function insertAudit() {
        $accion = "";

        if ( $this->method == 'POST' ) {
            $accion == 'insert';
        } else {
            $accion = $this->method == 'PUT' ? 'update' : 'delete';
        }
        
        $data = [
            "usuario_id" => $this->usuario['usuario_id'],
            "descripcion" => $this->row,
            "accion" =>  $accion
        ];

        $_auditModel = new AuditoriaModel();
        $_auditModel->insert($data);
    }
}