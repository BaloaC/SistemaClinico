<?php

include_once './services/seguros/empresa/EmpresaValidaciones.php';

class EmpresaHelpers {

    // protected static $arrayInner = array(
    //     "empresa" => "seguro_empresa",
    //     "seguro" => "seguro_empresa",
    // );

    public static function insertarSeguroEmpresa($seguros, $empresa_id){
        
        foreach ($seguros as $seguro) {
            
            $seguro['empresa_id'] = $empresa_id;
            EmpresaValidaciones::validarDuplicadoSeguroEmpresa($seguro);

            $_seguroEmpresaModel = new SeguroEmpresaModel();
            $id = $_seguroEmpresaModel->insert($seguro);
            
            $mensaje = ($id > 0);
            
            if (!$mensaje) {  

                $respuesta = new Response(false, 'Hubo un error insertando el seguro');
                $respuesta->setData($seguro['seguro_id']);
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}