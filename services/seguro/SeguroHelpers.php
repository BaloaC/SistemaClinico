<?php

class SeguroHelpers {

    protected static $arrayInner = array(
        "empresa" => "seguro_empresa",
        "seguro" => "seguro_empresa",
    );

    protected static $arraySelect = array(
        "empresa.empresa_id",
        "empresa.nombre AS nombre_empresa",
        "empresa.rif",
        "empresa.direccion"
    );

    public static function listarEmpresasSeguros($seguro_id) {

        $_seguroModel = new SeguroModel();
        $inners = $_seguroModel->listInner(SeguroHelpers::$arrayInner);

        $EmpresaSeguro = $_seguroModel->where('seguro.seguro_id','=', $seguro_id)
                                        ->where('seguro.estatus_seg', '=', '1')
                                        ->innerJoin(SeguroHelpers::$arraySelect, $inners, "seguro_empresa");
        
        return $EmpresaSeguro;
    }

    public static function listarEmpresasCostos($seguro_id) {

        $_seguroExamenModel = new SeguroExamenModel();
        $seguro_examenes = $_seguroExamenModel->where('seguro_id', '=',$seguro_id)->getFirst();
        $seguro_costos = [];

        if ( !is_null($seguro_examenes) ) {
            
            $examenes = explode(',', $seguro_examenes->examenes);
            $costos = explode(',', $seguro_examenes->costos);

            foreach ($examenes as $examen) {

                $index = array_search( $examen, explode(',', $seguro_examenes->examenes));
                
                $_examenModel = new ExamenModel();
                $examen = $_examenModel->where('examen_id', '=', $examen)->getFirst();

                $examen_seguro = $examen;
                $costos_seguro = new stdClass();
                $costos_seguro->precio_examen_seguro = $costos[$index];

                $seguro_costos[] = array_merge( (Array )$examen, (Array) $costos_seguro);
            }
        }

        return $seguro_costos;
    }

    public static function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        echo $respuesta->json(200);
        exit();
    }
}