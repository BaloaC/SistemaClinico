<?php

class MedicoController extends Controller{

    protected $arrayInnerHorario = array (
        "medico" => "horario"
    );

    protected $arraySelectHorario = array(
        "horario.dias_semana"
    );

    protected $arrayInner = array(
        "medico" => "medico_especialidad",
        "especialidad" => "medico_especialidad",
    );

    protected $arraySelect = array(
        "*"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('medicos/index');
    }

    public function formRegistrarMedicos(){

        return $this->view('medicos/registrarMedicos');
    }

    public function formActualizarMedico($medico_id){
        
        return $this->view('medicos/actualizarMedicos', ['medico_id' => $medico_id]);
    } 

    public function insertarMedico(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "telefono", "paciente_id");
        $camposString = array("nombres", "apellidos", "direccion");
        $validarMedico = new Validate;

        switch($_POST) {
            // case ($validarMedico->isEmpty($_POST)):
            //     $respuesta = new Response('DATOS_INVALIDOS');
            //     return $respuesta->json(400);

            // case $validarMedico->isNumber($_POST, $camposNumericos):
            //     $respuesta = new Response('DATOS_INVALIDOS');
            //     return $respuesta->json(400);

            // case $validarMedico->isString($_POST, $camposString):
            //     $respuesta = new Response('DATOS_INVALIDOS');
            //     return $respuesta->json(400);

            // case $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]):
            //     $respuesta = new Response('DATOS_DUPLICADOS');
            //     return $respuesta->json(400);

            default:
                
                // Extrayendo la información de las tablas foráneas
                $especialidad = $_POST['especialidad'];
                $horario = $_POST['horario'];
                unset($_POST['especialidad']);
                unset($_POST['horario']);
                
                $data = $validarMedico->dataScape($_POST);
                
                $_medicoModel = new MedicoModel();
                $id = $_medicoModel->insert($data);
                
                // Comprobando que se haya insertado el médico para formar las relaciones
                if ($id > 0) {
                    $insertarEspecialidad = new MedicoEspecialidadController;
                    $mensaje = $insertarEspecialidad->insertarMedicoEspecialidad($especialidad, $id);
                    
                    if ($mensaje == true) { return $mensaje; 
                    } else {

                        $insertarHorario = new HorarioController;
                        $mensaje = $insertarHorario->insertarHorario($horario, $id);
                        
                        if ($mensaje == true) { return $mensaje; 
                        } else {

                            $respuesta = new Response('INSERCION_EXITOSA');
                            return $respuesta->json(201);
                        }
                    }
                } else {

                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarMedicos(){      

        $_medicoModel = new MedicoModel();
        $medico2 = $_medicoModel->where('estatus_med','=','1')->getAll();

        if ($medico2) {
            $resultado = array();

            foreach ($medico2 as $medicos) {

                $_medicoModel = new MedicoModel();
                $inners = $_medicoModel->listInner($this->arrayInner);
                $medico = $_medicoModel->where('medico.medico_id','=',$medicos->medico_id)->where('medico.estatus_med','=','1')->innerJoin($this->arraySelect, $inners, "medico_especialidad");
                
                if ($medico) {
                    $medicos=$medico;
                }
                
                $_medicoModel = new MedicoModel();
                $innersH = $_medicoModel->listInner($this->arrayInnerHorario);
                $horario = $_medicoModel->where('medico.medico_id','=',$medicos[0]->medico_id)->where('medico.estatus_med','=','1')->innerJoin($this->arraySelectHorario, $innersH, "horario");
                
                if ($horario) {
                    $medico[0]->horario = $horario;
                }
                
                $arrayMedico = get_object_vars($medicos[0]);
                $resultado[] = $arrayMedico;
            }

            $respuesta = new Response($resultado ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($resultado);
            return $respuesta->json($resultado ? 200 : 404);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
        }
    }

    public function listarMedicoPorId($medico_id){
        
        $_medicoModel = new MedicoModel();
        $innersEspecialidad = $_medicoModel->listInner($this->arrayInner);
        
        $medico = $_medicoModel->where('medico.medico_id','=',$medico_id)->where('medico.estatus_med','=','1')->innerJoin($this->arraySelect, $innersEspecialidad, "medico_especialidad");
        
        $mensaje = ($medico != null);
        
        if ( !$mensaje ) {
            
            $_medicoModel = new MedicoModel();
            $medico = $_medicoModel->where('medico_id','=',$medico_id)->where('medico.estatus_med','=','1')->getFirst();

            if ($medico) { $newArray = get_object_vars($medico);
            }else { $newArray=false; }
            
        }

        // formando la relación medico/horario
        $_medicoModel = new MedicoModel();
        $innersHorario = $_medicoModel->listInner($this->arrayInnerHorario);
        
        $medico2 = $_medicoModel->where('medico.medico_id','=',$medico_id)->where('medico.estatus_med','=','1')->innerJoin($this->arraySelectHorario, $innersHorario, "horario");
        $mensaje2 = ($medico2 != null);
        
        if ( $mensaje2 ) {
            
            $medico[0]->horario = $medico2;
        }

            $respuesta = new Response($medico ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($medico);
            return $respuesta->json($mensaje ? 200 : 404);
    }

    public function actualizarMedico($medico_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "telefono","especialidad_id");
        $camposString = array("nombres", "apellidos", "direccion");
        $camposKey = array("medico_id");
        $validarMedico = new Validate;

        switch($_POST) {
            
            case ($validarMedico->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarMedico->isEliminated("medico", 'estatus_med', $medico_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarMedico->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400); 

            case $validarMedico->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400); 

            case $validarMedico->existsInDB($_POST, $camposKey):   
                $respuesta = new Response('NOT_FOUND'); 
                return $respuesta->json(404); 

            case !$validarMedico->isDuplicated('medico', 'medico_id', $medico_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);
            
            case array_key_exists('cedula', $_POST):
                if ( $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]) ) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400); 
                }

            default: 
                
                if ( array_key_exists('especialidad', $_POST) ) {
                    $especialidad = $_POST['especialidad'];
                    unset($data['especialidad']);

                    $insertarEspecialidad = new MedicoEspecialidadController;
                    $mensajeEspecialidad = $insertarEspecialidad->insertarMedicoEspecialidad($especialidad, $medico_id);
                    
                    if ($mensajeEspecialidad == false) { return $mensajeEspecialidad; }
                }

                if ( array_key_exists('horario', $_POST) ) {
                    $horario = $_POST['horario'];
                    unset($data['horario']);

                    $insertarHorario = new HorarioController;
                    $mensaje = $insertarHorario->insertarHorario($horario, $medico_id);
                    
                    if ($mensajeEspecialidad == false) { return $mensajeEspecialidad; }
                }

                $data = $validarMedico->dataScape($_POST);

                if (!empty($data)) {
                        
                    $_medicoModel = new MedicoModel();
                    $actualizado = $_medicoModel->where('medico_id','=',$especialidad['medico_id'])->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);

                    return $respuesta->json($mensaje ? 200 : 400);

                } else {

                    $respuesta = new Response(true, 'Información insertada correctamente');
                    return $respuesta->json(201); 
                }        
        }
    }

    public function eliminarMedico($medico_id){

        $_medicoModel = new MedicoModel();
        $data = array(
            "estatus_med" => "2"
        );

        $eliminado = $_medicoModel->where('medico_id','=',$medico_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>