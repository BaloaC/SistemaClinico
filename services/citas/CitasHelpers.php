<?php

include_once './services/seguros/seguro/SeguroHelpers.php';

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

    public static function insertarCitaExamen($formulario, $cita_id) {
        
        foreach ($formulario['examenes'] as $examen) {
            $examen['cita_id'] = $cita_id;
            $examen['precio_examen_usd'] = 0;
            
            // dejando en blanco los montos que fueron actualizados al insertar la clave
            $examen['monto_cubierto_usd'] = 0;
            $examen['cubierto_por'] = 1;

            if (array_key_exists('seguro_id', $formulario)) {
                
                $_seguroExamenModel = new SeguroExamenModel();
                $seguro_examenes = $_seguroExamenModel->where('seguro_id', '=', $formulario['seguro_id'])->getFirst();    
                $examenes = explode(',', $seguro_examenes->examenes);
                $costos = explode(',', $seguro_examenes->costos);
                
                $indice_examen = array_search($examen['examen_id'], $examenes);
                
                if ($indice_examen === false) {
                    $_examenModel = new ExamenModel();
                    $cita_examen = $_examenModel->where('examen_id', '=', $examen['examen_id'])->getFirst();
                    $examen['precio_examen_usd'] = $cita_examen->precio_examen;

                } else {
                    $costo_examen = $costos[$indice_examen];
                    $examen['precio_examen_usd'] = $costo_examen;
                }
            } else {

                $_examenModel = new ExamenModel();
                $cita_examen = $_examenModel->where('examen_id', '=', $examen['examen_id'])->getFirst();
                $examen['precio_examen_usd'] = $cita_examen->precio_examen;
            }
            
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

    public static function actualizarExamenCita($cita_examenes) {
        foreach ($cita_examenes as $cita_examen) {
            $info_actualizar = [];
            
            $_citaExamenModel = new CitaExamenModel();
            $cita_exa = $_citaExamenModel->where('cita_examen_id', '=', $cita_examen['cita_examen_id'])->getFirst();
            $info_actualizar['estatus_cit'] = $cita_examen['estatus_cit'];

            $info_actualizar['cubierto_por'] = $cita_examen['cubierto_por'];
            if ($cita_examen['cubierto_por'] != 2 ) {
                $_examenModel = new ExamenModel();
                $examen = $_examenModel->where('examen_id', '=', $cita_exa->examen_id)->getFirst();
                $info_actualizar['precio_examen_usd'] = $examen->precio_examen;
            }
            
            $_citaExamenModel->resetValues();
            $se_actualizo = $_citaExamenModel->where('cita_examen_id', '=', $cita_examen['cita_examen_id'])->update($info_actualizar);
            
            if ($se_actualizo <= 0 || !$se_actualizo) {
                $respuesta = new Response(false, 'Ocurrió un error actualizando la cita examen id '.$cita_examen['cita_examen_id']);
                echo $respuesta->json(400);
                exit();
            }
        }
    }

    public static function obtenerExamenes($cita_id) {
        $_citaExamenModel = new CitaExamenModel();
        $inners = $_citaExamenModel->listInner(['examen' => 'cita_examen']);
        $select = ['cita_examen.cita_examen_id', 'cita_examen.examen_id', 'cita_examen.precio_examen_bs', 'cita_examen.precio_examen_usd', 'examen.nombre'];
        $lista_examenes = $_citaExamenModel->where('cita_id', '=', $cita_id)->innerJoin($select, $inners, 'cita_examen');

        return $lista_examenes;
    }
}