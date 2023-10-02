<?php

include_once "./services/facturas/medico/FacturaMedicoHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroHelpers.php";

class EstadisticasController extends Controller{

    //Método index (vista principal)
    public function index() { 

        return $this->view('estadisticas/index');
    }

    public function allConsultas() { 

        $fechas = [];

        // Obtenemos el primer y último día del mes
        $fecha_mes = DateTime::createFromFormat('Y-m-d', date("Y-m") . "-01");
        $fecha_mes->modify('first day of this month');
        $fechas['fecha_inicio'] = $fecha_mes->format("Y-m-d");

        $fecha_mes->modify('last day of this month');
        $fechas['fecha_fin'] = $fecha_mes->format("Y-m-d");

        $consultasAseguradas = FacturaMedicoHelpers::contabilizarFacturasAseguradasAll($fechas);
        $consultasNormales = FacturaMedicoHelpers::contabilizarFacturasNormalesAll($fechas);

        $consultas = [
            "consultas_aseguradas" => count($consultasAseguradas),
            "consultas_normales" => count($consultasNormales)
        ];

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($consultas);

        return $respuesta->json(200);
    }

    public function allConsultasMedicos() {

        $fechas = [];

        // Obtenemos el primer y último día del mes
        $fecha_mes = DateTime::createFromFormat('Y-m-d', "2023-09" . "-01");
        $fecha_mes->modify('first day of this month');
        $fechas['fecha_inicio'] = $fecha_mes->format("Y-m-d");

        $fecha_mes->modify('last day of this month');
        $fechas['fecha_fin'] = $fecha_mes->format("Y-m-d");

        $consultasAseguradas = FacturaMedicoHelpers::contabilizarFacturasAseguradasAll($fechas);
        $consultasNormales = FacturaMedicoHelpers::contabilizarFacturasNormalesAll($fechas);

        $consultaInfo = [];
        $consultasAseguradas = ConsultaSeguroHelpers::obtenerInformacionCompleta($consultasAseguradas);

        foreach ($consultasNormales as $consulta) {
            $consultaInfo[] = FacturaConsultaHelpers::obtenerInformacion($consulta);
        }

        foreach ($consultasAseguradas as $dato) {
            $medicoId = $dato['medico_id'];
            if (isset($conteosSeguro[$medicoId])) {
                $conteosSeguro[$medicoId]['cantidad']++;
            } else {
                $conteosSeguro[$medicoId] = [
                    'cantidad' => 1,
                    'nombre_medico' => $dato["medico"]->nombre . " " . $dato["medico"]->apellidos,
                    'nombre_especialidad' => $dato['especialidad']->nombre,
                    'especialidad_id' => $dato['especialidad']->especialidad_id
                ];
            }
        }

        foreach ($consultaInfo as $dato) {
            $medicoId = $dato['medico_id'];
            if (isset($conteos[$medicoId])) {
                $conteos[$medicoId]['cantidad']++;
            } else {
                $conteos[$medicoId] = [
                    'cantidad' => 1,
                    'nombre_medico' => $dato['nombre_medico'] . " " . $dato['apellidos_medico'],
                    'nombre_especialidad' => $dato['nombre_especialidad'],
                    'especialidad_id' => $dato['especialidad_id']
                ];
            }
        }

        $consultasMedicosList = array_merge($conteos, $conteosSeguro);

        $sumByMedico = array_values(array_reduce($consultasMedicosList, function ($finalArray, $item) {
            $nombreMedico = $item['nombre_medico'];
            $cantidad = $item['cantidad'];

            if (!isset($finalArray[$nombreMedico])) {
                $finalArray[$nombreMedico] = [
                    'nombre_medico' => $nombreMedico,
                    'cantidad' => $cantidad
                ];
            } else {
                $finalArray[$nombreMedico]['cantidad'] += $cantidad;
            }

            return $finalArray;
        }, []));

        usort($sumByMedico, function($a, $b) { return $b['cantidad'] - $a['cantidad']; });

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($sumByMedico);

        return $respuesta->json(200);
    }

    public function allConsultasEspecialidades() {

        $fechas = [];

        // Obtenemos el primer y último día del mes
        $fecha_mes = DateTime::createFromFormat('Y-m-d', "2023-09" . "-01");
        $fecha_mes->modify('first day of this month');
        $fechas['fecha_inicio'] = $fecha_mes->format("Y-m-d");

        $fecha_mes->modify('last day of this month');
        $fechas['fecha_fin'] = $fecha_mes->format("Y-m-d");

        $consultasAseguradas = FacturaMedicoHelpers::contabilizarFacturasAseguradasAll($fechas);
        $consultasNormales = FacturaMedicoHelpers::contabilizarFacturasNormalesAll($fechas);

        $consultaInfo = [];
        $consultasAseguradas = ConsultaSeguroHelpers::obtenerInformacionCompleta($consultasAseguradas);

        foreach ($consultasNormales as $consulta) {
            $consultaInfo[] = FacturaConsultaHelpers::obtenerInformacion($consulta);
        }

        $conteosEspecialidades = [];

        foreach ($consultasAseguradas as $dato) {
            $especialidadId = $dato['especialidad']->especialidad_id;
            if (isset($conteosEspecialidades[$especialidadId])) {
                $conteosEspecialidades[$especialidadId]['cantidad']++;
            } else {
                $conteosEspecialidades[$especialidadId] = [
                    'cantidad' => 1,
                    'nombre_especialidad' => $dato['especialidad']->nombre
                ];
            }
        }

        foreach ($consultaInfo as $dato) {
            $especialidadId = $dato['especialidad_id'];
            if (isset($conteosEspecialidades[$especialidadId])) {
                $conteosEspecialidades[$especialidadId]['cantidad']++;
            } else {
                $conteosEspecialidades[$especialidadId] = [
                    'cantidad' => 1,
                    'nombre_especialidad' => $dato['nombre_especialidad']
                ];
            }
        }

        $sumByEspecialidad = array_values(array_reduce($conteosEspecialidades, function ($finalArray, $item) {
            $nombreEspecialidad = $item['nombre_especialidad'];
            $cantidad = $item['cantidad'];

            if (!isset($finalArray[$nombreEspecialidad])) {
                $finalArray[$nombreEspecialidad] = [
                    'nombre_especialidad' => $nombreEspecialidad,
                    'cantidad' => $cantidad
                ];
            } else {
                $finalArray[$nombreEspecialidad]['cantidad'] += $cantidad;
            }

            return $finalArray;
        }, []));

        usort($sumByEspecialidad, function($a, $b) { return $b['cantidad'] - $a['cantidad']; });

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($sumByEspecialidad);

        return $respuesta->json(200);
    }
}
