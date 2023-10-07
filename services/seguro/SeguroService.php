<?php

include_once './services/seguro/SeguroHelpers.php';

class SeguroService {

    public static function ListarTodos($seguros) {
        
        $seguro_id = $seguros->seguro_id;
        $validarSeguro = new Validate;

        // Verificamos si hay que aplicarle un inner join a ese seguro en específico
        $respuesta = $validarSeguro->isDuplicated('seguro_empresa', 'seguro_id', $seguro_id);

        if($respuesta){
            $seguros->empresas = SeguroHelpers::listarEmpresasSeguros($seguro_id);
        }

        $examenes = SeguroHelpers::listarEmpresasCostos($seguro_id);
        
        if ( $examenes ) {
            $seguros->examenes = $examenes;
        }

        return $seguros;
    }
}
