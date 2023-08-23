<?php

class PacienteSeguroService {

    /**
     * Función para actualizar el saldo de un paciente_seguro
     */
    public static function actualizarSaldoPaciente($monto, $paciente) {
        $fueActualizado = $paciente->update([ 'saldo_disponible' => $monto ]);

        if (!$fueActualizado) {
            $respuesta = new Response(false, 'Hubo un error manipulando el saldo del paciente');
            $respuesta->setData('Error al procesar al paciente id ' + $paciente->paciente_id + 'con saldo ' + $paciente->saldo_disponible);
            echo $respuesta->json(400);
            exit();
        }

        $respuesta = new Response('INSERCION_EXITOSA');
        echo $respuesta->json(201);
        exit();
        
    }
}