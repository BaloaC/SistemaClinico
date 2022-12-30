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
        //$camposExclude = array("clave");

        $campoId = array("paciente_id", "medico_id", "especialidad_id");
        
        $validarCita = new Validate;
        
        switch($_POST) {
            //case ($validarCita->isEmpty($_POST, $camposExclude)):
            case ($validarCita->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarCita->isEliminated("paciente", 'estatus_pac', $_POST['paciente_id']):
                $respuesta = new Response('PAT_NOT_FOUND');
                return $respuesta->json(404);

            case $validarCita->isEliminated("medico", 'estatus_med', $_POST['medico_id']):
                $respuesta = new Response('MD_NOT_FOUND');
                return $respuesta->json(404);

            case $validarCita->isEliminated("especialidad", 'estatus_esp', $_POST['especialidad_id']):
                $respuesta = new Response('SPE_NOT_FOUND');
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

            // este pedazote esta comentado porque no recuerdo pa k lo hice
            // case $_POST['tipo_cita'] == 1:
            //     $siEsNatural = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '1', 'paciente');
            //     $siEsAsegurado = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '2', 'paciente'); 
                
            //     // verificando si es un paciente beneficiario o natural
            //     if ( !$siEsNatural && !$siEsAsegurado ) {
            //         $respuesta = new Response('DATOS_INVALIDOS');
            //         return $respuesta->json(403);
            //     }

            // tampoco recuerdo pa k era este otro pedazo
            // case $_POST['tipo_cita'] == "2":
            //     if (!$validarCita->isDuplicatedId('cedula', 'tipo_paciente', $_POST['cedula_titular'], '2', 'paciente')) {
            //         $respuesta = new Response('DATOS_INVALIDOS');
            //         return $respuesta->json(402);
            //     }

            default: 

                $data = $validarCita->dataScape($_POST);

                // verificaciones si la cita es asegurada
                if ($data['tipo_cita'] == 2 ) {
                    
                    // verificamos que pueda solicitar cita asegurada
                    $siEsTitular = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '2', 'paciente');
                    $siEsBeneficiario = $validarCita->isDuplicatedId('cedula', 'tipo_paciente', $data['cedula_titular'], '3', 'paciente');
                    
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
                        $data['clave'] = ($verClave ? 2 : 1 );

                    } else { $data['estatus'] = 2; }

                } else {

                    $_pacienteController = new PacienteController;
                    $id = $_pacienteController->RetornarID($_POST['cedula_titular']);

                    if ( $id != $_POST['paciente_id'] ) {
                        
                        $respuesta = new Response(false, 'La cédula no coincide con el paciente ingresado');
                        return $respuesta->json(400);
                    }

                    $data['estatus'] = 1;
                }

                $_citaModel = new CitaModel();
                $id = $_citaModel->insert($data);
                $mensaje = ($id > 0);
                
                $mensaje = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $mensaje->json($mensaje ? 201 : 400);
        }
    }

    public function listarCitas(){

        $arrayInner = array (
            "paciente" => "cita",
            "medico" => "cita",
            "especialidad" => "cita"
        );

        $arraySelect = array (
            "paciente.nombres AS nombre_paciente",
            "medico.nombres AS nombre_medico",
            "especialidad.nombre AS nombre_especialidad",
            "cita.cita_id",
            "cita.paciente_id",
            "cita.medico_id",
            "cita.especialidad_id",
            "cita.fecha_cita",
            "cita.motivo_cita",
            "cita.cedula_titular",
            "cita.clave",
            "cita.tipo_cita",
            "cita.estatus_cit"
        );

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($arrayInner);
        $lista = $_citaModel->where('estatus_cit','!=','3')->innerJoin($arraySelect, $inners, "cita");

        $mensaje = (count($lista) > 0);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);
        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarCitaPorId($cita_id){

        $arrayInner = array (
            "paciente" => "cita",
            "medico" => "cita",
            "especialidad" => "cita"
        );

        $arraySelect = array (
            "paciente.nombres AS nombre_paciente",
            "medico.nombres AS nombre_medico",
            "especialidad.nombre AS nombre_especialidad",
            "cita.cita_id",
            "cita.paciente_id",
            "cita.medico_id",
            "cita.especialidad_id",
            "cita.fecha_cita",
            "cita.motivo_cita",
            "cita.cedula_titular",
            "cita.clave",
            "cita.tipo_cita",
            "cita.estatus_cit"
        );

        $_citaModel = new CitaModel();
        $inners = $_citaModel->listInner($arrayInner);
        $lista = $_citaModel->where('cita_id','=',$cita_id)->where('estatus_cit','!=','3')->innerJoin($arraySelect, $inners, "cita");
        $mensaje = ($lista != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarCitaPorPacienteId($paciente_id){

        $_citaModel = new CitaModel();
        $lista = $_citaModel->where('estatus_cit','=','1')->where('paciente_id','=',$paciente_id)->getAll();
        $mensaje = ($lista != null);

        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($lista);

        return $respuesta->json($mensaje ? 200 : 404);
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
        $data = array(
            "estatus_cita" => "3"
        );

        $eliminado = $_citaModel->where('cita_id','=',$cita_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}



?>