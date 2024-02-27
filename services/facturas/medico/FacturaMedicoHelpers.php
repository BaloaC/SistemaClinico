<?php

include_once './services/globals/GlobalsHelpers.php';

class FacturaMedicoHelpers {

    public static function contabilizarFacturasAseguradas($form, $fechas) {
        // Facturas por consultas aseguradas
        $selectConsultas = array(
            "consulta_seguro.consulta_id",
            "consulta_seguro.monto_consulta_usd",
            "consulta_seguro.seguro_id",
            "consulta_cita.cita_id",
            "consulta.fecha_consulta",
            "cita.medico_id"
        );

        $innerConsulta = array(
            "cita" => "consulta_cita",
            "consulta" => "consulta_seguro",
        );

        $innerConsultaCustom = array('consulta_cita', 'consulta', 'consulta_seguro');
        $_facturaConsultaModel = new FacturaConsultaModel();

        $innersConsulta = $_facturaConsultaModel->listInner($innerConsulta, $innerConsultaCustom);
        $consultas_aseguradas = $_facturaConsultaModel->where('cita.medico_id', '=', $form['medico_id'])
            ->where('consulta_seguro.estatus_con', '!=', 2)
            ->whereDate('consulta_seguro.fecha_ocurrencia', $fechas['fecha_inicio'], $fechas['fecha_fin'])
            ->innerJoin($selectConsultas, $innersConsulta, "consulta_seguro");

        $calculos['monto_pago'] = 0;
        $calculos['pacientes'] = 0;
        $calculos['monto_total_consulta'] = 0;
        
        if (!is_null($consultas_aseguradas) && count($consultas_aseguradas) > 0) {
            foreach ($consultas_aseguradas as $consulta) {

                $_seguroModel = new SeguroModel();
                $seguro = $_seguroModel->where('seguro_id', '=', $consulta->seguro_id)->getFirst();

                $calculos['monto_total_consulta'] += $consulta->monto_consulta_usd;
                $calculos['monto_pago'] += $consulta->monto_consulta_usd * $seguro->porcentaje / 100;
                $calculos['pacientes'] += 1;
            }
        }
        
        return $calculos;
    }

    public static function contabilizarFacturasAseguradasAll($fechas){
        // Facturas por consultas aseguradas
        $selectConsultas = array(
            "consulta_seguro.consulta_id",
            "consulta_seguro.monto_consulta_usd",
            "consulta_seguro.seguro_id",
            "consulta_cita.cita_id",
            "consulta.fecha_consulta",
            "cita.medico_id"
        );

        $innerConsulta = array(
            "cita" => "consulta_cita",
            "consulta" => "consulta_seguro",
        );

        $innerConsultaCustom = array('consulta_cita', 'consulta', 'consulta_seguro');
        $_facturaConsultaModel = new FacturaConsultaModel();

        
        $innersConsulta = $_facturaConsultaModel->listInner($innerConsulta, $innerConsultaCustom);
        $consultas_aseguradas = $_facturaConsultaModel->where('consulta_seguro.estatus_con', '!=', 2)
            ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
            ->innerJoin($selectConsultas, $innersConsulta, "consulta_seguro");

        return $consultas_aseguradas;
    }

    public static function contabilizarFacturasNormales($form, $fechas) {

        // Facturas por consultas naturales
        $selectConsultas = array(
            // "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            "factura_consulta.monto_consulta_usd",
            "consulta_sin_cita.medico_id"
        );

        $innerConsulta = array(
            "consulta" => "factura_consulta",
        );

        $innerConsultaCustom = array('consulta_sin_cita', 'consulta', 'factura_consulta');
        $_facturaConsultaModel = new FacturaConsultaModel();

        $innersConsulta = $_facturaConsultaModel->listInner($innerConsulta, $innerConsultaCustom);
        $consultas_normales = $_facturaConsultaModel->where('consulta_sin_cita.medico_id', '=', $form['medico_id'])
            ->where('factura_consulta.estatus_fac', '!=', 2)
            ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
            ->innerJoin($selectConsultas, $innersConsulta, "factura_consulta");

        $calculosSinCitas = FacturaMedicoHelpers::calculosConsultas($consultas_normales);
        
        // Facturas por citas naturales
        $selectCitas = array(
            "cita.medico_id",
            "consulta_cita.cita_id",
            "consulta_cita.consulta_id"
        );

        $innerCitaCustom = array('consulta_cita', 'cita', 'cita');
        $_citaModel = new FacturaConsultaModel();
        $innersCita = $_citaModel->listInner(null, $innerCitaCustom);
        $consultas_con_citas = $_citaModel->where('cita.medico_id', '=', $form['medico_id'])->innerJoin($selectCitas, $innersCita, "cita");
        $facturas_consultas_citas = [];
        
        foreach ($consultas_con_citas as $cita) {

            $selectFactura = array(
                "factura_consulta.consulta_id",
                "factura_consulta.monto_consulta_usd",
                "consulta.fecha_consulta"
            );

            $innerFactura = array(
                "consulta" => "factura_consulta",
            );

            $_facturaConsulta = new FacturaConsultaModel();
            $innersFactura = $_facturaConsulta->listInner($innerFactura);
            $factura = $_facturaConsulta->where('factura_consulta.consulta_id', '=', $cita->consulta_id)
                                        ->where('factura_consulta.estatus_fac', '!=', 2)
                                        ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
                                        ->innerJoin($selectFactura, $innersFactura, "factura_consulta");
            
            if ($factura != null) {
                $facturas_consultas_citas[] = $factura[0];
            }
        }
        
        $calculosConCitas = FacturaMedicoHelpers::calculosConsultas($facturas_consultas_citas);
        echo '<pre>'; var_dump($facturas_consultas_citas);
        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $form['medico_id'])->getFirst();

        $calculos = Array(
            "monto_total_consultas" => $calculosSinCitas['monto_total_consulta'] + $calculosConCitas['monto_total_consulta'],
            "monto_pago" => $calculosSinCitas['monto'] + $calculosConCitas['monto'],
            "pacientes" => $calculosSinCitas['pacientes'] + $calculosConCitas['pacientes'],
            "acumulado" => $medico->acumulado
        );

        return $calculos;        
    }

    public static function calculosConsultas($consultas_normales) {
        $calculos['monto'] = 0;
        $calculos['pacientes'] = 0;
        $calculos['monto_total_consulta'] = 0;

        if (count($consultas_normales) > 0) {

            foreach ($consultas_normales as $consulta) {
                $calculos['monto_total_consulta'] += $consulta->monto_consulta_usd;
                $calculos['pacientes'] += 1;
            }

            $porcentaje_medico = GlobalsHelpers::obtenerPorcentajeMedico();
            $calculos['monto'] = $calculos['monto_total_consulta'] * $porcentaje_medico / 100;
        }

        return $calculos;
    }

    public static function contabilizarFacturasNormalesAll($fechas){
        
        // Facturas por consultas naturales
        $selectConsultas = array(
            // "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            "factura_consulta.monto_consulta_usd",
            "consulta_sin_cita.medico_id"
        );

        $innerConsulta = array(
            "consulta" => "factura_consulta",
        );

        $innerConsultaCustom = array('consulta_sin_cita', 'consulta', 'factura_consulta');
        $_facturaConsultaModel = new FacturaConsultaModel();

        $innersConsulta = $_facturaConsultaModel->listInner($innerConsulta, $innerConsultaCustom);
        
        $consultas_normales = $_facturaConsultaModel->where('factura_consulta.estatus_fac', '!=', 2)
            ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
            ->innerJoin($selectConsultas, $innersConsulta, "factura_consulta");

        return $consultas_normales;
    }

    public static function reiniciarAcumuladoMedico($medico_id) {
        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $medico_id)->update(array("acumulado" => 0));
    }

    public static function calcularMontosBs($factura) {
        $valor_divisa = GlobalsHelpers::obtenerValorDivisa();
        $valor_multiplicar = $factura->precio_dolar == 0 ? $valor_divisa : $factura->precio_dolar;
        $factura_bs = array(
            "acumulado_seguro_total_bs" => round($factura->acumulado_seguro_total * $valor_multiplicar, 2),
            "acumulado_consulta_total_bs" => round($factura->acumulado_consulta_total * $valor_multiplicar, 2),
            "sumatoria_consultas_aseguradas_bs" => round($factura->sumatoria_consultas_aseguradas * $valor_multiplicar, 2),
            "sumatoria_consultas_naturales_bs" => round($factura->sumatoria_consultas_naturales * $valor_multiplicar, 2),
            "acumulado_medico_bs" => round($factura->acumulado_medico * $valor_multiplicar, 2),
            "pago_total_bs" => round($factura->pago_total * $valor_multiplicar, 2)
        );

        return array_merge((array) $factura, $factura_bs);
    }

    public static function retornarMensaje($booleano) {
        $esTrue = ($booleano > 0);

        $respuesta = new Response($esTrue ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($booleano);
        echo $respuesta->json(200);
        exit();
    }
}
