<?php

abstract class Middleware {
    public $tokenAccess;
    public $usuario;

    public function __construct() {
    }

    abstract function handleRequest($request = null);
    abstract function handleResponse($response = null);

    public function getToken() {
        $head = apache_request_headers()['Authorization'];
        $this->tokenAccess = substr($head, 7);
    }

    public function getUsuario() {
        $_usuarioModel = new UsuarioModel();
        $this->usuario = $_usuarioModel->where('tokken', '=', $this->tokenAccess)->getFirst();
    }
}