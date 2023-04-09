<?php

class PreguntaSeguridadController extends Controller{

    public function insertarPregunta($form, $usuario_id) {

        // $_POST = json_decode(file_get_contents('php://input'), true);
        $validarUsuario = new Validate;

        foreach ($form as $posts) {

            switch($form) {
                case ($validarUsuario->isEmpty($posts)):
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(400);
            
                case !$validarUsuario->isDuplicated("usuario", 'usuario_id', $usuario_id):
                    $respuesta = new Response('NOT_FOUND');
                    return $respuesta->json(404);

                default: 

                    $data = $validarUsuario->dataScape($posts);
                    $data['usuario_id'] = $usuario_id;

                    $_preguntaSeguridadModel = new PreguntaSeguridadModel();
                    $actualizado = $_preguntaSeguridadModel->insert($data);
                    $mensaje = ($actualizado > 0);
            
                    if (!$mensaje) {

                        $respuesta = new Response('INSERCION_FALLIDA');
                        $respuesta->setData($posts['pregunta']);
                        return $respuesta->json(404);
                    }
            }
        }
        return false;
    }

    public function comprobarPregunta() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarUsuario = new Validate;
        
        switch($_POST) {
        
            case !$validarUsuario->isDuplicated("usuario", "nombre", $_POST['nombre']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            default: 
   
                $nombre = $_POST['nombre'];
                $pregunta = $_POST['preguntas'];
                $correcto = 0;

                foreach ($pregunta as $preguntas) {
                    
                    $_preguntaSeguridadModel = new PreguntaSeguridadModel();
                    $select = $_preguntaSeguridadModel->where('pregunta', '=', $preguntas['pregunta'])->getFirst();
                    $respuesta = $select->respuesta;
                    
                    if ($preguntas['respuesta'] != $respuesta) {
                        
                        $respuesta = new Response(false, 'Respuesta de seguridad incorrecta');
                        $respuesta->setData($preguntas['pregunta']);
                        return $respuesta->json(400);
                    }
                    $correcto ++;
                }
                
                if ($correcto != 2) {
                    $respuesta = new Response(false, 'Respuestas de seguridad incompletas');
                    return $respuesta->json(400);
                }

                $insert['clave'] = password_hash($_POST['nueva_clave'], PASSWORD_DEFAULT);
                
                $_usuarioModel = new UsuarioModel();
                $mensaje = $_usuarioModel->where('nombre', '=', $nombre)->update($insert);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarPreguntas(){

        $_preguntaSeguridadModel = new PreguntaSeguridadModel();
        $preguntas = $_preguntaSeguridadModel->where('estatus_pre','=','1')->getAll();
        $mensaje = (count($preguntas) > 0);
        return $this->retornarMensaje($mensaje, $preguntas);
    }

    public function listarPreguntasPorId($pregunta_id){

        $_preguntaSeguridadModel = new PreguntaSeguridadModel();
        $preguntas = $_preguntaSeguridadModel->where('estatus_pre','=','1')->where('pregunta_id', '=', $pregunta_id)->getFirst();
        $mensaje = (count((array)$preguntas) > 0);
        return $this->retornarMensaje($mensaje, $preguntas);
    }

    public function listarPreguntasPorUsuarioId(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $validarUsuario = new Validate;
        if(!$validarUsuario->isDuplicated("usuario","nombre",$_POST['nombre_usuario'])){
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
        }
        
        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('estatus_usu','=','1')->where('nombre', '=', $_POST['nombre_usuario'])->getFirst();
        
        $_preguntaSeguridadModel = new PreguntaSeguridadModel();
        $preguntas = $_preguntaSeguridadModel->where('estatus_pre','=','1')->where('usuario_id', '=', $usuario->usuario_id)->getFirst();
        
        $mensaje = (isset($preguntas));
        return $this->retornarMensaje($mensaje, $preguntas);
    }


    public function eliminarPreguntaSeguridad($pregunta_seguridad_id){

        $_preguntaSeguridadModel = new PreguntaSeguridadModel();
        $data = array(
            "estatus_pre" => "2"
        );

        $eliminado = $_preguntaSeguridadModel->where('pregunta_seguridad_id','=',$pregunta_seguridad_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    //utils
    public function retornarMensaje($mensaje, $dataReturn) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($dataReturn);
        return $respuesta->json($mensaje ? 200 : 404);
    }
}

?>