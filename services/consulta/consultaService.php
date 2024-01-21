<?php

include_once "./services/medico/medicoHelpers.php";
include_once './services/globals/GlobalsHelpers.php';
include_once './services/consulta/consultaHelpers.php';
include_once './services/facturas/consulta/FacturaConsultaHelpers.php';

class ConsultaService {

    // variables para el inner join de consultas_sin cita
    protected static $selectConsultaSinCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "paciente.edad AS edad_paciente",
        "paciente.tipo_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellidos_medico",
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
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "paciente.edad AS edad_paciente",
        "paciente.tipo_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellidos_medico",
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
        "paciente.apellidos AS apellidos_paciente",
        "paciente.cedula",
        "paciente_beneficiado.paciente_beneficiado_id",
        "paciente.edad AS edad_beneficiado",
        "paciente.tipo_paciente",
    );

    protected static $innerPacienteBeneficiado = array(
        "paciente" => "paciente_beneficiado"
    );

    public static function insertarConsultaEmergencia($formulario) {
        
        ConsultaValidaciones::validarEsEmergencia($formulario);
        ConsultaValidaciones::validarConsultaEmergencia($formulario);
        
        $validarConsulta = new Validate;
        $consultaEmergencia = $validarConsulta->dataScape($formulario);
        
        $consulta_id = ConsultaHelper::insertarConsulta($consultaEmergencia, 'emergencia');
        $consultaEmergencia['consulta_id'] = $consulta_id;  

        $consultaSinCita = array(
            "consulta_id" => $consultaEmergencia['consulta_id'],
            "especialidad_id" => $formulario['especialidad_id'],
            "medico_id" => $formulario["medico_id"],
            "paciente_id" => $formulario["paciente_id"],
        );
        $consultaSinCitaModel = new ConsultaSinCitaModel();
        $consultaSinCitaModel->insert($consultaSinCita);

        if( isset($consultaEmergencia['pagos']) ) {
            ConsultaService::actualizarAcumuladoMedico($consultaEmergencia['pagos']);
        }
        
        // if (isset($formulario['examenes'])) {
            //     $formulario['consulta_id'] = $consulta_id;
        //     ConsultaHelper::insertarExamenesEmergencia($formulario);
        // }

        if (isset($formulario['insumos'])) {
            ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_id, true);
        }
        
        if (isset($formulario['recipes'])) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_id);
        }

        if (isset($formulario['indicaciones'])) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_id);
        }
        ConsultaHelper::insertarConsultaEmergencia($consultaEmergencia);

        return $consulta_id;
    }

    public static function insertarConsultaNormal($formulario, $consulta_separada) {

        $_consultaSinCita = new ConsultaSinCitaModel();
        $consulta_sin_cita = $_consultaSinCita->insert($consulta_separada[0]);
        
        if ($consulta_sin_cita == 0) {
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $consulta_separada[0]['consulta_id'])->delete();
            
            $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_sin_cita');
            return $respuesta->json(400);
        }

        if (isset($formulario['examenes'])) {
            ConsultaHelper::insertarExamen($formulario['examenes'], $consulta_separada[0]['consulta_id']);
        }
        
        if (array_key_exists('insumos', $formulario)) {
            ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_separada[0]['consulta_id'], false);
        }

        if (array_key_exists('indicaciones', $formulario)) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('recipes', $formulario)) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_separada[0]['consulta_id']);
        }
    }

    public static function insertarConsultaPorCita($formulario, $consulta_separada) {

        $_consultaConCita = new ConsultaCitaModel();
        $consulta_cita_id = $_consultaConCita->insert($consulta_separada[0]);
        
        if ($consulta_cita_id == 0) {
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $consulta_separada[0]['consulta_id'])->delete();

            $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_cita');
            return $respuesta->json(400);
        }

        $_citaModel = new CitaModel;
        $cita_previa = $_citaModel->where('cita_id', '=', $formulario['cita_id'])->getFirst();

        if ($cita_previa->tipo_cita == 1 && array_key_exists('examenes', $formulario)) {
            ConsultaHelper::insertarExamen($formulario['examenes'], $consulta_separada[0]['consulta_id']);
        }

        if ($cita_previa->tipo_cita == 2 && array_key_exists('examenes', $formulario)) {
            ConsultaHelper::insertarExamenesSeguro($formulario['examenes'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('insumos', $formulario)) {
        // if ($formulario['insumos']) {
            if ($cita_previa->tipo_cita == 1) {
                ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_separada[0]['consulta_id'], false);
            }

            if ($cita_previa->tipo_cita == 2) {
                ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_separada[0]['consulta_id'], true);
            }
        }

        if (array_key_exists('recipes', $formulario)) {
        // if ($formulario['recipes']) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('indicaciones', $formulario)) {
        // if ($formulario['indicaciones']) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_separada[0]['consulta_id']);
        }

        $respuesta = new Response('INSERCION_EXITOSA');

        $cambioEstatus = array('estatus_cit' => '4');
        $_citaModel = new CitaModel;
        $res = $_citaModel->where('cita_id', '=', $formulario['cita_id'])->update($cambioEstatus);
        $respuesta = new Response('INSERCION_EXITOSA');
        
        if ($res <= 0) {
            $respuesta->setData('La consulta fue insertada, pero la cita no fue actualizada correctamente, por favor actualicela manualmente para evitar errores');
        }
    }

    public static function actualizarAcumuladoMedico($formulario) {
        foreach ($formulario as $campo) {
            MedicoHelper::actualizarAcumulado($campo);
        }
    }

    public static function obtenerConsultaNormal($consulta) {
        $_consultaCita = new ConsultaCitaModel();
        $innersCita = $_consultaCita->listInner(ConsultaService::$innerConsultaCita);
        $es_citada = $_consultaCita->where('consulta_cita.consulta_id', '=', $consulta->consulta_id)
                                ->where('consulta.estatus_con','=',1)
                                ->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita");
        
        if (is_null($es_citada) || count($es_citada) == 0 ) { // Si no es por cita, extraemos la información de consulta_sin_cita

            $_consultaSinCita = new ConsultaSinCitaModel();
            $innersConsulta = $_consultaSinCita->listInner(ConsultaService::$innerConsultaSinCita);
            $consultaCompleta = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                                ->innerJoin(ConsultaService::$selectConsultaSinCita, $innersConsulta, "consulta_sin_cita");

            $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
            
            if (count((array) $relaciones) > 0) {
                $consultaCompleta[0] = (object) array_merge((array) $consultaCompleta[0], (array) $relaciones);
            }
            
            return $consultas[] = (object) array_merge((array) $consulta, (array) $consultaCompleta[0]);
            
        } else { // Si es por cita extraemos la información de consulta_cita
            $_cita = new CitaModel();
            $innersCita = $_consultaCita->listInner(ConsultaService::$innerConsultaCita);
            $cita = $_cita->where('cita.cita_id', '=', $es_citada[0]->cita_id)->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita")[0];

            $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
            if (count((array) $relaciones) > 0) {
                $consultaCompleta = (object) array_merge((array) $consulta, (array) $relaciones);
            }
            return $consultas[] = (object) array_merge((array) $consulta, (array) $cita);
            
        }
    }

    public static function obtenerConsultaEmergencia($consulta) {
        
        $selectInner = array(
            "medico.medico_id",
            "medico.nombre AS nombre_medico",
            "medico.apellidos AS apellidos_medico",
            "medico.cedula AS cedula",
            "especialidad.especialidad_id",
            "especialidad.nombre AS nombre_especialidad"
        );

        $inner = array(
            "medico" => "consulta_sin_cita",
            "especialidad" => "consulta_sin_cita"
        );

        $_consultaSinCita = new ConsultaSinCitaModel();
        $innersConsulta = $_consultaSinCita->listInner($inner);
        $consultaSinCita = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                            ->innerJoin($selectInner, $innersConsulta, "consulta_sin_cita");

        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $consultaEmergencia = $_consultaEmergencia->where('consulta_id','=', $consulta->consulta_id)->getFirst();
        
        $_paciente = new PacienteModel();
        $paciente = $_paciente->where('paciente_id','=', $consultaEmergencia->paciente_id)->getFirst();

        $_pacienteModel = new PacienteModel();
        $beneficiado = $_pacienteModel->where('cedula', '=', $consultaEmergencia->cedula_beneficiado)->getFirst();
        
        $consultas = $consulta;
        $consultas->medico = $consultaSinCita;
        $consultas->paciente_id = $consultaEmergencia->paciente_id;
        $consultas->factura = $consultaEmergencia;
        $consultas->titular = $paciente;
        $consultas->beneficiado = $beneficiado;

        $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
        // var_dump($consulta->consulta_id);
        // var_dump(property_exists($relaciones, 'examenes'));

        // if ( property_exists($relaciones, 'examenes') || property_exists($relaciones, 'insumos') ) {

        //     // if ( property_exists($relaciones, 'examenes') ) {
        //     //     unset($relaciones->examenes);
        //     // }
            
        //     // if ( property_exists($relaciones, 'insumos') ) {
        //     //     unset($relaciones->insumos);
        //     // }

        //     $consulta_examenes_insumos = FacturaConsultaHelpers::obtenerMontoTotal((Array) $consultas);
        //     // No recuerdo muy bien que hacia la línea de arriba
        //     echo '<pre>'; var_dump($consulta_examenes_insumos);
        //     $relaciones = array_merge((array) $relaciones, (array) $consulta_examenes_insumos);
        // }
        // var_dump($relaciones);

        // echo '<pre>'; var_dump($consultas);

        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
        $consultas->factura->consultas_medicas_bs = round( $consultas->factura->consultas_medicas * $valorDivisa, 2);
        $consultas->factura->laboratorios_bs = round( $consultas->factura->laboratorios * $valorDivisa, 2);
        $consultas->factura->medicamentos_bs = round( $consultas->factura->medicamentos * $valorDivisa, 2);
        $consultas->factura->area_observacion_bs = round( $consultas->factura->area_observacion * $valorDivisa, 2);
        $consultas->factura->enfermeria_bs = round( $consultas->factura->enfermeria * $valorDivisa, 2);
        $consultas->factura->total_insumos_bs = round( $consultas->factura->total_insumos * $valorDivisa, 2);
        $consultas->factura->total_examenes_bs = round( $consultas->factura->total_examenes * $valorDivisa, 2);
        $consultas->factura->total_consulta_bs = round( $consultas->factura->total_consulta * $valorDivisa, 2);

        if (count((array) $relaciones) > 0) {
            return (object) array_merge((array) $consultas, (array) $relaciones);
        } else {
            return $consultas;
        }
    }

    public static function obtenerConsultaPorCita($paciente_id) {
        $_citaModel = new CitaModel();
        $innersCita = $_citaModel->listInner(ConsultaService::$innerConsultaCita);
        $cita = $_citaModel->where('cita.paciente_id', '=', $paciente_id)
                                ->where('consulta.estatus_con','!=',2)
                                ->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita");

        return $cita;
    }
}