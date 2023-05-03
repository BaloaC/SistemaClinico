<?php 

class MiddlewareBase {

    private static $token;

    public static function verifyToken($head) {
        
        MiddlewareBase::$token = substr($head, 7);
        if (!isset(MiddlewareBase::$token)  || empty(MiddlewareBase::$token && MiddlewareBase::$token != 'undefined') ) {
            return false;  
        } else{
            return true;
        }

        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('tokken', '=', 'MiddlewareBase::$token')->getFirst();
        
        if (!$usuario) {
            return false;
        } else {
            return true;
        }
    }

    public static function verifyPermissions($niveles) {
        $roles = explode(",", $niveles);
        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('tokken', '=', MiddlewareBase::$token)->getFirst();
        if ($niveles != 0 && isset($usuario)) {
            foreach ($roles as $rol) {
                if ($usuario->rol == $rol || $usuario->rol == 1) {
                    return true;
                }
            }
            return false;
        } else {
            return false;
        }
        
    }

    // public static function token() {
    //     $token = substr(MiddlewareBase::$header, 7);
    //     if (!isset($token)  || empty($token) ) {
            
    //         return false;
            
    //     } else {
    //         return true;
    //     }
    // }
}

?>