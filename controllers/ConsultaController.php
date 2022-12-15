<?php

class ConsultaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas(){

        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($idConsulta){
        
        return $this->view('consultas/actualizarConsultas', ['idConsulta' => $idConsulta]);
    } 

    public function insertarConsulta(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "peso", "altura");
        $campoId = array("paciente_id", "medico_id", "especialidad_id");
        $validarConsulta = new Validate;

        switch ($validarConsulta) {
            case ($validarConsulta->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
            
            case $validarConsulta->isEliminated("paciente", 'estatus_pac', $_POST['paciente_id']):
                $respuesta = new Response('PAT_NOT_FOUND');
                return $respuesta->json(404);

            case $validarConsulta->isEliminated("medico", 'estatus_med', $_POST['medico_id']):
                $respuesta = new Response('MD_NOT_FOUND');
                return $respuesta->json(404);

            case $validarConsulta->isEliminated("especialidad", 'estatus_esp', $_POST['especialidad_id']):
                $respuesta = new Response('SPE_NOT_FOUND');
                return $respuesta->json(404);

            case !$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $_POST['medico_id'], 'medico_especialidad'):
                $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
                return $respuesta->json(404);

            case $validarConsulta->isDuplicatedId('paciente_id', 'fecha_consulta', $_POST['paciente_id'], $_POST['fecha_consulta'], 'consulta'):
                $respuesta = new Response(false, 'La consulta ya se encuentra registrada en el sistema');
                return $respuesta->json(400);

            case $validarConsulta->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarConsulta->existsInDB($_POST, $campoId):   
                $respuesta = new Response('NOT_FOUND');         
                return $respuesta->json(404);

            case $validarConsulta->isDate($_POST['fecha_consulta']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarConsulta->isToday($_POST['fecha_consulta'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            default:

                $examenes = $_POST['examenes'];
                unset($_POST['examenes']);
                $data = $validarConsulta->dataScape($_POST);
                
                $_consultaModel = new ConsultaModel();
                $id = $_consultaModel->insert($data);
                $mensaje = ($id > 0);

                if ($mensaje) {
                    
                    if ($examenes) {
                        
                        $_consultaExamen = new ConsultaExamenController;
                        $bool = $_consultaExamen->insertarConsultaExamen($examenes,$id);
                        
                        if ($bool == true) {
                        
                            return $bool;

                        } else {
                          
                            $respuesta = new Response('INSERCION_EXITOSA');
                            return $respuesta->json(201);
                        }

                    } else {
 
                        $respuesta = new Response('INSERCION_EXITOSA');
                        return $respuesta->json(201);
                    }
                    
                    
                } else {

                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarConsultas(){

        $arrayInner = array (
            "paciente" => "consulta",
            "medico" => "consulta",
            "especialidad" => "consulta"
        );

        $arraySelect = array(
            "paciente.nombres AS nombre_paciente", 
            "medico.nombres AS nombre_medico", 
            "especialidad.nombre AS nombre_especialidad", 
            "consulta.consulta_id", 
            "consulta.paciente_id", 
            "consulta.medico_id", 
            "consulta.especialidad_id", 
            "consulta.peso", 
            "consulta.altura", 
            "consulta.observaciones", 
            "consulta.fecha_consulta"
        );

        $_consultaModel = new ConsultaModel();
        $inners = $_consultaModel->listInner($arrayInner);
        $lista = $_consultaModel->where('estatus_con','=','1')->innerJoin($arraySelect, $inners, "consulta");

        $mensaje = (count($lista) > 0);     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarConsultaPorId($consulta_id){

        $arrayInner = array (
            "paciente" => "consulta",
            "medico" => "consulta",
            "especialidad" => "consulta"
        );

        $arraySelect = array(
            "paciente.nombres AS nombre_paciente", 
            "medico.nombres AS nombre_medico", 
            "especialidad.nombre AS nombre_especialidad", 
            "consulta.consulta_id", 
            "consulta.paciente_id", 
            "consulta.medico_id", 
            "consulta.especialidad_id", 
            "consulta.peso", 
            "consulta.altura", 
            "consulta.observaciones", 
            "consulta.fecha_consulta"
        );

        $_consultaModel = new ConsultaModel();
        $inners = $_consultaModel->listInner($arrayInner);
        $consulta = $_consultaModel->where('consulta_id','=',$consulta_id)->where('estatus_con','=','1')->innerJoin($arraySelect, $inners, "consulta");
        $mensaje = ($consulta != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($consulta);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function actualizarConsulta($consulta_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "peso", "altura");
        $validarConsulta = new Validate;

        switch ($validarConsulta) {
            case ($validarConsulta->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);
                
            case $validarConsulta->isEliminated("consulta", 'estatus_con', $consulta_id):
                $respuesta = new Response(false, 'La consulta introducida no se encuentra en el sistema');
                return $respuesta->json(404);                

            case $validarConsulta->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
                
            default:
                                
                if ( array_key_exists("paciente_id", $_POST) ) {
                    if ($validarConsulta->isEliminated("paciente", 'estatus_pac', $_POST['paciente_id'])) {
                        $respuesta = new Response('PAT_NOT_FOUND');
                        return $respuesta->json(404);
                    } elseif (!$validarConsulta->isDuplicated('paciente', 'paciente_id', $_POST['paciente_id'])) {
                        $respuesta = new Response('PAT_NOT_FOUND');         
                        return $respuesta->json(404);
                    } 
                }

                if ( array_key_exists("especialidad_id", $_POST) ) {

                    $_consultaModel = new ConsultaModel();
                    $especialidadConsulta = $_consultaModel->where('consulta_id','=',$consulta_id)->getFirst();
                    $medicoConsulta = $especialidadConsulta->medico_id;

                    if ($validarConsulta->isEliminated("especialidad", 'estatus_esp', $_POST['especialidad_id'])) {
                        $respuesta = new Response('SPE_NOT_FOUND');
                        return $respuesta->json(404);
                    } elseif (!$validarConsulta->isDuplicated('especialidad', 'especialidad_id', $_POST['especialidad_id'])) {
                        $respuesta = new Response('SPE_NOT_FOUND');         
                        return $respuesta->json(404);
                    } else if (!$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $medicoConsulta, 'medico_especialidad')) {
                        $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
                        return $respuesta->json(404);
                    }                    

                }

                if ( array_key_exists("medico_id", $_POST) ) {
                    
                    $_consultaModel = new ConsultaModel();
                    $medicoConsulta = $_consultaModel->where('consulta_id','=',$consulta_id)->getFirst();
                    $especialidadConsulta = $medicoConsulta->especialidad_id;

                    if ($validarConsulta->isEliminated("medico", 'estatus_med', $_POST['medico_id'])) {
                        $respuesta = new Response('MD_NOT_FOUND');
                        return $respuesta->json(404);
                    } elseif (!$validarConsulta->isDuplicated('medico', 'medico_id', $_POST['medico_id'])) {
                        $respuesta = new Response('MD_NOT_FOUND');         
                        return $respuesta->json(404);
                    } else if (!$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $especialidadConsulta, $_POST['medico_id'], 'medico_especialidad')) {
                        $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
                        return $respuesta->json(404);
                    }
                }

                if ( array_key_exists('fecha_consulta', $_POST) ) {
                    if ( $validarConsulta->isDate($_POST['fecha_consulta'])) {

                        $respuesta = new Response('FECHA_INVALIDA');
                        return $respuesta->json(400);
                        
                    } else if ($validarConsulta->isToday($_POST['fecha_consulta'], true)) {
                        
                        $respuesta = new Response('FECHA_INVALIDA');
                        return $respuesta->json(400);
                    }
                    
                }

                if ( array_key_exists('examenes', $_POST) ) {
                    
                    $_consultaExamen = new ConsultaExamenController;
                    $bool = $_consultaExamen->actualizarConsultaExamen($_POST['examenes'],$consulta_id);
                    
                    if ($bool == true) {
                    
                        return $bool;

                    } else {
                        $_consultaModel = new ConsultaModel();
                        unset($_POST['examenes']);
                        $data = $validarConsulta->dataScape($_POST);

                        $actualizado = $_consultaModel->where('consulta_id','=',$consulta_id)->where('estatus_con','=','1')->update($data);
                        $mensaje = ($actualizado > 0);

                        if (!$bool && $mensaje) {
                            
                            $respuesta = new Response(true, 'Todos los datos han sido actualizados exitosamente');
                            return $respuesta->json(200);
                            
                        } else if ($bool && $mensaje) {
                            
                            $respuesta = new Response(true, 'Ha ocurrido un error con los exámenes');
                            return $respuesta->json(400);

                        } else if (!$bool && !$mensaje) {

                            $respuesta = new Response(true, 'Ha ocurrido un error con los datos');
                            return $respuesta->json(400);

                        }
                    }
                }
                
                $data = $validarConsulta->dataScape($_POST);
                $_consultaModel = new ConsultaModel();
                $actualizado = $_consultaModel->where('consulta_id','=',$consulta_id)->where('estatus_con','=','1')->update($data);
                $mensaje = ($actualizado > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);
                return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarConsulta($consulta_id){

        $_consultaModel = new ConsultaModel();
        $data = array (
            "estatus_con" => "2"
        );

        $eliminado = $_consultaModel->where('consulta_id','=',$consulta_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>