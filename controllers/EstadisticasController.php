<?php

include_once "./services/facturas/medico/FacturaMedicoHelpers.php";
include_once "./services/facturas/consulta/FacturaConsultaHelpers.php";
include_once "./services/facturas/consulta seguro/ConsultaSeguroHelpers.php";
include_once './services/consulta/consultaService.php';

class EstadisticasController extends Controller
{

    //Método index (vista principal)
    public function index()
    {

        return $this->view('estadisticas/index');
    }

    public function pacientesByAge()
    {

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->setSelect("
        SUM(CASE WHEN edad < 18 THEN 1 ELSE 0 END) AS menos18, 
        SUM(CASE WHEN edad > 18 AND edad < 30 THEN 1 ELSE 0 END) AS mas18_30, 
        SUM(CASE WHEN edad > 31 AND edad < 40 THEN 1 ELSE 0 END) AS mas31_40, 
        SUM(CASE WHEN edad > 41 AND edad < 50 THEN 1 ELSE 0 END) AS mas41_50, 
        SUM(CASE WHEN edad > 51 AND edad < 60 THEN 1 ELSE 0 END) AS mas51_60, 
        SUM(CASE WHEN edad >= 60 THEN 1 ELSE 0 END) AS mayor60")->getAll();

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($paciente);

        return $respuesta->json(200);
    }

    public function pacientesByType()
    {

        $_pacienteModel = new PacienteModel();
        $paciente = $_pacienteModel->setSelect("
        SUM(CASE WHEN tipo_paciente = 1 THEN 1 END) AS paciente_natural,
        SUM(CASE WHEN tipo_paciente = 2 THEN 1 END) AS paciente_representante,
        SUM(CASE WHEN tipo_paciente = 3 THEN 1 END) AS paciente_asegurado,
        SUM(CASE WHEN tipo_paciente = 4 THEN 1 END) AS paciente_beneficiado")->getAll();

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($paciente);

        return $respuesta->json(200);
    }

    public function allConsultas()
    {

        // Obtener la fecha de hoy
        $hoy = date('Y-m-d');

        // Calcular la fecha del domingo anterior
        $fechaInicio = date('Y-m-d', strtotime('last monday', strtotime($hoy)));

        $_consultaModel = new ConsultaModel();
        $consultaList = $_consultaModel->where('estatus_con', '=', 1);
        $consultaList =  $_consultaModel->whereDate("fecha_consulta", $fechaInicio, $hoy)->getAll();
        $_consultaModel->resetValues();

        $consultasFiltradas = [];

        foreach ($consultaList as $consulta) {
            if ($consulta->es_emergencia) {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaEmergencia($consulta, false);
            } else {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaNormal($consulta);
            }
        }

        $consultaInfo = [];
        $consultasAseguradas = [];

        foreach ($consultasFiltradas as $consulta) {

            // Consultas normales
            if (isset($consulta->tipo_cita) && $consulta->tipo_cita = 1) {
                $consultaInfo[] = $consulta;
            } else {
                $consultasAseguradas[] = $consulta;
            }
        }

        $consultas = [
            "consultas_aseguradas" => count($consultasAseguradas),
            "consultas_normales" => count($consultaInfo)
        ];

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($consultas);

        return $respuesta->json(200);
    }

    public function allConsultasMedicos()
    {

        $fechas = [];
        $conteos = [];
        $conteosSeguro = [];

        // Obtener la fecha de hoy
        $hoy = date('Y-m-d');

        // Calcular la fecha del domingo anterior
        $fechaInicio = date('Y-m-d', strtotime('last monday', strtotime($hoy)));

        $_consultaModel = new ConsultaModel();
        $consultaList = $_consultaModel->where('estatus_con', '=', 1);
        $consultaList =  $_consultaModel->whereDate("fecha_consulta", $fechaInicio, $hoy)->getAll();
        $_consultaModel->resetValues();

        $consultasFiltradas = [];

        foreach ($consultaList as $consulta) {
            if ($consulta->es_emergencia) {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaEmergencia($consulta, false);
            } else {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaNormal($consulta);
            }
        }

        $consultaInfo = [];
        $consultasAseguradas = [];

        foreach ($consultasFiltradas as $consulta) {

            // Consultas normales
            if (isset($consulta->tipo_cita) && $consulta->tipo_cita = 1) {
                $consultaInfo[] = $consulta;
            } else {
                $consultasAseguradas[] = $consulta;
            }
        }

        foreach ($consultasAseguradas as $dato) {

            $medicoId = $dato->medico_id ?? ($dato->medico->medico_id ?? null);
            if ($medicoId === null) continue;

            if (isset($conteosSeguro[$medicoId])) {
                $conteosSeguro[$medicoId]['cantidad']++;
            } else {
                $conteosSeguro[$medicoId] = [
                    'cantidad' => 1,
                    'nombre_medico' => $dato->nombre_medico . " " . $dato->apellidos_medico,
                    'nombre_especialidad' => $dato->nombre_especialidad,
                    'especialidad_id' => $dato->nombre_especialidad
                ];
            }
        }

        foreach ($consultaInfo as $dato) {
            // var_dump($dato);
            $medicoId = $dato->medico_id;
            if (isset($conteos[$medicoId])) {
                $conteos[$medicoId]['cantidad']++;
            } else {
                $conteos[$medicoId] = [
                    'cantidad' => 1,
                    'nombre_medico' => $dato->nombre_medico . " " . $dato->apellidos_medico,
                    'nombre_especialidad' => $dato->nombre_especialidad,
                    'especialidad_id' => $dato->especialidad_id
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

        usort($sumByMedico, function ($a, $b) {
            return $b['cantidad'] - $a['cantidad'];
        });

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($sumByMedico);

        return $respuesta->json(200);
    }

    public function allConsultasEspecialidades()
    {

        // Obtener la fecha de hoy
        $hoy = date('Y-m-d');

        // Calcular la fecha del domingo anterior
        $fechaInicio = date('Y-m-d', strtotime('last monday', strtotime($hoy)));

        $_consultaModel = new ConsultaModel();
        $consultaList = $_consultaModel->where('estatus_con', '=', 1);
        $consultaList =  $_consultaModel->whereDate("fecha_consulta", $fechaInicio, $hoy)->getAll();
        $_consultaModel->resetValues();

        $consultasFiltradas = [];

        foreach ($consultaList as $consulta) {
            if ($consulta->es_emergencia) {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaEmergencia($consulta, false);
            } else {
                $consultasFiltradas[] = ConsultaService::obtenerConsultaNormal($consulta);
            }
        }

        $consultaInfo = [];
        $consultasAseguradas = [];

        foreach ($consultasFiltradas as $consulta) {

            // Consultas normales
            if (isset($consulta->tipo_cita) && $consulta->tipo_cita = 1) {
                $consultaInfo[] = $consulta;
            } else {
                $consultasAseguradas[] = $consulta;
            }
        }

        $conteosEspecialidades = [];

        foreach ($consultasAseguradas as $dato) {

            $especialidadId = $dato->medico[0]->especialidad_id;
            if (isset($conteosEspecialidades[$especialidadId])) {
                $conteosEspecialidades[$especialidadId]['cantidad']++;
            } else {
                $conteosEspecialidades[$especialidadId] = [
                    'cantidad' => 1,
                    'nombre_especialidad' => $dato->medico[0]->nombre_especialidad
                ];
            }
        }

        foreach ($consultaInfo as $dato) {
            $especialidadId = $dato->especialidad_id;
            if (isset($conteosEspecialidades[$especialidadId])) {
                $conteosEspecialidades[$especialidadId]['cantidad']++;
            } else {
                $conteosEspecialidades[$especialidadId] = [
                    'cantidad' => 1,
                    'nombre_especialidad' => $dato->nombre_especialidad
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

        usort($sumByEspecialidad, function ($a, $b) {
            return $b['cantidad'] - $a['cantidad'];
        });

        $respuesta = new Response('CORRECTO');
        $respuesta->setData($sumByEspecialidad);

        return $respuesta->json(200);
    }
}
