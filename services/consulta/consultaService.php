<?php

include_once "./services/medico/medicoHelpers.php";

class ConsultaService {

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

    public static function insertarConsulta($formulario, $separar) {
        $consulta = "";

        if ($separar == 'emergencia') {
            $consulta = array(
                "observaciones" => isset($formulario["observaciones"]) ? $formulario["observaciones"] : null,
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

        $total_consulta = $formulario['consultas_medicas'] + $formulario['laboratorios'] + $formulario['medicamentos'] + $formulario['area_observacion'] + $formulario['enfermeria'];
        $formulario['total_consulta'] = $total_consulta;

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
            $cita = $_cita->where('cita_id', '=', $es_citada[0]->cita_id)->getFirst();

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

        $_pacienteBeneficiado = new PacienteBeneficiadoModel();
        $innersPaciente = $_pacienteBeneficiado->listInner(ConsultaService::$innerPacienteBeneficiado);
        $beneficiado = $_pacienteBeneficiado->where('paciente_beneficiado.paciente_beneficiado_id', '=', $consultaEmergencia->paciente_beneficiado_id)
                                ->where('paciente_beneficiado.estatus_pac','=',1)
                                ->innerJoin(ConsultaService::$selectPacienteBeneficiado, $innersPaciente, "paciente_beneficiado");

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
    }
}