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

}
