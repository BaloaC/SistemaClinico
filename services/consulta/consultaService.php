<?php

include_once "./services/medico/medicoHelpers.php";

class ConsultaService {

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
}