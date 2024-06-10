<?php

include_once "./services/medico/medicoHelpers.php";
include_once './services/globals/GlobalsHelpers.php';
include_once './services/consulta/consultaHelpers.php';
include_once './services/facturas/consulta/FacturaConsultaHelpers.php';

class ConsultaService {

    // variables para el inner join de consultas_sin cita
    protected static $selectConsultaSinCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "paciente.edad AS edad_paciente",
        "paciente.tipo_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellidos_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad"
    );

    protected static $innerConsultaSinCita = array(
        "paciente" => "consulta_sin_cita",
        "medico" => "consulta_sin_cita",
        "especialidad" => "consulta_sin_cita"
    );

    // variables para el inner join de consultas con cita
    protected static $selectConsultaCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula AS cedula_paciente",
        "paciente.edad AS edad_paciente",
        "paciente.tipo_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellidos_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "consulta_cita.consulta_id",
        "consulta_cita.cita_id",
        "consulta.estatus_con",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.tipo_cita"
    );

    protected static $innerConsultaCita = array(
        "cita" => "consulta_cita",
        "consulta" => "consulta_cita",
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita"
    );

    // variables para el inner join de paciente beneficiado
    protected static $selectPacienteBeneficiado = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellidos_paciente",
        "paciente.cedula",
        "paciente_beneficiado.paciente_beneficiado_id",
        "paciente.edad AS edad_beneficiado",
        "paciente.tipo_paciente",
    );

    protected static $innerPacienteBeneficiado = array(
        "paciente" => "paciente_beneficiado"
    );

    public static function insertarConsultaEmergencia($formulario) {
        
        ConsultaValidaciones::validarEsEmergencia($formulario);
        ConsultaValidaciones::validarConsultaEmergencia($formulario);
        
        $validarConsulta = new Validate;
        $consultaEmergencia = $validarConsulta->dataScape($formulario);
        
        $consulta_id = ConsultaHelper::insertarConsulta($consultaEmergencia, 'emergencia');
        $consultaEmergencia['consulta_id'] = $consulta_id;  

        // $consultaSinCita = array(
        //     "consulta_id" => $consultaEmergencia['consulta_id'],
        //     "especialidad_id" => $formulario['especialidad_id'],
        //     "medico_id" => $formulario["medico_id"],
        //     "paciente_id" => $formulario["paciente_id"],
        // );
        // $consultaSinCitaModel = new ConsultaSinCitaModel();
        // $consultaSinCitaModel->insert($consultaSinCita);

        if( isset($consultaEmergencia['pagos']) ) {
            ConsultaService::actualizarAcumuladoMedico($consultaEmergencia['pagos']);
        }
        
        // if (isset($formulario['examenes'])) {
        //     $formulario['consulta_id'] = $consulta_id;
        //     ConsultaHelper::insertarExamenesEmergencia($formulario);
        // }
        $total = 0;
        if (isset($formulario['insumos'])) {
            $total = ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_id, true);
        }
        
        if (isset($formulario['recipes'])) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_id);
        }

        if (isset($formulario['referidos'])) {
            ConsultaHelper::insertarReferidos($formulario['referidos'], $consulta_id);
        }

        if (isset($formulario['indicaciones'])) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_id);
        }

        if ($total != 0) {
            $consultaEmergencia['total_insumos'] = $total['insumo_total'];
            $consultaEmergencia['medicamentos'] = $total['medicamento_total'];
        }
        ConsultaHelper::insertarConsultaEmergencia($consultaEmergencia);

        return $consulta_id;
    }

    public static function insertarConsultaNormal($formulario, $consulta_separada) {

        $_consultaSinCita = new ConsultaSinCitaModel();
        $consulta_sin_cita = $_consultaSinCita->insert($consulta_separada[0]);
        
        if ($consulta_sin_cita == 0) {
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $consulta_separada[0]['consulta_id'])->delete();
            
            $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_sin_cita');
            return $respuesta->json(400);
        }

        if (isset($formulario['examenes'])) {
            ConsultaHelper::insertarExamen($formulario['examenes'], $consulta_separada[0]['consulta_id']);
        }
        
        // if (array_key_exists('insumos', $formulario)) {
        //     ConsultaHelper::insertarInsumo($formulario['insumos'], $consulta_separada[0]['consulta_id'], false);
        // }

        if (array_key_exists('indicaciones', $formulario)) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('referidos', $formulario)) {
            ConsultaHelper::insertarReferidos($formulario['referidos'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('recipes', $formulario)) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_separada[0]['consulta_id']);
        }
    }

    public static function insertarConsultaPorCita($formulario, $consulta_separada) {

        $_consultaConCita = new ConsultaCitaModel();
        $consulta_cita_id = $_consultaConCita->insert($consulta_separada[0]);
        
        if ($consulta_cita_id == 0) {
            $_consultaModel = new ConsultaModel();
            $_consultaModel->where('consulta_id', '=', $consulta_separada[0]['consulta_id'])->delete();

            $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_cita');
            return $respuesta->json(400);
        }

        // $_citaModel = new CitaModel;
        // $cita_previa = $_citaModel->where('cita_id', '=', $formulario['cita_id'])->getFirst();

        // obtenemos los exámenes que no estén registrados en cita_examen
        $examenes_filtrados = [];
        if (array_key_exists('examenes', $formulario)) {
            $examenes_filtrados = ConsultaHelper::obtenerExamenesFiltrados($formulario['cita_id'], $formulario['examenes']);
        }

        if (count($examenes_filtrados) > 0) {
            if (array_key_exists('examenes', $formulario)) {
                ConsultaHelper::insertarExamen($examenes_filtrados, $consulta_separada[0]['consulta_id']);
            }
    
            // if ($cita_previa->tipo_cita == 2 && array_key_exists('examenes', $formulario)) {
            //     ConsultaHelper::insertarExamenesSeguro($examenes_filtrados, $consulta_separada[0]['consulta_id']);
            // }
        }
        
        if (array_key_exists('referidos', $formulario)) {
            ConsultaHelper::insertarReferidos($formulario['referidos'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('recipes', $formulario)) {
            ConsultaHelper::insertarRecipe($formulario['recipes'], $consulta_separada[0]['consulta_id']);
        }

        if (array_key_exists('indicaciones', $formulario)) {
            ConsultaHelper::insertarIndicaciones($formulario['indicaciones'], $consulta_separada[0]['consulta_id']);
        }

        $respuesta = new Response('INSERCION_EXITOSA');

        $cambioEstatus = array('estatus_cit' => '4');
        $_citaModel = new CitaModel;
        $res = $_citaModel->where('cita_id', '=', $formulario['cita_id'])->update($cambioEstatus);
        $respuesta = new Response('INSERCION_EXITOSA');
        
        if ($res <= 0) {
            $respuesta->setData('La consulta fue insertada, pero la cita no fue actualizada correctamente, por favor actualicela manualmente para evitar errores');
        }
    }

    public static function actualizarAcumuladoMedico($formulario) {
        foreach ($formulario as $campo) {
            MedicoHelper::actualizarAcumulado($campo);
        }
    }

    public static function obtenerConsultaNormal($consulta, $obtener_relaciones = true) {
        $_consultaCita = new ConsultaCitaModel();
        $innersCita = $_consultaCita->listInner(ConsultaService::$innerConsultaCita);
        $_consultaCita->where('consulta_cita.consulta_id', '=', $consulta->consulta_id);
                                

        if (isset($_GET['status'])) {
            $_consultaCita->where('consulta.estatus_con','=',$_GET['status']);
        } else {
            $_consultaCita->where('consulta.estatus_con','=',1);
        }

        $es_citada = $_consultaCita->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita");
        
        if (is_null($es_citada) || count($es_citada) == 0 ) { // Si no es por cita, extraemos la información de consulta_sin_cita

            $_consultaSinCita = new ConsultaSinCitaModel();
            $innersConsulta = $_consultaSinCita->listInner(ConsultaService::$innerConsultaSinCita);
            $consultaCompleta = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                                ->innerJoin(ConsultaService::$selectConsultaSinCita, $innersConsulta, "consulta_sin_cita");

            $relaciones = [];
            if ($obtener_relaciones) {
                $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
            }
            
            if (count((array) $relaciones) > 0 && !empty($consultaCompleta[0])) {
                $consultaCompleta[0] = (object) array_merge((array) $consultaCompleta[0], (array) $relaciones);
            }

            if(isset($consultaCompleta[0])){
                return $consultas[] = (object) array_merge((array) $consulta, (array) $consultaCompleta[0]);
            }
            
        } else { // Si es por cita extraemos la información de consulta_cita
            $_cita = new CitaModel();
            $innersCita = $_consultaCita->listInner(ConsultaService::$innerConsultaCita);
            $cita = $_cita->where('cita.cita_id', '=', $es_citada[0]->cita_id)->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita")[0];

            if ($obtener_relaciones) {
                $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
                if (count((array) $relaciones) > 0) {
                    $consultaCompleta = (object) array_merge((array) $consulta, (array) $relaciones);
                }
            }
            
            return $consultas[] = (object) array_merge((array) $consulta, (array) $cita);
            
        }
    }

    public static function obtenerConsultaEmergencia($consulta, $obtenerRelaciones = true) {
        
        $selectInner = array(
            "medico.medico_id",
            "medico.nombre AS nombre_medico",
            "medico.apellidos AS apellidos_medico",
            "medico.cedula AS cedula",
            "especialidad.especialidad_id",
            "especialidad.nombre AS nombre_especialidad"
        );

        $inner = array(
            "medico" => "consulta_sin_cita",
            "especialidad" => "consulta_sin_cita"
        );

        $_consultaSinCita = new ConsultaSinCitaModel();
        $innersConsulta = $_consultaSinCita->listInner($inner);
        $consultaSinCita = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                            ->innerJoin($selectInner, $innersConsulta, "consulta_sin_cita");
        
        $_consultaEmergencia = new ConsultaEmergenciaModel();
        $consultaEmergencia = $_consultaEmergencia->where('consulta_id','=', $consulta->consulta_id)->getFirst();
        
        $_paciente = new PacienteModel();
        $paciente = $_paciente->where('paciente_id','=', $consultaEmergencia->paciente_id)->getFirst();

        $_pacienteSeguro = new PacienteSeguroModel();
        $innersSeguro = $_pacienteSeguro->listInner(["empresa" => "paciente_seguro"]);
        $paciente_seguro = $_pacienteSeguro->where('paciente_seguro.paciente_id', '=', $consultaEmergencia->paciente_id)
                                            ->innerJoin(array("empresa.nombre, empresa.rif, empresa.direccion"), $innersSeguro, "paciente_seguro");
        
        $_pacienteModel = new PacienteModel();
        $beneficiado = $_pacienteModel->where('cedula', '=', $consultaEmergencia->cedula_beneficiado)->getFirst();
        
        $consultas = $consulta;
        $consultas->paciente_id = $consultaEmergencia->paciente_id;
        $consultas->factura = $consultaEmergencia;
        $consultas->titular = $paciente;
        $consultas->beneficiado = $beneficiado;
        $consultas->empresas = $paciente_seguro;

        $relaciones = NULL;
        if ($obtenerRelaciones) {
            $relaciones = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
        }

        $valorDivisa = GlobalsHelpers::obtenerValorDivisa();
        if ($consultas->factura->total_consulta == $consultas->factura->monto_aprobado || $consultas->factura->monto_cubierto_usd == 0) {
            $consultas->factura->consultas_medicas_bs = round( $consultas->factura->consultas_medicas * $valorDivisa, 2);
            $consultas->factura->laboratorios_bs = round( $consultas->factura->laboratorios * $valorDivisa, 2);
            $consultas->factura->medicamentos_bs = round( $consultas->factura->medicamentos * $valorDivisa, 2);
            $consultas->factura->area_observacion_bs = round( $consultas->factura->area_observacion * $valorDivisa, 2);
            $consultas->factura->enfermeria_bs = round( $consultas->factura->enfermeria * $valorDivisa, 2);
            $consultas->factura->total_insumos_bs = round( $consultas->factura->total_insumos * $valorDivisa, 2);
            $consultas->factura->total_examenes_bs = round( $consultas->factura->total_examenes * $valorDivisa, 2);
            $consultas->factura->total_consulta_bs = round( $consultas->factura->total_consulta * $valorDivisa, 2);
        } else {

            if ($consultas->factura->monto_cubierto_usd != 0) {
                
                $valor_divisa = $consultas->factura->monto_cubierto_usd / $consultas->factura->monto_cubierto_bs;
    
                $valores = ['consultas_medicas','laboratorios','medicamentos','area_observacion','enfermeria','total_insumos','total_examenes','total_consulta'];
                foreach ($valores as $valor) {
                    $valor_bs = $valor.'_bs';
    
                    if ( $consultas->factura->$valor_bs == 0 ) {
                        $consultas->factura->$valor_bs = round( $consultas->factura->$valor * $valorDivisa, 2);
                    } else {
                        $esta_completo = ($consultas->factura->$valor_bs / $consultas->factura->$valor) != $valor_divisa;
        
                        if (!$esta_completo) {
                            $pago_dolares = $consultas->factura->$valor_bs / $valor_divisa;
                            $pago_restante = $consultas->factura->$valor - $pago_dolares;
                            $consultas->factura->$valor_bs = round($pago_restante * $valorDivisa, 2) + $consultas->factura->$valor_bs;
                        }
                    }
                }
            }
        }
        
        if (!is_null($relaciones) && count((array) $relaciones) > 0) {
            return (object) array_merge((array) $consultas, (array) $relaciones);
        } else {
            return $consultas;
        }
    }

    public static function obtenerConsultasAseguradas($params) {
        $_consultaCitaModel = new ConsultaCitaModel();
        $_consultaCitaModel->where('consulta.estatus_con', '!=', 2);
        
        if (isset($params['estatus'])) {
            $_consultaCitaModel->where('consulta.estatus_con', '=', $params['estatus']);
        }

        if (isset($params['start']) || isset($params['search']) || isset($params['page']) ){
            if (isset($params['start']) || isset($params['page'])) {
                $size = isset($params['length']) ? $params['length'] : 10;
                $pagina_actual = isset($params['page']) ? $params['page'] : floor($params['start'] / $params['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_consultaCitaModel->limit([$primer_registro, $size]);
            }

            if(isset($params['search'])) {
                if (is_array($params['search']) && strlen($params['search']['value']) > 0) {
                    $_consultaCitaModel->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']['value']}%");
                } else if (!is_array($params['search']) && strlen($params['search']) > 0 && $params['select']) {
                    $_consultaCitaModel->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']}%");
                }
            }
        }

        $inners = $_consultaCitaModel->listInner(["consulta" => "consulta_cita", "cita" => "consulta_cita", "paciente" => "cita"]);
        $select = ["consulta.consulta_id", "consulta.observaciones", "paciente.nombre", "paciente.apellidos"];
        $lista = $_consultaCitaModel->where('cita.tipo_cita', '=', '2')->innerJoin($select, $inners, "consulta_cita");
        $_consultaCitaModel->resetValues();

        if ( isset($params['search']) ) {
            if (!is_array($params['search']) && strlen($params['search']) > 0 && $params['select']) {
                $_consultaCitaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']}%");
            } else if ( strlen($params['search']['value']) > 0) {
                $_consultaCitaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']['value']}%");
            } else {
                $_consultaCitaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_consultaCitaModel->setSelect('COUNT(*) AS total');
        }

        $_consultaCitaModel->where('cita.tipo_cita', '=', '2')->where('consulta.estatus_con', '!=', 2);

        if (isset($params['estatus'])) {
            $_consultaCitaModel->where('consulta.estatus_con', '=', $params['estatus']);
        }

        $lista_count = $_consultaCitaModel->innerJoin($select, $inners, "consulta_cita");
        return ['lista_count' => $lista_count, 'lista' => $lista];
    }

    public static function obtenerConsultasPorEmergencia($params) {
        $_consultaModel = new ConsultaModel();
        $_consultaModel->where('consulta.es_emergencia', '=', 1);
        
        if (isset($params['con_clave']) && $params['con_clave']) {
            $_consultaModel->where('consulta_emergencia.autorizacion', '!=', 'NULL');
        }

        if (isset($params['estatus'])) {
            $_consultaModel->where('consulta.estatus_con', '=', $params['estatus']);
        } else {
            $_consultaModel->where('consulta.estatus_con', '!=', 2);
        }

        if (isset($params['start']) || isset($params['search']) || isset($params['page']) ){
            if (isset($params['start']) || isset($params['page'])) {
                $size = isset($params['length']) ? $params['length'] : 10;
                $pagina_actual = isset($params['page']) ? $params['page'] : floor($params['start'] / $params['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_consultaModel->limit([$primer_registro, $size]);
            }

            if(isset($params['search'])) {
                if (is_array($params['search']) && strlen($params['search']['value']) > 0) {
                    $_consultaModel->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']['value']}%");
                } else if (!is_array($params['search']) && strlen($params['search']) > 0 && $params['select']) {
                    $_consultaModel->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']}%");
                }
            }
        }

        $inners = $_consultaModel->listInner(["consulta" => "consulta_emergencia", "paciente" => "consulta_emergencia"]);
        $select = ["consulta.consulta_id", "consulta.observaciones", "paciente.nombre", "paciente.apellidos"];
        $lista = $_consultaModel->innerJoin($select, $inners, "consulta_emergencia");
        $_consultaModel->resetValues();
        
        if ( isset($params['search']) ) {
            if (!is_array($params['search']) && strlen($params['search']) > 0 && $params['select']) {
                $_consultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']}%");
            } else if ( strlen($params['search']['value']) > 0) {
                $_consultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta.consulta_id, consulta.observaciones, paciente.nombre, paciente.apellidos)", 'LIKE', "%{$params['search']['value']}%");
            } else {
                $_consultaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_consultaModel->setSelect('COUNT(*) AS total');
        }

        $_consultaModel->where('consulta.estatus_con', '!=', 2);

        if (isset($params['estatus'])) {
            $_consultaModel->where('consulta.estatus_con', '=', $params['estatus']);
        }
        
        $lista_count = $_consultaModel->innerJoin($select, $inners, "consulta_emergencia");
        return ['lista_count' => $lista_count, 'lista' => $lista];
    }

    public static function obtenerConsultaPorCita($paciente_id, $tipo_cita = null) {
        $_citaModel = new CitaModel();
        $innersCita = $_citaModel->listInner(ConsultaService::$innerConsultaCita);
        $_citaModel->where('cita.paciente_id', '=', $paciente_id)
                                ->where('consulta.estatus_con','!=',2);

        if (!is_null($tipo_cita)) {
            $_citaModel->where('cita.tipo_cita', '=', $tipo_cita);
        }

        $cita = $_citaModel->innerJoin(ConsultaService::$selectConsultaCita, $innersCita, "consulta_cita");

        return $cita;
    }
}