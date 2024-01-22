<?php

include_once './services/facturas/seguro/FacturaSeguroHelpers.php';
include_once './services/facturas/seguro/FacturaSeguroService.php';
include_once './services/facturas/consulta seguro/ConsultaSeguroHelpers.php';
include_once './services/facturas/consulta/FacturaConsultaHelpers.php';
include_once './services/globals/GlobalsHelpers.php';

class FacturaSeguroService {

    /**
     * Función para calcular facturas por seguro
     */
    public static function calcularFactura($seguro_id, $mes, $anio) {
        
        $facturaList = [];
        $consultaList = FacturaSeguroHelpers::innerFacturaSeguro($seguro_id, $mes, $anio);
        // echo '<pre>';
        // Por cada factura en consulta, sumamos el monto para obtener el total
        $monto_consulta_bs = 0;
        $monto_consulta_usd = 0;
        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();

        if (count($consultaList) > 0) {
            foreach ($consultaList as $consulta) {
                // var_dump($consulta);

                $_consultaEmergencia = new ConsultaEmergenciaModel();
                $esEmergencia = $_consultaEmergencia->where('consulta_id', '=', $consulta->consulta_id)->getFirst();
                // var_dump($esEmergencia);
                if ($esEmergencia) {
                    $monto_consulta_usd += $esEmergencia->total_consulta;

                    if ($esEmergencia->total_consulta_bs == 0) {
                        $monto_consulta_bs += round($esEmergencia->total_consulta * $valorDivisa, 2);
                    } else {
                        $monto_consulta_bs = $esEmergencia->total_consulta_bs;
                    }

                } else {

                    $examenes = FacturaConsultaHelpers::obtenerExamenes($consulta);
                    if (!is_null($examenes) && count($examenes) > 0) {
                        $consulta->examenes = $examenes["examenes"];
                    }
    
                    $insumos = FacturaConsultaHelpers::obtenerInsumos($consulta);
                    if (!is_null($insumos) && count($insumos) > 0) {
                        $consulta->insumos = $insumos["insumos"];
                    }
                    
                    $consultaCalculada = FacturaConsultaHelpers::obtenerMontoTotal((array) $consulta);
                    $monto_consulta_usd += $consultaCalculada['monto_total_usd'];
    
                    if ($consultaCalculada['monto_total_bs'] == 0) {
                        $monto_consulta_bs += $consultaCalculada['monto_total_usd'] * $valorDivisa;
    
                    } else {
                        $monto_consulta_bs += $consultaCalculada['monto_total_bs'];
                    }
                }
            }
        }
        
        // Le sumamos 1 mes a la fecha de hoy
        // $fecha_actual = date("Y-m-d"); 
        $primerDiaDelMes = date("Y-m-01");
        $fecha_vencimiento = strtotime('+1 month', strtotime($primerDiaDelMes));
        $fecha_vencimiento = date('Y-m-d', $fecha_vencimiento);
        
        // date_default_timezone_set("America/Caracas");
        setlocale(LC_TIME, 'es_VE.UTF-8','esp');

        $facturaList = [
            "seguro_id" => $seguro_id,
            "fecha_vencimiento" => "$fecha_vencimiento",
            "monto_bs" => round( $monto_consulta_bs, 2 ),
            "monto_usd" => $monto_consulta_usd,
            "mes" => strftime("%B")
        ];

        return $facturaList;
    }

    public static function listarFacturaId($factura_seguro_id) {

        $_facturaSeguroModel = new FacturaSeguroModel();
        $factura = $_facturaSeguroModel->where('factura_seguro.factura_seguro_id', '=', $factura_seguro_id)->getFirst();
        
        // Obtenemos las fechas
        $fechaVencimiento = $factura->fecha_vencimiento;
        $fechaOcurrencia = strtotime('-1 month', strtotime($fechaVencimiento));
        $fechaOcurrencia = date('Y-m-d', $fechaOcurrencia);

        $mes = date("m", strtotime($fechaOcurrencia));
        $anio = date("Y", strtotime($fechaOcurrencia));
        
        $consultaList = FacturaSeguroHelpers::innerFacturaSeguro($factura->seguro_id, $mes, $anio);
        
        if ( count($consultaList) > 0 ) {
            $consultas = ConsultaSeguroHelpers::obtenerInformacionCompleta($consultaList);
            $facturas = [];
            $facturas['consultas'] = [];
            $consultas_pagadas = 0;
            $consultas_no_pagadas = 0;

            foreach ($consultas as $consulta) {
                if ($consulta["estatus_con"] == 3) {
                    $consultas_pagadas += 1;
                } else {
                    $consultas_no_pagadas += 1;
                }

                if ( isset( $consulta['consulta_emergencia'] ) ) { // Si es por emergencia
                    $facturas['consultas'][] = $consulta;
    
                } else { // Si no es consulta por emergencia
                    $facturas['consultas'][] = FacturaConsultaHelpers::obtenerMontoTotal($consulta);
                }
            }

            $facturas['consultas_pagadas'] = $consultas_pagadas; $facturas['consultas_no_pagadas'] = $consultas_no_pagadas;
            return FacturaSeguroHelpers::retornarMensaje($facturas);

        } else {
            $respuesta = new Response(false, "No hay consultas en el mes de $factura->mes para la factura indicada");
            $respuesta->setData("Error con la factura id $factura->factura_seguro_id");
            echo $respuesta->json(200);
            exit();
        }
    }

    public static function actualizarEstatus($factura_seguro_id) {
        $_facturaSeguro = new FacturaSeguroModel();
        $factura_seguro = $_facturaSeguro->where('factura_seguro_id', '=', $factura_seguro_id)->getFirst();

        FacturaSeguroValidaciones::validarEstatusFactura($factura_seguro);

        $data = array(
            'estatus_fac' => '3'
        );
        
        $actualizado = $_facturaSeguro->where('factura_seguro_id', '=', $factura_seguro_id)->update($data);
        
        $isTrue = ($actualizado > 0);
        $respuesta = new Response($isTrue ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($isTrue ? 200 : 400);
    }
}