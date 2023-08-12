<?php

class ConsultaSeguroValidaciones {

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