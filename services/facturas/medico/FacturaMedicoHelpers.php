<?php

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
                                                    ->where('consulta_seguro.estatus_con','!=',2)
                                                    ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
                                                    ->innerJoin($selectConsultas, $innersConsulta, "consulta_seguro");

        $calculos['monto'] = 0; $calculos['pacientes'] = 0;
        
        if ( !is_null($consultas_aseguradas) && count($consultas_aseguradas) > 0) {
            foreach ($consultas_aseguradas as $consulta) {

                $_seguroModel = new SeguroModel();
                $seguro = $_seguroModel->where('seguro_id', '=', $consulta->seguro_id)->getFirst();
                
                $calculos['monto'] += $consulta->monto * $seguro->porcentaje / 100;
                $calculos['pacientes'] += 1;
            }
        }
        
        return $calculos;
    }

    public static function contabilizarFacturasNormales($form, $fechas) {
        
        // Facturas por consultas naturales
        $selectConsultas = array(
            // "factura_consulta.factura_consulta_id",
            "factura_consulta.consulta_id",
            "factura_consulta.monto_consulta",
            "consulta_sin_cita.medico_id"
        );

        $innerConsulta = array(
            "consulta" => "factura_consulta",
        );

        $innerConsultaCustom = array('consulta_sin_cita', 'consulta', 'factura_consulta');
        $_facturaConsultaModel = new FacturaConsultaModel();

        $innersConsulta = $_facturaConsultaModel->listInner($innerConsulta, $innerConsultaCustom);
        $consultas_normales = $_facturaConsultaModel->where('consulta_sin_cita.medico_id', '=', $form['medico_id'])
                                                    ->where('factura_consulta.estatus_fac','!=',2)
                                                    ->whereDate('consulta.fecha_consulta', $fechas['fecha_inicio'], $fechas['fecha_fin'])
                                                    ->innerJoin($selectConsultas, $innersConsulta, "factura_consulta");

        $calculos['monto'] = 0; $calculos['pacientes'] = 0;

        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $form['medico_id'])->getFirst();
        
        if ( count($consultas_normales) > 0) {

            foreach ($consultas_normales as $consulta) {
                $calculos['monto'] += $consulta->monto_consulta;
                $calculos['pacientes'] += 1;
            }

            // $_globalModel = new GlobalModel();
            // $porcentaje_medico = $_globalModel->where('key', '=', 'porcentaje_medico')->getFirst();
            // $calculos['monto'] = $calculos['monto'] * $porcentaje_medico->value / 100;
        }

        $calculos['monto'] += $medico->acumulado;
        
        return $calculos;
    }

    public static function reiniciarAcumuladoMedico($medico_id) {
        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $medico_id)->update(array("acumulado" => 0));
    }

    public static function retornarMensaje($booleano) {
        $esTrue = ($booleano > 0);

        $respuesta = new Response($esTrue ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($booleano);
        echo $respuesta->json(200);
        exit();
    }
}