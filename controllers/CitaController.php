<?php

class CitaController extends Controller{

    protected $arraySelect = array (
        "paciente.nombres AS nombre_paciente",
        "medico.nombres AS nombre_medico",
        "especialidad.nombre AS nombre_especialidad",
        "seguro.nombre AS nombre_seguro",
        "cita.cita_id",
        "cita.paciente_id",
        "cita.medico_id",
        "cita.especialidad_id",
        "cita.seguro_id",
        "cita.fecha_cita",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.clave",
        "cita.tipo_cita",
        "cita.estatus_cit"
    );

    protected $arrayInner = array (
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita",
        "seguro" => "cita"
    );

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
        $campoId = array("paciente_id", "medico_id", "especialidad_id", "cita_id");
        
        $validarCita = new Validate;

        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }
        
        switch($_POST) {
            
            case ($validarCita->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case !$validarCita->existsInDB($_POST, $campoId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

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

            default: 

                $data = $validarCita->dataScape($_POST);

                // verificaciones si la cita es asegurada
                if ($data['tipo_cita'] == 2 ) {
                    
                    // verificamos que pueda solicitar cita asegurada
                    $siEsTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '2', 'paciente');
                    $siEsBeneficiario = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '3', 'paciente');
                    $siSeguroAsociado = $validarCita->isDuplicatedId('paciente_id', 'seguro_id', $_POST['paciente_id'], $_POST['seguro_id'], 'paciente_seguro');

                    if(!$siSeguroAsociado){
                        $respuesta = new Response(false, 'Ese seguro no se encuentra asociado con el paciente indicado');
                        return $respuesta->json(400);
                    }

                    if (!$siEsTitular && !$siEsBeneficiario) {
                        $respuesta = new Response(false, 'El paciente ingresado no está registrado como asegurado');
                        return $respuesta->json(400);
                    }

                    // verificamos que el titular pueda ser titular
                    $esTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], 2, 'paciente');
                    if (!$esTitular) {
                        $respuesta = new Response(false, 'La cédula no pertenece a ningún titular de seguro');
                        return $respuesta->json(404);
                    }

                    // Asignamos el estatus dependiendo del contenido del campo clave
                    if (array_key_exists("clave", $data)) {
                        
                        $verClave = empty($data['clave']);
                        $data['clave'] = ($verClave ? 3 : 1 );

                    } else { $data['estatus_cit'] = 3; }

                } else {

                    $_citaModel = new CitaModel();
                    $id = $_citaModel->where('cedula_titular', '=', $_POST['cedula_titular'])->getFirst();
                    // $id = $_pacienteController->RetornarID($_POST['cedula_titular']);


                    // ** Enrique (Esta validacion no funciona)
                    // if ( $id->paciente_id != $_POST['paciente_id'] ) {
                        
                    //     $respuesta = new Response(false, 'La cédula no coincide con el paciente ingresado');
                    //     return $respuesta->json(400);
                    // }

                    $data['estatus_cit'] = 1;
                }

                $_citaModel = new CitaModel();
                $_citaModel->byUser($token);
                $id = $_citaModel->insert($data);
                $mensaje = ($id > 0);
                
                $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarCitas(){

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('estatus_cit','!=','2')->innerJoin($this->arraySelect, $inners, "cita");
        
        return $this->retornarMensaje($lista);
    }

    public function listarCitaPorId($cita_id){

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($this->arrayInner);
        $lista = $_citaModel->where('cita_id','=',$cita_id)->where('estatus_cit','!=','2')->innerJoin($this->arraySelect, $inners, "cita");
        
        return $this->retornarMensaje($lista);
    }

    public function listarCitaPorPacienteId($paciente_id){

        $_citaModel = new CitaModel();
        $lista = $_citaModel->where('estatus_cit','!=','2')->where('paciente_id','=',$paciente_id)->getAll();
        $mensaje = ($lista != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function actualizarCita($cita_id){

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarCita = new Validate;

        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch ($validarCita) {
            case $validarCita->isEmpty($_POST):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

                // ** Enrique
            case !$validarCita->isDuplicated('cita', 'cita_id', $cita_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(400);    

            case !$validarCita->isDuplicatedId('cita_id','estatus_cit', $cita_id,3, 'cita'):
                $respuesta = new Response(false, 'La cita seleccionada ya se encuentra asignada');
                return $respuesta->json(400);

            default:
            
                $data = $validarCita->dataScape($_POST);
                $newArray['estatus_cit'] = 1;
                $newArray['clave'] = $data['clave'];
                
                $_citaModel = new CitaModel();
                $_citaModel->byUser($token);

                $actualizado = $_citaModel->where('cita_id','=',$cita_id)->update($newArray);
                $mensaje = ($actualizado > 0);

                $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
                $respuesta->setData($actualizado);
                return $respuesta->json($mensaje ? 200 : 404);
        }
    }

    public function eliminarCita($cita_id){

        $validarCita = new Validate;
        $token = $validarCita->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_citaModel = new CitaModel();
        $_citaModel->byUser($token);
        $data = array(
            "estatus_cita" => "2"
        );

        $eliminado = $_citaModel->where('cita_id','=',$cita_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // utils
    public function retornarMensaje($mensaje) {

        $bool = ($mensaje != null);

        $respuesta = new Response($bool ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($mensaje);

        return $respuesta->json($bool ? 200 : 404);
        
    }
}



?>