<?php

class MedicoHelper {

    public static function actualizarAcumulado($formulario) {
        $_medicoModel = new MedicoModel();
        $fueActualizado = $_medicoModel->where('medico_id', '=', $formulario['medico_id'])->update(array("acumulado" => $formulario['monto']));

        if (!$fueActualizado) {
            $respuesta = new Response('ACTUALIZACION_FALLIDA');
            $respuesta->setData($formulario);
            echo $respuesta->json(400);
            exit();
        }
    }

}