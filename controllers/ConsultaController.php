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
        
        $_POST = json_decode(file_get_contents('php://input'), true);

        $validarConsulta = new Validate;
        $es_emergencia = isset($_POST['es_emergencia']);

        if (!$es_emergencia) {
            ConsultaValidaciones::validarConsulta($_POST);
        } 
        
        // Validamos relaciones externas
        $examenes = isset($_POST['examenes']) ? $_POST['examenes'] : false;
        if ($examenes) {
            // unset($_POST['examenes']); 
            ConsultaValidaciones::validarConsultaExamen($examenes);
        }

        $recipe = isset($_POST['recipes']) ? $_POST['recipes'] : false;
        $indicaciones = isset($_POST['indicaciones']) ? $_POST['indicaciones'] : false;
        
        $insumos = isset($_POST['insumos']) ? $_POST['insumos'] : false;
        if ($insumos) { 
            // unset($_POST['insumos']);
            ConsultaValidaciones::validarInsumos($insumos);
        }

        // if ($recipe) { unset($_POST['recipes']); }
        // if ($indicaciones) { unset($_POST['indicaciones']); }

        $es_emergencia = isset($_POST['es_emergencia']); // Validamos que el atributo emergencia sea booleano

        if ( $es_emergencia ) {
            ConsultaService::insertarConsultaEmergencia($_POST);

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
        
        if ( $this->consulta_id > 0) {

            // if (isset($data['cita_id'])) {
            //     $_citaModel = new CitaModel;
            //     $cita_previa = $_citaModel->where('cita_id', '=', $data['cita_id'])->getFirst();
            // }

            // if ($examenes) {
            //     if ($cita_previa->tipo_cita == 1 || !$por_cita && !$es_emergencia) {
            //         ConsultaHelper::insertarExamen($examenes, $this->consulta_id);
            //     }

            //     if ($cita_previa->tipo_cita == 2 || $es_emergencia) {
            //         ConsultaHelper::insertarExamenesSeguro($examenes, $this->consulta_id);
            //     }
            // }

            // if ($insumos) {
            //     if ($cita_previa->tipo_cita == 1 || !$por_cita && !$es_emergencia) {
            //         ConsultaHelper::insertarInsumo($insumos, $this->consulta_id, false);
            //     }

            //     if ($cita_previa->tipo_cita == 2 || $es_emergencia) {
            //         ConsultaHelper::insertarInsumo($insumos, $this->consulta_id, true);
            //     }
            // }

            // if ($recipe) {
            //     ConsultaHelper::insertarRecipe($recipe, $this->consulta_id);
            // }

            // if ($indicaciones) {
            //     ConsultaHelper::insertarIndicaciones($indicaciones, $this->consulta_id);
            // }

            $respuesta = new Response('INSERCION_EXITOSA');

            // if ( isset($data['cita_id']) ) {
            
            //     $cambioEstatus = array('estatus_cit' => '4');
            //     $_citaModel = new CitaModel;
            //     $res = $_citaModel->where('cita_id', '=', $data['cita_id'])->update($cambioEstatus);
                
            //     if ($res <= 0) {
            //         $respuesta->setData('La consulta fue insertada, pero la cita no fue actualizada correctamente, por favor actualicela manualmente para evitar errores');
            //     }
            // }

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
                // $consulta[] = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
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

        $consultaList = $this->listarConsultas();
        $consultas = json_decode($consultaList)->data;
        
        $consultasPaciente = array_filter($consultas, fn($consulta) => $consulta->paciente_id == $paciente_id);
        
        $consultasArray = [];
        foreach ($consultasPaciente as $consulta) {
            $consultasArray[] = $consulta;
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
        $antecedentList = $_antecedenteModel->where('estatus_ant', '!=', '2')
                                    ->where('antecedentes_medicos.paciente_id', '=', $paciente_id)
                                    ->innerJoin($selectAntecedentes, $inners, "antecedentes_medicos");

        if (count($antecedentList) > 0) {
            $resultado['antecedentes_medicos'] = $antecedentList;
        }

        $consultasCompletas = [];

        if (count($consultasArray)) {
            foreach ($consultasArray as $consulta) {
                $consultasCompletas[] = ConsultaHelper::obtenerRelaciones($consulta->consulta_id);
            }
    
            if ( count($consultasCompletas) > 0) {
                $consulta = (object) array_merge((array) $consulta, (array) $consultasCompletas);
            }
        }
        
        $resultado['consultas'] = $consultasArray;

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
