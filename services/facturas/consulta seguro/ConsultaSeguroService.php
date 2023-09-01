<?php

include_once "./services/facturas/consulta seguro/ConsultaSeguroHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";

class ConsultaSeguroService {

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
        $formulario['monto_consulta'] = $consultaEmergencia->total_consulta;

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
        $listaConsultas = ConsultaSeguroHelpers::obtenerInformacionCompleta($consultasSeguros);
        $consultas = [];

        foreach ($listaConsultas as $consulta) {
            
            if ( isset( $consulta['consulta_emergencia'] ) ) { // Si es por emergencia
                $consultas[] = ConsultaSeguroHelpers::calcularConsultaEmergencia($consulta);

            } else { // Si no es consulta por emergencia
                $consultas[] = FacturaConsultaHelpers::obtenerMontoTotal($consulta);
            }
            
        }
        
        return $consultas;
    }

    public static function listarConsultasPorSeguroYMes($seguro_id, $mes, $anio) {

        $_consultaSeguroModel = new ConsultaSeguroModel();
        $consultasSeguros = $_consultaSeguroModel->where('estatus_con', '!=', 2)
                                                ->where('seguro_id', '=', $seguro_id)
                                                ->where('YEAR(fecha_ocurrencia)',"=",$anio)->where('MONTH(fecha_ocurrencia)', '=', $mes)
                                                // ->whereDate('fecha_ocurrencia', $primer_dia, $ultimo_dia)
                                                ->getAll();
        
        return ConsultaSeguroHelpers::obtenerInformacionCompleta($consultasSeguros);
    }

}