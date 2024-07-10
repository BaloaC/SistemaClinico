<?php

include_once './services/Helpers.php';
include_once './services/consulta/consultaService.php';
include_once './services/consulta/consultaValidaciones.php';
include_once './services/consulta/consultaHelpers.php';
include_once './services/medico/medico/MedicoValidaciones.php';

class ConsultaController extends Controller {
    protected $consulta_id = "";

    //Método index (vista principal)
    public function index() {
        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas() {
        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($consulta_id) {
        return $this->view('consultas/actualizarConsultas', ['consulta_id' => $consulta_id]);
    }

    public function insertarConsulta(/*Request $request*/) {
        global $isEnabledAudit;
        $isEnabledAudit = 'consultas';

        $_POST = json_decode(file_get_contents('php://input'), true);

        $validarConsulta = new Validate;
        $es_emergencia = isset($_POST['es_emergencia']);

        if (!$es_emergencia) {
            ConsultaValidaciones::validarConsulta($_POST);
        } 
        
        // Validamos relaciones externas
        $examenes = isset($_POST['examenes']) ? $_POST['examenes'] : false;
        if ($examenes) {
            ConsultaValidaciones::validarConsultaExamen($examenes);
        }

        $recipe = isset($_POST['recipes']) ? $_POST['recipes'] : false;
        $indicaciones = isset($_POST['indicaciones']) ? $_POST['indicaciones'] : false;
        
        $insumos = isset($_POST['insumos']) ? $_POST['insumos'] : false;
        if ($insumos) { 
            ConsultaValidaciones::validarInsumos($insumos);
        }

        $referidos = isset($_POST['referidos']) ? $_POST['referidos'] : false;
        if ($referidos) { 
            ConsultaValidaciones::validarReferidos($referidos);
        }

        $es_emergencia = isset($_POST['es_emergencia']); // Validamos que el atributo emergencia sea booleano

        if ( $es_emergencia && $_POST['es_emergencia'] ) {
            $this->consulta_id = ConsultaService::insertarConsultaEmergencia($_POST);

        } else {
            
            $data = $validarConsulta->dataScape($_POST);
            $por_cita = isset($data['cita_id']);
            $consulta_separada = ConsultaHelper::separarInformación($_POST, $por_cita);
            
            // Validaciones generales si es por cita o si es sin cita
            if ($por_cita) {
                ConsultaValidaciones::validarEstatusCita($_POST);

            } else {
                MedicoValidaciones::validarMedicoImpartaEspecialidad($_POST);
            }

            // agregando el tipo_servicio
            if (isset($_POST['cita_id'])) {
                $_citaModel = new CitaModel();
                $cita = $_citaModel->where('cita_id', '=', $_POST['cita_id'])->getFirst();
                $consulta_separada[1]['tipo_servicio'] = $cita->tipo_servicio;
            }

            $_consultaModel = new ConsultaModel();
            $this->consulta_id = $_consultaModel->insert($consulta_separada[1]);
            $mensaje = ($this->consulta_id > 0);
            
            if ($por_cita && $mensaje) {

                $consulta_separada[0]['consulta_id'] = $this->consulta_id;
                ConsultaService::insertarConsultaPorCita($_POST, $consulta_separada);

            } else if (!$por_cita && $mensaje) {

                $consulta_separada[0]['consulta_id'] = $this->consulta_id;
                ConsultaService::insertarConsultaNormal($_POST, $consulta_separada);
            }
        }
        
        if ( $this->consulta_id > 0 ) {

            $respuesta = new Response('INSERCION_EXITOSA');

            $data["consulta_id"] = $this->consulta_id;
            $respuesta->setData($data);
            return $respuesta->json(201);
        } else {
            $respuesta = new Response('INSERCION_FALLIDA');
            return $respuesta->json(400);
        }
    }

    public function listarConsultas() {
        $_consultaModel = new ConsultaModel();

        if (isset($_GET['status'])) {
            $_consultaModel->where('estatus_con', '=', $_GET['status']);
        } else {
            $_consultaModel->where('estatus_con', '=', 1);
        }
        
        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_consultaModel->limit([$primer_registro, $size]);
            }

            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_consultaModel->where("CONCAT(consulta_id, ' ',observaciones)", 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_consultaModel->where("CONCAT(consulta_id, ' ',observaciones)", 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $consultaList =  $_consultaModel->getAll();
        $_consultaModel->resetValues();

        $consultas = [];
        foreach ($consultaList as $consulta) {
            if ($consulta->es_emergencia) {
                $consultas[] = ConsultaService::obtenerConsultaEmergencia($consulta, false);
            } else {
                $consultas[] = ConsultaService::obtenerConsultaNormal($consulta, false);
            }
        }

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_consultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta_id, ' ',observaciones)", 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_consultaModel->setSelect('COUNT(*) AS total')->where("CONCAT(consulta_id, ' ',observaciones)", 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_consultaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_consultaModel->setSelect('COUNT(*) AS total');
        }

        if (isset($_GET['status'])) {
            $_consultaModel->where('estatus_con', '=', $_GET['status']);
        } else {
            $_consultaModel->where('estatus_con', '=', 1);
        }

        $total_registros = $_consultaModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $consultas);
    }

    public function listarConsultasPorPaciente($paciente_id) {
        // $params = isset($_GET['estatus']) ? $_GET['estatus'] : null;
        $lista_consultas = [];
        
        $condicional_emergencia = "";
        if (isset($_GET['emergencia']) && $_GET['emergencia']) {
            $condicional_emergencia = $_GET['emergencia'];
        } else {
            $condicional_emergencia = false;
        }
        
        if ($condicional_emergencia) {
            $consultaEmergenciaModel = new ConsultaEmergenciaModel();
            $consultasEmergencia = $consultaEmergenciaModel->where('paciente_id', '=', $paciente_id)->getAll();
            if ($consultasEmergencia != 0 && count($consultasEmergencia) > 0) {
                foreach ($consultasEmergencia as $consulta) {
    
                    $consultasModel = new ConsultaModel();
                    $consultasModel->where('consulta_id', '=', $consulta->consulta_id);
    
                    if (isset($_GET['status'])) {
                        $consultasModel->where('estatus_con', '=', $_GET['status']);
                    }

                    if (isset($_GET['status_emer'])) {
                        $consultasModel->where('estatus_con', '=', $_GET['status_emer']);
                    }
                    
                    $consulta_normal = $consultasModel->getFirst();
                    
                    if (!is_null($consulta_normal)) {
                        $consulta = ConsultaService::obtenerConsultaEmergencia($consulta);
                        $lista_consultas[] = array_merge((array) $consulta, (array) $consulta_normal);
                    }
                }
            }
        }

        if (!isset($_GET['tipo_cita']) || $_GET['tipo_cita'] == 1) {
            $consultasSinCitaModel = new ConsultaSinCitaModel();
            $consultasSinCitas = $consultasSinCitaModel->where('paciente_id', '=', $paciente_id)->getAll();
            if ($consultasSinCitas != 0 && count($consultasSinCitas) > 0) {
                foreach ($consultasSinCitas as $consulta) {
                    $consultasModel = new ConsultaModel();
                    $consultasModel->where('consulta_id', '=', $consulta->consulta_id);
                    
                    if (isset($_GET['status'])) {
                        $consultasModel->where('estatus_con', '=', $_GET['status']);
                        
                    }
    
                    $consulta_normal = $consultasModel->getFirst();
                    if (!is_null($consulta_normal)) {
                        // $consulta = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
                        // $lista_consultas[] = array_merge((array) $consulta, (array) ConsultaService::obtenerConsultaNormal($consulta_normal));
                        $lista_consultas[] = ConsultaService::obtenerConsultaNormal($consulta_normal, false);
                    }
                }
            }
        }
        
        $consultasCitas = ConsultaService::obtenerConsultaPorCita($paciente_id, isset($_GET['tipo_cita']) ? $_GET['tipo_cita'] : null);
        if ($consultasCitas != 0 && count($consultasCitas) > 0) {
            foreach ($consultasCitas as $consulta) {    
                $consultasModel = new ConsultaModel();
                $consultasModel->where('consulta_id', '=', $consulta->consulta_id);

                if (isset($_GET['status'])) {
                    $consultasModel->where('estatus_con', '=', $_GET['status']);
                }

                $consulta_normal = $consultasModel->getFirst();
                if (!is_null($consulta_normal)) {
                    // $consulta = array_merge((array) $consulta, (array) ConsultaHelper::obtenerRelaciones($consulta->consulta_id));
                    // $lista_consultas[] = array_merge((array) $consulta, (array) $consulta_normal);
                    $lista_consultas[] = $consulta_normal;
                }
            }
        }

        $_antecedenteModel = new AntecedenteMedicoModel();
        $selectAntecedentes = [
            "antecedentes_medicos.descripcion",
            "antecedentes_medicos.antecedentes_medicos_id",
            "tipo_antecedente.nombre AS nombre"
        ];

        $innerAntecedentes = [
            "tipo_antecedente" => "antecedentes_medicos"
        ];

        $inners = $_antecedenteModel->listInner($innerAntecedentes);
        $antecedentList = $_antecedenteModel->where('antecedentes_medicos.paciente_id', '=', $paciente_id)
                                            ->where('estatus_ant', '!=', 2)
                                            ->innerJoin($selectAntecedentes, $inners, "antecedentes_medicos");

        if (count($antecedentList) > 0) {
            $resultado['antecedentes_medicos'] = $antecedentList;
        }

        $resultado['consultas'] = $lista_consultas;

        $mensaje = (count($resultado) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarConsultaPorId($consulta_id) {
        
        $_consultaModel = new ConsultaModel();
        $_consultaModel->where('consulta_id', '=', $consulta_id);

        if (isset($_GET['status'])) {
            $_consultaModel->where('estatus_con', '=', $_GET['status']);
        } else {
            $_consultaModel->where('estatus_con', '!=', 2);
        }
        
        $consultaList = $_consultaModel->getFirst();
        $consultas = [];
        
        if ($consultaList != null) {
            ($consultaList->es_emergencia) ?  $consultas[] = ConsultaService::obtenerConsultaEmergencia($consultaList) : $consultas[] = ConsultaService::obtenerConsultaNormal($consultaList);
            
            $informacion_consulta = $consultas[0];
            $relaciones = ConsultaHelper::obtenerRelaciones($informacion_consulta->consulta_id);
            $consulta_completa = array_merge((array) $informacion_consulta, (array) $relaciones);

            if (array_key_exists('cita_id', $consulta_completa)) {
                $_citaExamenModel = new CitaExamenModel();
                $innersExa = $_citaExamenModel->listInner(["examen" => "cita_examen"]);
                $examenes = $_citaExamenModel->where('cita_examen.cita_id', '=', $consulta_completa['cita_id'])
                                            ->where('cita_examen.estatus_cit', '=', 1)
                                            ->innerJoin(["examen.nombre", "examen.tipo", "cita_examen.precio_examen_bs", "cita_examen.precio_examen_usd"], $innersExa, "cita_examen");
                if ($examenes && count($examenes) > 0) {
                    $consulta_completa['cita_examenes'] = $examenes;
                }
            }
            
            $mensaje = (count( $consulta_completa ) > 0);
            $respuesta = new Response('CORRECTO');
            $respuesta->setData( [ $consulta_completa ]);
            return $respuesta->json(200);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(400);
        }

    }

    public function listarConsultasAseguradas() {
        $consultas_aseguradas = ConsultaService::obtenerConsultasAseguradas($_GET);
        $consultas_por_emergencia = ConsultaService::obtenerConsultasPorEmergencia($_GET);
        
        $cantidad_registros = count($consultas_aseguradas['lista_count']) + count($consultas_por_emergencia['lista_count']);
        $consultas = array_merge($consultas_aseguradas['lista'], $consultas_por_emergencia['lista']);
        
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $cantidad_registros, $consultas);
    }
}
