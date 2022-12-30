<?php

class LoginController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('login/index');
    }

    public function entrar(){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $camposKey = array("nombre", "clave");

        $validarLogin = new Validate;
        switch ($_POST) {
            case $validarLogin->isEmpty($_POST):
                return $respuesta = new Response('DATOS_INVALIDOS');
            
            case $validarLogin->isDuplicated('usuario', 'nombre', $_POST["nombre"]):

                $_UsuarioModel = new UsuarioModel();
                $usuario = $_UsuarioModel->where('nombre','=',$_POST["nombre"])->getFirst();
                $claveEncriptada = $usuario->clave;
                $clave = $_POST["clave"];


                if(password_verify($clave, $claveEncriptada)){
                    $code = bin2hex(random_bytes(5));
                    $tokken = array( 'tokken' => $code);   

                    $_UsuarioModel = new UsuarioModel();

                    $actualizado = $_UsuarioModel->where('nombre','=',$_POST['nombre'])->update($tokken);
                    $mensaje = ($actualizado > 0);
                    
                    $tokken['usuario_id'] = $usuario->usuario_id;
                    $tokken['rol'] = $usuario->rol;

                    $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
                    $respuesta->setData($tokken);

                    return $respuesta;

                } else {
                    return $respuesta = new Response(false, 'DATOS_INVALIDOS');
                }

            default:
                return $respuesta = new Response(false, 'DATOS_INVALIDOS');
        }
    }

}
?>