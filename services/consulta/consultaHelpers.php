<?php

class ConsultaHelper {

    // variables para el inner join de consultas_sin cita
    protected static $selectConsultaSinCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad"
    );

    protected static $innerConsultaSinCita = array(
        "paciente" => "consulta_sin_cita",
        "medico" => "consulta_sin_cita",
        "especialidad" => "consulta_sin_cita"
    );

    // variables para el inner join de consultas con cita
    protected static $selectConsultaCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.cedula",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "consulta_cita.consulta_id",
        "consulta_cita.cita_id",
        "consulta.estatus_con",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.tipo_cita"
    );

    protected static $innerConsultaCita = array(
        "cita" => "consulta_cita",
        "consulta" => "consulta_cita",
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita"
    );

    // variables para el inner join de paciente beneficiado
    protected static $selectPacienteBeneficiado = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.cedula",
        "paciente_beneficiado.paciente_beneficiado_id"
    );

    protected static $innerPacienteBeneficiado = array(
        "paciente" => "paciente_beneficiado"
    );

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


    public static function obtenerInformacionCompleta($consulta) {
        // Obtenemos el resto de la información de la consulta

        if ($consulta->es_emergencia) {
            $_consultaEmergencia = new ConsultaEmergenciaModel();
            $consultaEmergencia = $_consultaEmergencia->where('consulta_id','=', $consulta->consulta_id)->getFirst();
            
            $_paciente = new PacienteModel();
            $paciente = $_paciente->where('paciente_id','=', $consultaEmergencia->paciente_id)->getFirst();

            $_pacienteBeneficiado = new PacienteBeneficiadoModel();
            $innersPaciente = $_pacienteBeneficiado->listInner(ConsultaHelper::$innerPacienteBeneficiado);
            $beneficiado = $_pacienteBeneficiado->where('paciente_beneficiado.paciente_beneficiado_id', '=', $consultaEmergencia->paciente_beneficiado_id)
                                    ->where('paciente_beneficiado.estatus_pac','=',1)
                                    ->innerJoin(ConsultaHelper::$selectPacienteBeneficiado, $innersPaciente, "paciente_beneficiado");

            $consultas = $consulta;
            $consultas->paciente_id = $consultaEmergencia->paciente_id;
            $consultas->factura = $consultaEmergencia;
            $consultas->titular = $paciente;
            $consultas->beneficiado = $beneficiado;

            $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);

            if (count((array) $relaciones) > 0) {
                return (object) array_merge((array) $consultas, (array) $relaciones);
            } else {
                return $consultas;
            }

        } else {

            $_consultaCita = new ConsultaCitaModel();
            $innersCita = $_consultaCita->listInner(ConsultaHelper::$innerConsultaCita);
            $es_citada = $_consultaCita->where('consulta_cita.consulta_id', '=', $consulta->consulta_id)
                                    ->where('consulta.estatus_con','=',1)
                                    ->innerJoin(ConsultaHelper::$selectConsultaCita, $innersCita, "consulta_cita");

            if (is_null($es_citada) || count($es_citada) == 0 ) { // Si no es por cita, extraemos la información de consulta_sin_cita
                $_consultaSinCita = new ConsultaSinCitaModel();
                $innersConsulta = $_consultaSinCita->listInner(ConsultaHelper::$innerConsultaSinCita);
                $consultaCompleta = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                                    ->innerJoin(ConsultaHelper::$selectConsultaSinCita, $innersConsulta, "consulta_sin_cita");

                $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
                
                if (count((array) $relaciones) > 0) {
                    $consultaCompleta[0] = (object) array_merge((array) $consultaCompleta[0], (array) $relaciones);
                }
                
                return $consultas[] = (object) array_merge((array) $consulta, (array) $consultaCompleta[0]);
                
            } else { // Si es por cita extraemos la información de consulta_cita
                $_cita = new CitaModel();
                $cita = $_cita->where('cita_id', '=', $es_citada[0]->cita_id)->getFirst();

                $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
                if (count((array) $relaciones) > 0) {
                    $consultaCompleta = (object) array_merge((array) $consulta, (array) $relaciones);
                }
                return $consultas[] = (object) array_merge((array) $consulta, (array) $cita);
                
            }
        }
    }

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
}