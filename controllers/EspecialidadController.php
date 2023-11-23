<?php

include_once './services/medico/especialidad/especialidadValidaciones.php';
include_once './services/Helpers.php';

class EspecialidadController extends Controller{

    protected $arrayInner = array(
        "medico" => "medico_especialidad",
        "especialidad" => "medico_especialidad",
    );

    protected $arraySelect = array(
        "medico.medico_id",
        "medico.nombre",
        "medico.apellidos"
    );

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
        EspecialidadValidaciones::validacionesGenerales($_POST);
        
        $validarEspecialidad = new Validate;
        $data = $validarEspecialidad->dataScape($_POST);

        $_especialidadModel = new EspecialidadModel();
        $id = $_especialidadModel->insert($data);

        $mensaje = ($id > 0);

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        $respuesta->setData($data);
        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function listarEspecialidades(){
        $_especialidadModel = new EspecialidadModel();
        $especialidad = $_especialidadModel->where('estatus_esp', '=', '1')->getAll();
        $resultado = array();

        foreach ($especialidad as $especialidades) {

            $id = $especialidades->especialidad_id;
            $validarEspecialidad = new Validate;

            // Verificamos si hay que aplicarle un inner join a ese seguro en específico
            $respuesta = $validarEspecialidad->isDuplicated('medico_especialidad', 'especialidad_id', $id);
            $newArray = get_object_vars($especialidades);

            if($respuesta){

                $newArray['medicos'] = '';
                $_medicoModel = new MedicoModel();
                $inners = $_medicoModel->listInner($this->arrayInner);
                $medicoEspecialidad = $_medicoModel->where('especialidad.especialidad_id','=',$id)->where('especialidad.estatus_esp', '=', '1')->innerJoin($this->arraySelect, $inners, "medico_especialidad");
                $arrayMedico = array();

                foreach ($medicoEspecialidad as $medicos) {
                    // Guardamos cada empresa en un array
                    $arrayMedico[] = $medicos;
                }
                // Agregamos las empresas en el seguro al que pertenecen
                $newArray['medicos'] = $arrayMedico;
                $resultado[] = $newArray;

            } else { $resultado[] = $newArray; } // Si no necesita inner join, lo agregamos tal cual como está
        }

        $mensaje = ($resultado != null);
        Helpers::retornarMensaje($mensaje, $resultado);
    }

    public function listarEspecialidadPorId($especialidad_id){

        $_especialidadModel = new EspecialidadModel();
        $medico = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->where('estatus_esp', '=', '1')->getFirst();
        $mensaje = ($medico != null);

        Helpers::retornarMensaje($mensaje, $medico);
    }

    public function actualizarEspecialidad($especialidad_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        EspecialidadValidaciones::validacionesGenerales($_POST);
        EspecialidadValidaciones::validarExistenciaEspecialidad($especialidad_id);

        $validarEspecialidad = new Validate;
        $data = $validarEspecialidad->dataScape($_POST);

        $_especialidadModel = new EspecialidadModel();
        $actualizado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->update($data);

        $mensaje = ($actualizado > 0);
        
        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);
        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarEspecialidad($especialidad_id){

        $_especialidadModel = new EspecialidadModel();
        $validarEspecialidad = new Validate;

        $data = array(
            "estatus_esp" => "2"
        );

        $eliminado = $_especialidadModel->where('especialidad_id','=',$especialidad_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
