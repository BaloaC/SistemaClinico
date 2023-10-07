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
        "paciente_beneficiado.paciente_beneficiado_id"
    );

    protected static $innerPacienteBeneficiado = array(
        "paciente" => "paciente_beneficiado"
    );

    public static function insertarConsulta($formulario, $separar) {
        $consulta = "";

        if ($separar == 'emergencia') {
            $consulta = array(
                "observaciones" => isset($formulario["observaciones"]) ? $formulario["observaciones"] : null,
                "peso" => isset($formulario["peso"]) ? $formulario["peso"] : null,
                "altura" => isset($formulario["altura"]) ? $formulario["altura"] : null,
                "fecha_consulta" => $formulario["fecha_consulta"],
                "es_emergencia" => $formulario["es_emergencia"]
            );
        }

        $_consultaModel = new ConsultaModel();
        $id = $_consultaModel->insert($consulta);

        if ($id > 0) {
            return $id;
        } else {
            $respuesta = new Response('INSERCION_FALLIDA');
            $respuesta->setData($consulta);
            return $respuesta->json(400);
        }
    }

    public static function insertarConsultaEmergencia($formulario) {
        $_consultaEmergencia = new ConsultaEmergenciaModel();

        $formulario['total_examenes'] = 0;
        $formulario['total_examenes_bs'] = 0;
                
        if ( isset($formulario['examenes']) ) {
            $formulario = ConsultaHelper::insertarExamenesEmergencia($formulario);
            unset($formulario['examenes']);
        }
        
        $total_consulta = $formulario['consultas_medicas'] + $formulario['laboratorios'] + $formulario['medicamentos'] + $formulario['area_observacion'] 
                        + $formulario['enfermeria']; + $formulario['total_insumos'] + $formulario['total_examenes'];
        $formulario['total_consulta'] = $total_consulta;

        // Calculamos los montos en bolívares
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

        $formulario['consultas_medicas_bs'] = 0;
        $formulario['laboratorios_bs'] = 0;
        $formulario['medicamentos_bs'] = 0;
        $formulario['area_observacion_bs'] = 0;
        $formulario['enfermeria_bs'] = 0;
        $formulario['total_insumos_bs'] = 0;
        $formulario['total_examenes_bs'] = 0;
        $formulario['total_consulta_bs'] = 0;

        // $formulario['consultas_medicas_bs'] = round( $formulario['consultas_medicas'] * $valorDivisa, 2);
        // $formulario['laboratorios_bs'] = round( $formulario['laboratorios'] * $valorDivisa, 2);
        // $formulario['medicamentos_bs'] = round( $formulario['medicamentos'] * $valorDivisa, 2);
        // $formulario['area_observacion_bs'] = round( $formulario['area_observacion'] * $valorDivisa, 2);
        // $formulario['enfermeria_bs'] = round( $formulario['enfermeria'] * $valorDivisa, 2);
        // $formulario['total_insumos_bs'] = round( $formulario['total_insumos'] * $valorDivisa, 2);
        // $formulario['total_examenes_bs'] = round($formulario['total_examenes_bs'], 2);
        // $formulario['total_consulta_bs'] = round( $formulario['total_consulta'] * $valorDivisa, 2);
        
        $fueInsertado = $_consultaEmergencia->insert($formulario); 

        if ($fueInsertado <= 0) {
            $respuesta = new Response('INSERCION_FALLIDA');
            $respuesta->setData($formulario);
            echo $respuesta->json(400);
            exit();
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
        
        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $consultaEmergencia = $_consultaEmergencia->where('consulta_id','=', $consulta->consulta_id)->getFirst();
        
        $_paciente = new PacienteModel();
        $paciente = $_paciente->where('paciente_id','=', $consultaEmergencia->paciente_id)->getFirst();

        $_pacienteModel = new PacienteModel();
        $beneficiado = $_pacienteModel->where('cedula', '=', $consultaEmergencia->cedula_beneficiado)->getFirst();
        
        $consultas = $consulta;
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
}