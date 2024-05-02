<?php

class CitasHelpers {

    protected static $arraySelect = array(
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellido_medico",
        "especialidad.nombre AS nombre_especialidad",
        "cita.clave",
        "cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.fecha_cita",
        "cita.hora_entrada",
        "cita.hora_salida",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.tipo_cita",
        "cita.estatus_cit"
    );

    protected static $arrayInner = array(
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita",
    );

    protected static $seguroSelect = array(
        "cita_seguro.seguro_id",
        "seguro.nombre AS nombre_seguro",
        "cita_seguro.clave"
    );

    protected static $seguroInner = array(
        "seguro" => "cita_seguro"
    );

    public static function innerCita($lista) {
        
        $_citaSeguroModel = new CitaSeguroModel();
        $inners = $_citaSeguroModel->listInner(CitasHelpers::$seguroInner);
        $citaSeguro = $_citaSeguroModel->where('cita_id', '=', $lista->cita_id)->innerJoin(CitasHelpers::$seguroSelect, $inners, "cita_seguro");
        $lista->cita_seguro = $citaSeguro;

        return $lista;
    }

    public static function insertarCitaExamen($examenes, $cita_id) {
        foreach ($examenes as $examen) {
            $examen['cita_id'] = $cita_id;
            $_citaExamenModel = new CitaExamenModel();
            $fue_insertado = $_citaExamenModel->insert($examen);

            if (!$fue_insertado) {
                $respuesta = new Response(false, 'Error insertando el examen en la cita');
                $respuesta->setData('Error insertando el examen_id '.$examen['examen_id']);
                echo $respuesta->json(400);
                exit();
            }
        }
    }
}