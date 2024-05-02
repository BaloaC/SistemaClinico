<?php

use LDAP\Result;

class ExamenHelpers {
    
    public static function insertarEspecialidad($especialidades, $examen_id) {
        $_examenEspecialidad = new ExamenEspecialidadModel();

        foreach ($especialidades as $especialidad) {
            $especialidad['examen_id'] = $examen_id;
            $fue_insertado = $_examenEspecialidad->insert($especialidad);

            if ($fue_insertado <= 0) {
                $response = new Response(false, 'Ocurrió un error insertando la especialidad del examen');
                $response->setData('Error con la especialidad_id '.$especialidad['especialidad_id']);
                echo $response->json(400);
                exit();
            }
        }
    }
}

?>