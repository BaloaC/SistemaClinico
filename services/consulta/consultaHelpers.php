<?php

include_once './services/globals/GlobalsHelpers.php';

class ConsultaHelper {

    // variables para el inner join de seguros con cita
    protected static $selectSeguro = array(
        "cita_seguro.cita_id",
        "cita.estatus_cit",
        "seguro.seguro_id",
        "seguro.nombre",
        "clave"
    );

    protected static $innerSeguro = array(
        "cita" => "cita_seguro",
        "seguro" => "cita_seguro"
    );

    // no sé pa qué son estos
    protected static $arrayInner = array(
        "paciente" => "consulta",
        "medico" => "consulta",
        "especialidad" => "consulta",
        "cita" => "consulta",
        // "consulta_indicaciones" => "consulta"
    );

    protected static $arraySelect = array(
        "consulta.consulta_id",
        "consulta.peso",
        "consulta.altura",
        "consulta.observaciones",
        "consulta.fecha_consulta",
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula as cedula_paciente",
        "paciente.tipo_paciente",
        "paciente.edad",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellido_medico",
        "medico.cedula AS cedula_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "cita.cita_id",
        "cita.fecha_cita",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.clave",
        "cita.tipo_cita",
        // "consulta_indicaciones.descripcion"
    );

    //datos del inner con los exámenes
    protected static $arrayInnerExa = array(
        "examen" => "consulta_examen"
    );

    protected static $arraySelectExa = array(
        "examen.examen_id",
        "examen.nombre"
    );

    //datos del inner con los insumos
    protected static $arrayInnerIns = array(
        "insumo" => "consulta_insumo"
    );

    protected static $arraySelectIns = array(
        "insumo.insumo_id",
        "insumo.nombre"
    );
    //datos del inner con los insumos
    protected static $arrayInnerRec = array(
        "medicamento" => "consulta_recipe"
    );

    protected static $arraySelectRec = array(
        "consulta_recipe.consulta_recipe_id",
        "consulta_recipe.consulta_id",
        "consulta_recipe.consulta_recipe_id",
        "medicamento.medicamento_id",
        "medicamento.nombre_medicamento",
        "medicamento.tipo_medicamento",
        "consulta_recipe.uso"
    );

    public static function obtenerRelaciones($consulta_id) {
        $_consultaModel = new ConsultaModel();
        $innersExa = $_consultaModel->listInner(ConsultaHelper::$arrayInnerExa);
        $consulta_examenes = $_consultaModel->where('consulta_examen.consulta_id', '=', $consulta_id)->where('consulta_examen.estatus_con', '=', 1)->innerJoin(ConsultaHelper::$arraySelectExa, $innersExa, "consulta_examen");
        $consultas = new stdClass();

        if ($consulta_examenes) {
            $consultas->examenes = $consulta_examenes;
        }

        $_consultaModel = new ConsultaModel();
        $innersIns = $_consultaModel->listInner(ConsultaHelper::$arrayInnerIns);
        $consulta_insumos = $_consultaModel->where('consulta_insumo.consulta_id', '=', $consulta_id)->where('consulta_insumo.estatus_con', '=', 1)->innerJoin(ConsultaHelper::$arraySelectIns, $innersIns, "consulta_insumo");

        if ($consulta_insumos) {
            $consultas->insumos = $consulta_insumos;
        }

        $_consultaIndicacionesModel = new ConsultaIndicacionesModel();
        $consulta_indicaciones = $_consultaIndicacionesModel->where('consulta_indicaciones.consulta_id', '=', $consulta_id)->getAll();

        if($consulta_indicaciones){
            $consultas->indicaciones = $consulta_indicaciones;
        }

        $_consultaRecipeModel = new ConsultaRecipeModel();
        $innersRec = $_consultaRecipeModel->listInner(ConsultaHelper::$arrayInnerRec);
        $consulta_recipes = $_consultaRecipeModel->where('consulta_recipe.consulta_id', '=', $consulta_id)->innerJoin(ConsultaHelper::$arraySelectRec, $innersRec, "consulta_recipe");

        if($consulta_recipes){
            $consultas->recipes = $consulta_recipes;
        }

        $_consultaModel = new ConsultaModel();
        $innersRec = $_consultaModel->listInner(ConsultaHelper::$arrayInnerRec);
        $recipesList = $_consultaModel->where('consulta_recipe.consulta_id', '=', $consulta_id)
                                        ->innerJoin(ConsultaHelper::$arraySelectRec, $innersRec, "consulta_recipe");
        
        if ($recipesList) {
            $consultas->recipes = $recipesList;
        }

        $_indicacionesModel = new ConsultaIndicacionesModel();
        $indicacionesList = $_indicacionesModel->where('consulta_indicaciones.consulta_id', '=', $consulta_id)
                                                ->getAll();

        if ($indicacionesList) {
            $consultas->indicaciones = $indicacionesList;
        }
        
        return $consultas;
    }

    public static function insertarExamenesEmergencia($formulario) {

        $_seguroExamen = new SeguroExamenModel();
        $seguro_examen = $_seguroExamen->where('seguro_id', '=', $formulario['seguro_id'])->getFirst();
        
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
        $consulta_examen = [];

        foreach ($formulario['examenes'] as $examen) {

            if (is_null($seguro_examen)) {
                $consulta_examen[] = ConsultaHelper::obtenerPrecioExamenNormal($examen, $formulario['consulta_id']);
            } else {

                $indice = array_search( $examen['examen_id'], explode(',', $seguro_examen->examenes));

                if (!$indice) {
                    $consulta_examen[] = ConsultaHelper::obtenerPrecioExamenNormal($examen, $formulario['consulta_id']);

                } else {

                    $costos = explode(',', $seguro_examen->costos);
                    $consulta_examen[] = [
                        'consulta_id' => $formulario['consulta_id'],
                        'examen_id' => $examen['examen_id'],
                        'precio_examen_usd' => $costos[$indice],
                        'precio_examen_bs' => 0,
                        // 'precio_examen_bs' => round($costos[$indice] * $valorDivisa, 2),
                    ];
                }
            }
        }

        $total_examenes = 0;

        foreach ($consulta_examen as $consulta) {
            $total_examenes += $consulta['precio_examen_usd'];
            $_consultaExamenModel = new ConsultaExamenModel();
            $_consultaExamenModel->insert($consulta);
        }
        
        $formulario['total_examenes'] = $total_examenes;
        $formulario['total_examenes_bs'] = 0;
        // $formulario['total_examenes_bs'] = $formulario['total_examenes'] * $valorDivisa;
        
        return $formulario;
    }

    public static function insertarExamenesSeguro($examenes, $consulta_id) {

        $_consultaCitaModel = new ConsultaCitaModel();
        $consulta_cita = $_consultaCitaModel->where('consulta_id', '=', $consulta_id)->getFirst();

        $_citaSeguroModel = new CitaSeguroModel();
        $cita_seguro = $_citaSeguroModel->where('cita_id', '=', $consulta_cita->cita_id)->getFirst();
        
        $_seguroExamen = new SeguroExamenModel();
        $seguro_examen = $_seguroExamen->where('seguro_id', '=', $cita_seguro->seguro_id)->getFirst();
        
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
        $consulta_examen = [];

        foreach ($examenes as $examen) {

            if (is_null($seguro_examen)) {
                $consulta_examen[] = ConsultaHelper::obtenerPrecioExamenNormal($examen, $consulta_id);
            } else {

                $indice = array_search( $examen['examen_id'], explode(',', $seguro_examen->examenes));

                if (!$indice) {
                    $consulta_examen[] = ConsultaHelper::obtenerPrecioExamenNormal($examen, $consulta_id);

                } else {

                    $costos = explode(',', $seguro_examen->costos);
                    $consulta_examen[] = [
                        'consulta_id' => $consulta_id,
                        'examen_id' => $examen['examen_id'],
                        'precio_examen_usd' => $costos[$indice],
                        'precio_examen_bs' => 0,
                        // 'precio_examen_bs' => round($costos[$indice] * $valorDivisa, 2),
                    ];
                }
            }
        }

        foreach ($consulta_examen as $consulta) {
            $_consultaExamenModel = new ConsultaExamenModel();
            $_consultaExamenModel->insert($consulta);
        }
        
    }

    public static function obtenerPrecioExamenNormal($examen, $consulta_id) {
        
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

        $_examenModel = new ExamenModel();
        $examenSeguro = $_examenModel->where('examen_id', '=', $examen['examen_id'])->getFirst();
        
        $consulta_examen = [
            'consulta_id' => $consulta_id,
            'examen_id' => $examen['examen_id'],
            'precio_examen_usd' => $examenSeguro->precio_examen,
            'precio_examen_bs' => round($examenSeguro->precio_examen * $valorDivisa, 2),
        ];

        return $consulta_examen;
    }

    public static function actualizarPrecioEmergencia($consulta) {

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $consulta_seguro = $_consultaSeguroModel->where('consulta_seguro_id', '=', $consulta["consulta_seguro_id"])->getFirst();

        $_consultaEmergenciaModel = new ConsultaEmergenciaModel();
        $consulta_emergencia = $_consultaEmergenciaModel->where('consulta_id', '=', $consulta_seguro["consulta_id"])->getFirst();

        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

        $consulta_emergencia_nueva = Array(
            'consultas_medicas_bs' => round( $consulta_emergencia->consultas_medicas * $valorDivisa, 2),
            'laboratorios_bs' => round( $consulta_emergencia->laboratorios * $valorDivisa, 2),
            'medicamentos_bs' => round( $consulta_emergencia->medicamentos * $valorDivisa, 2),
            'area_observacion_bs' => round( $consulta_emergencia->area_observacion * $valorDivisa, 2),
            'enfermeria_bs' => round( $consulta_emergencia->enfermeria * $valorDivisa, 2),
            'total_insumos_bs' => round( $consulta_emergencia->total_insumos * $valorDivisa, 2),
            'total_examenes_bs' => round( $consulta_emergencia->total_examenes * $valorDivisa, 2),
            'total_consulta_bs' => round( $consulta_emergencia->total_consulta * $valorDivisa, 2),
        );

        $_consultaEmergenciaModel->update($consulta_emergencia_nueva);
    }
}