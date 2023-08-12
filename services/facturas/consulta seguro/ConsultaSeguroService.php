<?php

include_once "./services/facturas/consulta seguro/ConsultaSeguroHelpers.php";

class ConsultaSeguroService {

    protected $selectConsultas = array(
        "consulta_seguro.consulta_seguro_id",
        "consulta_seguro.consulta_id",
        "consulta_seguro.tipo_servicio",
        "consulta_seguro.fecha_ocurrencia AS fecha_factura",
        "consulta_seguro.monto",
        "consulta_seguro.estatus_con",
        "consulta.observaciones",
        "consulta.fecha_consulta",
        "consulta.es_emergencia"
    );

    protected $innerConsulta = array(
        "consulta" => "consulta_seguro",
    );

    protected $selectCitas = array(
        "consulta_cita.consulta_cita_id",
        "consulta_cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.cedula_titular",
        "cita.tipo_cita",
        "paciente.nombre AS nombre_beneficiado",
        "paciente.cedula AS cedula_beneficiado",
        "paciente.telefono AS telefono_beneficiado",
        "paciente.direccion AS direccion_beneficiado",
        "paciente.fecha_nacimiento AS nacimiento_beneficiado",
        "medico.nombre AS nombre_medico",
        "especialidad.nombre nombre_especialidad"
    );

    protected $innerCita = array(
        "cita" => "consulta_cita",
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita"
    );

    /**
     * Función para colocar como pagada una consulta
     */
    public static function actualizarEstatusConsulta ($consulta_id) {
        $_consulta = new ConsultaModel();
        $update = $_consulta->where('consulta_id', '=', $consulta_id )->update(['estatus_con' => 3]);
        $isUpdate = ($update > 0);

        // Si hubo un error cambiando el estatus de la consulta, borramos la factura relacionada a ella
        if (!$isUpdate) {
            $_consultaSeguroModel = new ConsultaSeguroModel();
            $_consultaSeguroModel->where('consulta_seguro_id', '=', $consulta_id)->delete();

            $respuesta = new Response(false, 'Hubo un error actualizando el estatus de la consulta');
            $respuesta->setData('Error al colocar la consulta id '.$consulta_id.' como cancelada');
            echo $respuesta->json(400);
            exit();
        }
        
    }

    /**
     * Función para insertar la factura de una consulta por emergencia
     */
    public static function insertarConsultaEmergencia($formulario) {

        $_consultaEmergenciaModel = new ConsultaEmergenciaModel();
        $consultaEmergencia = $_consultaEmergenciaModel->where('consulta_id', '=', $formulario['consulta_id'])->getFirst();

        $formulario['seguro_id'] = $consultaEmergencia->seguro_id;
        $formulario['monto'] = $consultaEmergencia->total_consulta;

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $fueInsertado = $_consultaSeguroModel->insert($formulario);

        if ($fueInsertado <= 0) {
            $respuesta = new Response('INSERCION_FALLIDA');
            $respuesta->setData('Ocurrió un error insertando la factura');
            echo $respuesta->json(400);
            exit();
        }
    }

    public static function listarConsultasSeguros() {

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $consultasSeguros = $_consultaSeguroModel->where('estatus_con', '!=', 2)->getAll();
        $listaConsultas = [];

        if (count($consultasSeguros) > 0) {
            foreach ($consultasSeguros as $consulta) {
            
                $_consultaCita = new ConsultaCitaModel();
                $consulta_cita = $_consultaCita->where('consulta_id', '=', $consulta->consulta_id)->getFirst();
    
                if (is_null($consulta_cita)) {
                    $listaConsultas[] = ConsultaSeguroHelpers::obtenerInformacionEmergencia($consulta);
                } else {
                    $listaConsultas[] = ConsultaSeguroHelpers::obtenerInformacionCita($consulta);
                }
            }
        }
        return $listaConsultas;
    }

}