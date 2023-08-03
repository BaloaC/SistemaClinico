<?php

class AuthorizationMiddleware extends Middleware {
    private $nivel;

    public function __construct(Array $nivel = null) {
        $this->nivel = $nivel;
        $this->getToken(); $this->getUsuario();
    }

    public function handleRequest($request = null) {
        
        if ($this->usuario->rol == 1) {
            return true;
        }

        foreach ($this->nivel as $nivel) {
            if ( $this->usuario->rol == $nivel ) {
                return true;
            }
        }

        $this->handleResponse();
    }

    public function handleResponse($response = null) {
        http_response_code(401);
        echo json_encode([
            "code" => false,
            "message" => "Usted no tiene permisos para acceder a este recurso"
        ]);
        exit();
    }
}