<?php

class FacturaMedicoValidate {

    /**
     * Funciones para las validaciones del solicitar factura
     */
    public static function validacionesPrincipales($formulario) {
        $validarFactura = new Validate;

        if ( $validarFactura->isEmpty($formulario) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarFactura->isDate($formulario['fecha_actual']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            echo $respuesta->json(200);
            exit();
        }

        if ( !$validarFactura->isToday($formulario['fecha_actual'], true) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            echo $respuesta->json(200);
            exit();
        }
    }

    /**
     * Función para las validaciones generales de la factura medico
     */
    public static function validateGeneral($formulario) {
        $validarFactura = new Validate;
        
        switch ($validarFactura) {

            case !($validarFactura->isDuplicated('medico', 'medico_id', $formulario['medico'])):
                $respuesta = new Response('MD_NOT_FOUND');
                echo $respuesta->json(200);
                exit();

            case $validarFactura->isDate($formulario['fecha']):
                $respuesta = new Response('FECHA_INVALIDA');
                echo $respuesta->json(400);
                exit();
        }
    }

    /**
     * Función para validar el cuerpo del insert Facturas
     */
    public static function validateInsertMedico($formulario) {
        $validarFactura = new Validate;
        $camposId = array('medico_id');
        
        if( !$validarFactura->isDuplicated('medico', 'medico_id', $formulario['medico_id'])) {
            $respuesta = new Response('MD_NOT_FOUND');
            echo $respuesta->json(200);
            exit();
        }

        unset($formulario['medico_id']);

        foreach ($formulario as $input) {
            if ( !is_numeric($input) || $input < 0 ) {
                $respuesta = new Response(false, 'Todos los campos deben ser numéricos');
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function validarFacturaMes($formulario) {

        $fecha_mes = new DateTime($formulario['fecha_actual']);
        // $fecha_mes->modify('first day of this month');
        // $primer_dia = $fecha_mes->format('Y-m-d H:i:s');
        
        // $fecha_mes->modify('last day of this month');
        // $ultimo_dia = $fecha_mes->format('Y-m-d H:i:s');
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $factura = $_facturaMedicoModel->where('medico_id', '=', $formulario['medico_id'])
                                    ->where('YEAR(fecha_emision)',"=", date('Y', strtotime($formulario['fecha_actual'])) )
                                    ->where('MONTH(fecha_emision)', '=', date('m', strtotime($formulario['fecha_actual'])) )
                                    // ->whereDate('fecha_pago',$primer_dia, $ultimo_dia)
                                    ->getFirst();

        if (is_null($factura)) {
            return false;
        } else {
            return $factura;
        }
    }
}