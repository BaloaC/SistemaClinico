<?php

class AuthenticationMiddleware extends Middleware {
    public $token;

    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        if (!isset( apache_request_headers()['Authorization'] )  || apache_request_headers()['Authorization'] == 'undefined') {
            $this->handleResponse();
        }
        
        $this->getToken();

        if (!isset($this->tokenAccess)  || empty($this->tokenAccess && $this->tokenAccess != 'undefined') ) {
            $this->handleResponse();
        }

        // $_usuarioModel = new UsuarioModel();
        // $this->usuario = $_usuarioModel->where('tokken', '=', $this->tokenAccess)->getFirst();
        $this->getUsuario();

        if (is_null($this->usuario)) {
            $this->handleResponse();
        }
    }

    public function handleResponse($response = null) {
        http_response_code(401);
        echo json_encode([
            "code" => false,
            "message" => "El token de seguridad es obligatorio"
        ]);
        exit();
    }
}