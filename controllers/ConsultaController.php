<?php

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

        $es_emergencia = isset($_POST['es_emergencia']); // Validamos que el atributo emergencia sea booleano

        if ( $es_emergencia ) {
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
        $consultaList = $_consultaModel->where('estatus_con', '=', 1)->getAll();
        $consultas = [];
        
        foreach ($consultaList as $consulta) {
            if ($consulta->es_emergencia) {
                $consultas[] = ConsultaService::obtenerConsultaEmergencia($consulta);
            } else {
                $consultas[] = array_merge( (Array) ConsultaService::obtenerConsultaNormal($consulta), (Array) ConsultaHelper::obtenerRelaciones($consulta->consulta_id) ) ;
            }
        }
        
        $mensaje = (count($consultas) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($consultas);
        return $respuesta->json(200);
    }

    public function listarConsultasPorPaciente($paciente_id) {
        $params = isset($_GET['estatus']) ? $_GET['estatus'] : null;
        $lista_consultas = [];
        
        $consultaEmergenciaModel = new ConsultaEmergenciaModel();
        $consultasEmergencia = $consultaEmergenciaModel->where('paciente_id', '=', $paciente_id)->getAll();
        if ($consultasEmergencia != 0 && count($consultasEmergencia) > 0) {
            foreach ($consultasEmergencia as $consulta) {

                $consultasModel = new ConsultaModel();
                $consultasModel->where('consulta_id', '=', $consulta->consulta_id);

                if (!is_null($params)) {
                    $consultasModel->where('estatus_con', '=', $params);
                }
                
                $consulta_normal = $consultasModel->getFirst();
                
                if (!is_null($consulta_normal)) {
                    $consulta = ConsultaService::obtenerConsultaEmergencia($consulta);
                    $lista_consultas[] = array_merge((array) $consulta, (array) $consulta_normal);
                }
            }
        }

        $consultasSinCitaModel = new ConsultaSinCitaModel();
        $consultasSinCitas = $consultasSinCitaModel->where('paciente_id', '=', $paciente_id)->getAll();
        if ($consultasSinCitas != 0 && count($consultasSinCitas) > 0) {
            foreach ($consultasSinCitas as $consulta) {

                $consultasModel = new ConsultaModel();
                $consultasModel->where('consulta_id', '=', $consulta->consulta_id);
                
                if (!is_null($params)) {
                    $consultasModel->where('estatus_con', '=', $params);
                    
                }

                $consulta_normal = $consultasModel->getFirst();
                if (!is_null($consulta_normal)) {
                    $consulta = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
                    $lista_consultas[] = array_merge((array) $consulta, (array) ConsultaService::obtenerConsultaNormal($consulta_normal));
                }
            }
        }
        
        $consultasCitas = ConsultaService::obtenerConsultaPorCita($paciente_id);
        if ($consultasCitas != 0 && count($consultasCitas) > 0) {
            foreach ($consultasCitas as $consulta) {
                
                $consultasModel = new ConsultaModel();
                $consultasModel->where('consulta_id', '=', $consulta->consulta_id);

                if (!is_null($params)) {
                    $consultasModel->where('estatus_con', '=', $params);
                }

                $consulta_normal = $consultasModel->getFirst();
                if (!is_null($consulta_normal)) {
                    $consulta = array_merge((array) $consulta, (array) ConsultaHelper::obtenerRelaciones($consulta->consulta_id));
                    $lista_consultas[] = array_merge((array) $consulta, (array) $consulta_normal);
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
                                            ->where('estatus_ant', ($params ? '=' : '!='), ($params ? $params : '2'))
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
        $consultaList = $_consultaModel->where('estatus_con', '=', 1)
                                        ->where('consulta_id', '=', $consulta_id)
                                        ->getFirst();
        $consultas = [];
        
        if ($consultaList != null) {
            ($consultaList->es_emergencia) ?  $consultas[] = ConsultaService::obtenerConsultaEmergencia($consultaList) : $consultas[] = ConsultaService::obtenerConsultaNormal($consultaList);
            
            $informacion_consulta = $consultas[0];
            $relaciones = ConsultaHelper::obtenerRelaciones($informacion_consulta->consulta_id);
            $consulta_completa = array_merge((array) $informacion_consulta, (array) $relaciones);

            $mensaje = (count( $consulta_completa ) > 0);
            $respuesta = new Response('CORRECTO');
            $respuesta->setData( [ $consulta_completa ]);
            return $respuesta->json(200);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(400);
        }

    }
}
