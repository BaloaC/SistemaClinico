<?php

class GlobalsHelpers {

    public static function obtenerValorDivisa() {
        $_globalModel = new GlobalModel();
        $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();
        return $valorDivisa->value;
    }
}