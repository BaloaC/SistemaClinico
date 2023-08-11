<?php

class MedicoHelper {

    public static function actualizarAcumulado($formulario) {
        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id', '=', $formulario['medico_id'])->getFirst();
        $acumulado = $medico->acumulado + $formulario['monto'];

        $fueActualizado = $_medicoModel->where('medico_id', '=', $formulario['medico_id'])->update(array("acumulado" => $acumulado));

        if (!$fueActualizado) {
            $respuesta = new Response('ACTUALIZACION_FALLIDA');
            $respuesta->setData($formulario);
            echo $respuesta->json(400);
            exit();
        }
    }

}