<?php

class GlobalsHelpers {

    public static function obtenerValorDivisa() {
        $_globalModel = new GlobalModel();
        $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();
        return $valorDivisa->value;
    }

    public static function obtenerPorcentajeMedico() {
        $_globalModel = new GlobalModel();
        $porcentajeMedico = $_globalModel->whereSentence('key', '=', 'porcentaje_medico')->getFirst();
        return $porcentajeMedico->value;
    }

    public static function obtenerPorcentajeInsumo() {
        $_globalModel = new GlobalModel();
        $porcentajeInsumo = $_globalModel->whereSentence('key', '=', 'porcentaje_insumo')->getFirst();
        return $porcentajeInsumo->value;
    }
}