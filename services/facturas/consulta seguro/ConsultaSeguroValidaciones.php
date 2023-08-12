<?php

class ConsultaSeguroValidaciones {

    /**
     * Validaciones básicas de consulta_seguro
     */
    public static function validarConsultaSeguro($formulario) {
        $validarConsulta = new Validate;
        $camposNumericos = array('monto');
        $camposId = array('consulta_id');

        switch ($validarConsulta) {
            case ($validarConsulta->isEmpty($formulario)):
                $respuesta = new Response('DATOS_VACIOS');
                echo $respuesta->json(400);
                exit();

            case $validarConsulta->isNumber($formulario, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                echo $respuesta->json(400);
                exit();

            case !$validarConsulta->existsInDB($formulario, $camposId):
                $respuesta = new Response('NOT_FOUND');
                echo $respuesta->json(200);
                exit();

            case $validarConsulta->isDuplicatedId('consulta_id', 'estatus_con', $formulario['consulta_id'], '3', 'consulta'):
            // case $validarConsulta->isDuplicated('consulta', 'estatus_con', '3'):
                $respuesta = new Response(false, 'Esa consulta ya está relacionada a una factura');
                echo $respuesta->json(400);
                exit();
        }
    }

    /**
     * Validaciones para insertar factura de consulta por emergencia
     */
    public static function validarConsultaEmergencia($formulario) {
        
        $_consultaEmergenciaModel = new ConsultaEmergenciaModel();
        $consultaEmergencia = $_consultaEmergenciaModel->where('consulta_id', '=', $formulario['consulta_id'])->getFirst();
        
        if (is_null($consultaEmergencia)) {
            $respuesta = new Response(false, 'La consulta indicada no se encuentra relacionada a un seguro');
            echo $respuesta->json(400);
            exit();
        }
    }
}