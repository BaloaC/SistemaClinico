<?php

include_once "./services/facturas/medico/FacturaMedicoHelpers.php";

class FacturaMedicoService {

    public static function contabilizarFactura($formulario) {

        $fechas = [];

        // Obtenemos el primer y último día del mes
        $fecha_mes = DateTime::createFromFormat('Y-m-d', $formulario['fecha_actual']);
        $fecha_mes->modify('first day of this month');
        $fechas['fecha_inicio'] = $fecha_mes->format("Y-m-d");
        
        $fecha_mes->modify('last day of this month');
        $fechas['fecha_fin'] = $fecha_mes->format("Y-m-d");

        $consultas_normales = FacturaMedicoHelpers::contabilizarFacturasNormales($formulario, $fechas);
        $consultas_aseguradas = FacturaMedicoHelpers::contabilizarFacturasAseguradas($formulario, $fechas);

        $factura = array(
            "medico_id" => $formulario['medico_id'],
            "acumulado_seguro_total" => $consultas_aseguradas['monto'],
            "acumulado_consulta_total" => $consultas_normales['monto'],
            "pacientes_seguro" => $consultas_aseguradas['pacientes'],
            "pacientes_consulta" => $consultas_normales['pacientes'],
            "pago_total" => $consultas_aseguradas['monto'] + $consultas_normales['monto']
        );

        return $factura;
    }
}