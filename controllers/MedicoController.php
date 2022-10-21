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
        $camposNumericos = array("cedula", "telefono");
        $camposString = array("nombres", "apellidos", "direccion");
        $validarMedico = new Validate;

        switch($_POST) {
            case ($validarMedico->isEmpty($_POST)):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->isNumber($_POST, $camposNumericos):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->isString($_POST, $camposString):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]):
                return $respuesta = new Response('DATOS_DUPLICADOS');
            default: 
            $data = $validarMedico->dataScape($_POST);

            $_medicoModel = new MedicoModel();
            $id = $_medicoModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');

            return $respuesta->json($mensaje ? 200 : 400);
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

    public function actualizarMedico($medico_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("cedula", "telefono");
        $camposString = array("nombres", "apellidos", "direccion");
        $camposKey = array("medico_id");
        $validarMedico = new Validate;

        switch($_POST) {
            case ($validarMedico->isEmpty($_POST)):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->isNumber($_POST, $camposNumericos):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->isString($_POST, $camposString):
                return $respuesta = new Response('DATOS_INVALIDOS');
            case $validarMedico->existsInDB($_POST, $camposKey):   
                return $respuesta = new Response('NOT_FOUND'); 
            case array_key_exists('cedula', $_POST):
                if ( $validarMedico->isDuplicated('medico', 'cedula', $_POST["cedula"]) ) {
                    return $respuesta = new Response('DATOS_DUPLICADOS');
                }
            default: 
            $data = $validarMedico->dataScape($_POST);

            $_medicoModel = new MedicoModel();
            $actualizado = $_medicoModel->where('medico_id','=',$medico_id)->update($_POST);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);

            return $respuesta->json($mensaje ? 200 : 400);
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