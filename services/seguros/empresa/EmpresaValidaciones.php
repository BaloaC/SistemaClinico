<?php

class EmpresaValidaciones {

    public static function validarCamposVacíos($formulario) {
        $validarEmpresa = new Validate();
        
        if ($validarEmpresa->isEmpty($formulario)) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarNombreEmpresa($nombre) {
        $validarEmpresa = new Validate();

        if ( $validarEmpresa->isDuplicated('empresa', 'nombre', $nombre) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            $respuesta->setData($nombre);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarRif($rif) {
        $validarEmpresa = new Validate();

        if ( $validarEmpresa->isDuplicated('empresa', 'rif', $rif) ) {
            $respuesta = new Response('DATOS_DUPLICADOS');
            $respuesta->setData($rif);
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function validarSeguros($seguros) {
        $validarEmpresa = new Validate();

        foreach ($seguros as $seguro) {

            if ( $validarEmpresa->isEmpty($seguro) ) {
                $respuesta = new Response('DATOS_VACIOS');
                echo $respuesta->json(400);
                exit();
            }

            if ( !$validarEmpresa->isDuplicated('seguro', 'seguro_id', $seguro['seguro_id']) ) {
                $respuesta = new Response('NOT_FOUND');
                $respuesta->setData('No se encontraron resultados del seguro '.$seguro['seguro_id']);
                echo $respuesta->json(400);
                exit();
            }   
        }
    }

    public static function validarDuplicadoSeguroEmpresa($formulario) {
        $validarEmpresa = new Validate();

        if ( $validarEmpresa->isDuplicatedId('seguro_id', 'empresa_id', $formulario['seguro_id'], $formulario['empresa_id'], 'seguro_empresa') ) {
            $respuesta = new Response(false, 'La empresa ya está asociada a ese seguro');
            $respuesta->setData($formulario['seguro_id']);
            echo $respuesta->json(400);
            exit();
        }
    }
}