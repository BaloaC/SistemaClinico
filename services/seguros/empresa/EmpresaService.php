<?php

include_once './services/seguros/empresa/EmpresaValidaciones.php';
include_once './services/seguros/empresa/EmpresaService.php';
include_once './services/seguros/empresa/EmpresaHelpers.php';

class EmpresaService {

    public static function insertarEmpresa($formulario) {
        
        EmpresaValidaciones::validarCamposVacíos($formulario);
        EmpresaValidaciones::validarNombreEmpresa($formulario['nombre']);
        EmpresaValidaciones::validarRif($formulario['rif']);
        EmpresaValidaciones::validarSeguros($formulario['seguro']);

        $validarEmpresa = new Validate;

        $data = $validarEmpresa->dataScape($_POST);

        $seguro = $data['seguro'];
        unset($data['seguro']);
        
        $_empresaModel = new EmpresaModel();
        $id = $_empresaModel->insert($data);

        if ($id > 0) {
            EmpresaHelpers::insertarSeguroEmpresa($seguro, $id);
            return $data;
        }
    }

    public static function actualizarEmpresa($formulario, $empresa_id) {

        $validarEmpresa = new Validate();
        $empresa = $validarEmpresa->dataScape($formulario);
        EmpresaValidaciones::validarCamposVacíos($empresa);
        
        if (isset($empresa['rif'])) {
            EmpresaValidaciones::validarRif($empresa['rif']);
        }
        
        if (array_key_exists('nombre', $empresa)) {
            EmpresaValidaciones::validarNombreEmpresa($empresa['nombre']);
        }

        if (isset($empresa['seguro'])) {
            EmpresaValidaciones::validarSeguros($empresa['seguro']);

            EmpresaHelpers::insertarSeguroEmpresa($empresa['seguro'], $empresa_id);
            unset($formulario['seguro']);
        }

        if ( !$validarEmpresa->isEmpty($empresa) ) {

            $_empresaModel = new EmpresaModel();
            $actualizado = $_empresaModel->where('empresa_id','=',$empresa_id)->update($formulario);
            $mensaje = ($actualizado > 0);

            if (!$mensaje) {
                $respuesta = new Response('ACTUALIZACION_FALLIDA');
                $respuesta->setData($empresa);
                echo $respuesta->json(400);
                exit();
            }
            
            return $empresa;
        }
    }
}
