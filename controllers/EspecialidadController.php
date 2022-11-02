<?php

class EspecialidadController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('especialidades/index');
    }

    public function formRegistrarEspecialidades(){

        return $this->view('especialidades/registrarEspecialidades');
    }

    public function formActualizarEspecialidad($especialidad_id){
        
        return $this->view('especialidades/actualizarEspecialidades', ['especialidad_id' => $especialidad_id]);
    } 

    public function insertarEspecialidad(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposString = array("nombre");
        $validarEspecialidad = new Validate;

        switch($_POST) {
            case $validarEspecialidad->isEmpty($_POST):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarEspecialidad->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarEspecialidad->isDuplicated('especialidad', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);
            default: 
            $data = $validarEspecialidad->dataScape($_POST);

            $_especialidadModel = new EspecialidadModel();
            $id = $_especialidadModel->insert($data);
            $mensaje = ($id > 0);

            $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
            
            return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarEspecialidades(){

        $_especialidadModel = new EspecialidadModel();
        $lista = $_especialidadModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarEspecialidadPorId($especialidad_id){

        $_especialidadModel = new EspecialidadModel();
        $medico = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->getFirst();
        $mensaje = ($medico != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($medico);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarEspecialidad($especialidad_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposString = array("nombres");
        $camposKey = array("especialidad_id");
        $validarEspecialidad = new Validate;

        switch($_POST) {
            case ($validarEspecialidad->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarEspecialidad->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);
            case $validarEspecialidad->existsInDB($_POST, $camposKey):   
                $respuesta = new Response('NOT_FOUND'); 
                return $respuesta->json(404);
            case $validarEspecialidad->isDuplicated('especialidad', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);
            //     }
            default: 
            $data = $validarEspecialidad->dataScape($_POST);

            $_especialidadModel = new EspecialidadModel();
            $actualizado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->update($data);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);

            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarEspecialidad($especialidad_id){

        $_especialidadModel = new EspecialidadModel();

        $eliminado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>