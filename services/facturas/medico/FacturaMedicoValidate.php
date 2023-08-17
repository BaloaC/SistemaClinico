<?php

class FacturaMedicoValidate {

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
}