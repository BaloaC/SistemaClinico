<?php

include_once './services/seguros/seguro/SeguroHelpers.php';
include_once './services/seguros/seguro/SeguroValidaciones.php';

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

    public static function eliminarSeguroExamen($form, $seguro_id) {

        $_seguroExamen = new SeguroExamenModel();
        $seguro_examen = $_seguroExamen->where('seguro_id', '=', $seguro_id)->getFirst();

        // Volvemos los string array para manejar la información por índices
        $examenes = explode(',', $seguro_examen->examenes);
        $costos = explode(',', $seguro_examen->costos);
        
        SeguroValidaciones::validarUltimoExamenSeguro($examenes);

        if ( array_search( ($form['examen_id']) , $examenes ) ) {
            
            // Obtenemos el índice donde se encuentre el examen a eliminar
            $index_examen = array_search( ($form['examen_id']) , $examenes ); 

        } else if ($form['examen_id'] == $examenes[0]) {
            $index_examen = 0;

        } else {
            $respuesta = new Response(false, 'El examen indicado no está relacionado a ese seguro');
            return $respuesta->json(400);
        }
        
        unset($examenes[$index_examen]);
        unset($costos[$index_examen]);
        
        // Los volvemos string de nuevo
        $info_update['examenes'] = implode(',', $examenes);
        $info_update['costos'] = implode(',', $costos);
        $isUpdated = $_seguroExamen->update($info_update);

        if ($isUpdated <= 0) {
            $respuesta = new Response('ACTUALIZACION_FALLIDA');
            echo $respuesta->json(400);
            exit();
        }
    }
}
