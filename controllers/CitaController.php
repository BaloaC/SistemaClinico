<?php

class CitaController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('citas/index');
    }

    public function formRegistrarCitas(){

        return $this->view('citas/registrarCitas');
    }

    public function formActualizarCita($cita_id){
        
        return $this->view('citas/actualizarCitas', ['cita_id' => $cita_id]);
    } 

    public function insertarCita(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
    
        // Creando los strings para las validaciones
        $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "cedula_titular", "tipo_cita", "medico_id");
        $camposString = array("motivo_cita");
        $camposExclude = array("clave");

        $campoId = array("paciente_id", "medico_id", "especialidad_id");
        
        $validarCita = new Validate;
        
        switch($_POST) {
            case ($validarCita->isEmpty($_POST, $camposExclude)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarCita->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarCita->isString($_POST, $camposString):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarCita->existsInDB($_POST, $campoId):   
                $respuesta = new Response('NOT_FOUND');         
                return $respuesta->json(404);

            case !$validarCita->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $_POST['medico_id'], 'medico_especialidad'):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarCita->isDataTime($_POST['fecha_cita']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarCita->isToday($_POST['fecha_cita'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case !$validarCita->isDuplicated('paciente', "cedula", $_POST['cedula_titular']):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case $validarCita->isDuplicatedId('medico_id', 'fecha_cita', $_POST['medico_id'], $_POST['fecha_cita'], 'cita'):
                $respuesta = new Response('DUPLICATE_APPOINTMENT');
                return $respuesta->json(400);

            case $validarCita->isDuplicatedId('paciente_id', 'fecha_cita', $_POST['paciente_id'], $_POST['fecha_cita'], 'cita'):
                $respuesta = new Response('DUPLICATE_APPOINTMENT');
                return $respuesta->json(400);

            case $_POST['tipo_cita'] == 1:
                $siEsNatural = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '1', 'paciente');
                $siEsAsegurado = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '2', 'paciente'); 
                
                // verificando si es un paciente beneficiario o natural
                if ( !$siEsNatural && !$siEsAsegurado ) {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(403);
                }

            case $_POST['tipo_cita'] == "2":
                if (!$validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '2', 'paciente')) {
                    $respuesta = new Response('DATOS_INVALIDOS');
                    return $respuesta->json(402);
                }

            default: 
                $data = $validarCita->dataScape($_POST);
                
                if ( $data['tipo_cita'] == 2 && !empty($data['clave']) ) {
                    
                    // Verificamos si la cita es de tipo asegurada y si la clave existe para que la cita sea asignada
                    $data['estatus'] = 1;
                
                } else if( $data['tipo_cita'] == 1 ) {

                    // Verificamos si es tipo natural para asignarla directamente
                    $data['estatus'] = 1;

                } else {

                    //  estatus es 1 para asignada, 2 para pendiente y 3 para eliminada
                    $data['estatus'] = 2;
                }

                $_citaModel = new CitaModel();
                $id = $_citaModel->insert($data);
                $mensaje = ($id > 0);
                
                $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarCitas(){

        $_citaModel = new CitaModel();
        $lista = $_citaModel->getAll();
        $mensaje = (count($lista) > 0);
     
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($lista);

        return $respuesta->json(200);
    }

    public function listarCitaPorId($cita_id){

        $_citaModel = new CitaModel();
        $cita = $_citaModel->where('cita_id','=',$cita_id)->getFirst();
        $mensaje = ($cita != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'ERROR');
        $respuesta->setData($cita);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function actualizarCita(){

        $_POST = json_decode(file_get_contents('php://input'), true);

        $_citaModel = new CitaModel();

        $actualizado = $_citaModel->where('cita_id','=',$_POST['cita_id'])->update($_POST);
        $mensaje = ($actualizado > 0);

        $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($actualizado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    public function eliminarCita($cita_id){

        $_citaModel = new CitaModel();

        $eliminado = $_citaModel->where('cita_id','=',$cita_id)->delete();
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>