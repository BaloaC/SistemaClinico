<?php

class MedicoController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('medicos/index');
    }

    public function formRegistrarMedicos(){

        return $this->view('medicos/registrarMedicos');
    }

    public function formActualizarMedico($idMedico){
        
        return $this->view('medicos/actualizarMedicos', ['idMedico' => $idMedico]);
    } 

    public function insertarMedico(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "telefono", "paciente_id");
        $camposString = array("nombres", "apellidos", "direccion");
        $validarMedico = new Validate;

        switch($_POST) {
            case ($validarMedico->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarMedico->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarMedico->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);
            default:
                $newForm = array("especialidad_id" => $_POST['especialidad_id']);
                $data = $validarMedico->dataScape($_POST);
                unset($data['especialidad_id']);
                $_medicoModel = new MedicoModel();
                $id = $_medicoModel->insert($data);
                
                if ($id > 0) {
                    $insertarEspecialidad = new MedicoEspecialidadController;
                    $mensaje = $insertarEspecialidad->insertarMedicoEspecialidad($newForm);
                    
                    if ($mensaje == true) {
                        
                        return $mensaje;
                    } else {
                     
                        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                        return $respuesta->json($mensaje ? 201 : 400);
                    }
                }
        }
    }

    public function listarMedicos(){

        $_medicoModel = new MedicoModel();
        $lista = $_medicoModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarMedicoPorId($medico_id){

        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('medico_id','=',$medico_id)->getFirst();
        $mensaje = ($medico != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($medico);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function RetornarID($cedula){

        $_medicoModel = new MedicoModel();
        $medico = $_medicoModel->where('cedula','=',$cedula)->getFirst();
        $mensaje = ($medico != null);
        $respuesta = $mensaje ? $medico->medico_id : false;
        return $respuesta;
        
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
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400); 
            case $validarMedico->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400); 
            case $validarMedico->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400); 
            case $validarMedico->existsInDB($_POST, $camposKey):   
                $respuesta = new Response('NOT_FOUND'); 
                return $respuesta->json(404); 
            case array_key_exists('cedula', $_POST):
                if ( $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]) ) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400); 
                }
            case !$validarMedico->isDuplicated('medico', 'medico_id', $medico_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            default: 
                $data = $validarMedico->dataScape($_POST);
                $_medicoModel = new MedicoModel();

                if ( array_key_exists('especialidad_id', $data) ) {
                    $especialidad = array(
                        'especialidad_id' => $data['especialidad_id'],
                        'medico_id' => $medico_id
                    );

                    $insertarEspecialidad = new MedicoEspecialidadController;
                    $mensajeEspecialidad = $insertarEspecialidad->actualizarMedicoEspecialidad($especialidad);
                    unset($data['especialidad_id']);
                    $validarData = $validarMedico->isEmpty($data);

                    if ($mensajeEspecialidad == false) {
                        if ($validarData != true) {
                        
                            $actualizado = $_medicoModel->where('medico_id','=',$especialidad['medico_id'])->update($data);
                            $mensaje = ($actualizado > 0);
    
                            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                            $respuesta->setData($actualizado);
    
                            return $respuesta->json($mensaje ? 200 : 400);
                        } else {
                            
                            $respuesta = new Response('ACTUALIZACION_EXITOSA');
                                return $respuesta->json(200);
                        }
                    } else {
                        return 'esta cayendo aki';
                    }      

                } else {
                    $actualizado = $_medicoModel->where('medico_id','=',$medico_id)->update($data);
                    $mensaje = ($actualizado > 0);

                    $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                    $respuesta->setData($actualizado);
                    return $respuesta->json($mensaje ? 200 : 400);
                }
            }

                
                
    }
 

    public function eliminarMedico($medico_id){

        $_medicoModel = new MedicoModel();

        $eliminado = $_medicoModel->where('medico_id','=',$medico_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>