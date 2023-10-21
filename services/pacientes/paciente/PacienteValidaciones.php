<?php

class PacienteValidaciones {

    public static function validacionesGenerales($formulario) {

        $camposNumericos = array("cedula", "edad", "telefono", "tipo_paciente");
        $camposString = array("nombre", "apellidos");
        $validarPaciente = new Validate;

        if ( ($validarPaciente->isEmpty($formulario)) ) {
            $respuesta = new Response('DATOS_VACIOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isNumber($formulario, $camposNumericos) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isString($formulario, $camposString) ) {
            $respuesta = new Response('DATOS_INVALIDOS');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isDate($formulario['fecha_nacimiento']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            echo $respuesta->json(400);
            exit();
        }

        if ( $validarPaciente->isToday($formulario['fecha_nacimiento'], false) ) {
            $respuesta = new Response(false, 'La fecha de nacimiento no puede ser posterior al dia de hoy');
            $respuesta->setData($formulario['fecha_nacimiento']);
            echo $respuesta->json(400);
            exit();
        }
    }
}