<?php

    class CuentaService {
        
        public static function insertarNuevoUsuario($formulario) {
            $validarUsuario = new Validate;
            
            unset($formulario['preguntas']);
            $claveEncriptada = password_hash($formulario["clave"], PASSWORD_DEFAULT);
            $pinEncriptado = password_hash($formulario["pin"], PASSWORD_DEFAULT);

            $clave = array('clave' => $claveEncriptada, 'pin' => $pinEncriptado);
            $ArrayNuevo = array_replace($formulario, $clave);
            $data = $validarUsuario->dataScape($ArrayNuevo);
            
            $hoy = date('Y-m-d h:i:s');
            $data['fecha_creacion'] = $hoy;
            
            $_usuarioModel = new UsuarioModel();
            $id = $_usuarioModel->insert($data);

            return $id;
        }
    }