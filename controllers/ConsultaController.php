<?php

class ConsultaController extends Controller
{

    protected $arrayInner = array(
        "paciente" => "consulta",
        "medico" => "consulta",
        "especialidad" => "consulta",
        "cita" => "consulta"
    );

    protected $arraySelect = array(
        "consulta.consulta_id",
        "consulta.peso",
        "consulta.altura",
        "consulta.observaciones",
        "consulta.fecha_consulta",
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.apellidos AS apellido_paciente",
        "paciente.cedula as cedula_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "medico.apellidos AS apellido_medico",
        "medico.cedula AS cedula_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "cita.cita_id",
        "cita.fecha_cita",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.clave"
    );

    //datos del inner con los exámenes
    protected $arrayInnerExa = array(
        "examen" => "consulta_examen"
    );

    protected $arraySelectExa = array(
        "examen.examen_id",
        "examen.nombre"
    );

    //datos del inner con los insumos
    protected $arrayInnerIns = array(
        "insumo" => "consulta_insumo"
    );

    protected $arraySelectIns = array(
        "insumo.insumo_id",
        "insumo.nombre"
    );

    //Método index (vista principal)
    public function index()
    {

        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas()
    {

        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($consulta_id)
    {

        return $this->view('consultas/actualizarConsultas', ['consulta_id' => $consulta_id]);
    }

    public function insertarConsulta(/*Request $request*/)
    {

        $_POST = json_decode(file_get_contents('php://input'), true);

        $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "peso", "altura");
        $campoId = array("paciente_id", "medico_id", "especialidad_id", "cita_id");
        $validarConsulta = new Validate;

        $token = $validarConsulta->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        switch ($validarConsulta) {

            case !$validarConsulta->existsInDB($_POST, $campoId):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(404);

            case ($validarConsulta->isEmpty($_POST)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $_POST['cita_id'], 4, 'cita'):
                $respuesta = new Response(false, 'La cita indicada ya se encuentra asociada a una consulta');
                return $respuesta->json(400);

            case !$validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $_POST['cita_id'], 1, 'cita'):
                $respuesta = new Response(false, 'A la cita indicada no se le puede asignar una consulta');
                return $respuesta->json(400);

            case !$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $_POST['medico_id'], 'medico_especialidad'):
                $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
                return $respuesta->json(404);

            case $validarConsulta->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarConsulta->isDate($_POST['fecha_consulta']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarConsulta->isToday($_POST['fecha_consulta'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            default:
                // Separando los datos
                $examenes = isset($_POST['examenes']);
                $insumos = isset($_POST['insumos']);
                unset($_POST['examenes']);
                unset($_POST['insumos']);

                $data = $validarConsulta->dataScape($_POST);

                $_consultaModel = new ConsultaModel();
                $_consultaModel->byUser($token);
                $id = $_consultaModel->insert($data);
                $mensaje = ($id > 0);

                if ($mensaje) {

                    $cambioEstatus = array('estatus_cit' => '4');
                    $_citaModel = new CitaModel;
                    $res = $_citaModel->where('cita_id', '=', $data['cita_id'])->update($cambioEstatus);

                    if ($examenes) {

                        $respuestaExamen = $this->insertarExamen($examenes, $id);
                        if ($respuestaExamen) {
                            return $respuestaExamen;
                        }
                    }

                    if ($insumos) {

                        $respuestaInsumo = $this->insertarInsumo($insumos, $id);
                        if ($respuestaInsumo) {
                            return $respuestaInsumo;
                        }
                    }

                    $respuesta = new Response('INSERCION_EXITOSA');
                    return $respuesta->json(201);
                } else {
                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarConsultas()
    {

        $_consultaModel = new ConsultaModel();
        $inners = $_consultaModel->listInner($this->arrayInner);
        $consulta = $_consultaModel->where('consulta.estatus_con', '=', '1')->innerJoin($this->arraySelect, $inners, "consulta");
        $resultado = array();

        foreach ($consulta as $consultas) {

            $_consultaModel = new ConsultaModel();
            $innersExa = $_consultaModel->listInner($this->arrayInnerExa);
            $consulta_examenes = $_consultaModel->where('consulta_examen.consulta_id', '=', $consultas->consulta_id)->where('consulta_examen.estatus_con', '=', 1)->innerJoin($this->arraySelectExa, $innersExa, "consulta_examen");

            if ($consulta_examenes) {
                $consultas->examenes = $consulta_examenes;
            }

            $_consultaModel = new ConsultaModel();
            $innersIns = $_consultaModel->listInner($this->arrayInnerIns);
            $consulta_insumos = $_consultaModel->where('consulta_insumo.consulta_id', '=', $consultas->consulta_id)->where('consulta_insumo.estatus_con', '=', 1)->innerJoin($this->arraySelectIns, $innersIns, "consulta_insumo");

            if ($consulta_insumos) {
                $consultas->insumos = $consulta_insumos;
            }

            $resultado[] = $consultas;
        }

        $mensaje = (count($resultado) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);

        return $respuesta->json(200);
    }

    public function listarConsultasPorPaciente($paciente_id)
    {

        $_consultaModel = new ConsultaModel();
        $inners = $_consultaModel->listInner($this->arrayInner);
        $consulta = $_consultaModel->where('consulta.paciente_id', '=', $paciente_id)->where('consulta.estatus_con', '=', '1')->innerJoin($this->arraySelect, $inners, "consulta");
        $resultado = array();

        foreach ($consulta as $consultas) {

            $_consultaModel = new ConsultaModel();
            $innersExa = $_consultaModel->listInner($this->arrayInnerExa);
            $consulta_examenes = $_consultaModel->where('consulta_examen.consulta_id', '=', $consultas->consulta_id)->where('consulta_examen.estatus_con', '=', 1)->innerJoin($this->arraySelectExa, $innersExa, "consulta_examen");

            if ($consulta_examenes) {
                $consultas->examenes = $consulta_examenes;
            }

            $_consultaModel = new ConsultaModel();
            $innersIns = $_consultaModel->listInner($this->arrayInnerIns);
            $consulta_insumos = $_consultaModel->where('consulta_insumo.consulta_id', '=', $consultas->consulta_id)->where('consulta_insumo.estatus_con', '=', 1)->innerJoin($this->arraySelectIns, $innersIns, "consulta_insumo");

            if ($consulta_insumos) {
                $consultas->insumos = $consulta_insumos;
            }

            $resultado[] = $consultas;
        }

        $mensaje = (count($resultado) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);

        return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarConsultaPorId($consulta_id)
    {

        $_consultaModel = new ConsultaModel();
        $inners = $_consultaModel->listInner($this->arrayInner);
        $consulta = $_consultaModel->where('consulta_id', '=', $consulta_id)->where('estatus_con', '=', '1')->innerJoin($this->arraySelect, $inners, "consulta");

        if ($consulta) {

            $resultado = $consulta;

            $_consultaModel = new ConsultaModel();
            $innersExa = $_consultaModel->listInner($this->arrayInnerExa);
            $consulta_examenes = $_consultaModel->where('consulta_examen.consulta_id', '=', $consulta_id)->where('consulta_examen.estatus_con', '=', 1)->innerJoin($this->arraySelectExa, $innersExa, "consulta_examen");

            if ($consulta_examenes) {
                $resultado[0]->examenes = $consulta_examenes;
            }

            $_consultaModel = new ConsultaModel();
            $innersIns = $_consultaModel->listInner($this->arrayInnerIns);
            $consulta_insumos = $_consultaModel->where('consulta_insumo.consulta_id', '=', $consulta_id)->where('consulta_insumo.estatus_con', '=', 1)->innerJoin($this->arraySelectIns, $innersIns, "consulta_insumo");

            if ($consulta_insumos) {
                $resultado[0]->insumos = $consulta_insumos;
            }

            $respuesta = new Response('CORRECTO');
            $respuesta->setData($resultado);
            return $respuesta->json(200);
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(404);
        }
    }

    // public function actualizarConsulta($consulta_id){

    //     $_POST = json_decode(file_get_contents('php://input'), true);

    //     $camposNumericos = array("paciente_id", "medico_id", "especialidad_id", "peso", "altura", "cita_id");
    //     $validarConsulta = new Validate;

    //     switch ($validarConsulta) {
    //         case ($validarConsulta->isEmpty($_POST)):
    //             $respuesta = new Response('DATOS_VACIOS');
    //             return $respuesta->json(400);

    //         case $validarConsulta->isEliminated("consulta", 'estatus_con', $consulta_id):
    //             $respuesta = new Response(false, 'La consulta introducida no se encuentra en el sistema');
    //             return $respuesta->json(404);                

    //         case $validarConsulta->isNumber($_POST, $camposNumericos):
    //             $respuesta = new Response('DATOS_INVALIDOS');
    //             return $respuesta->json(400);

    //         default:

    //             if ( array_key_exists("paciente_id", $_POST) ) {
    //                 if ($validarConsulta->isEliminated("paciente", 'estatus_pac', $_POST['paciente_id'])) {
    //                     $respuesta = new Response('PAT_NOT_FOUND');
    //                     return $respuesta->json(404);
    //                 } elseif (!$validarConsulta->isDuplicated('paciente', 'paciente_id', $_POST['paciente_id'])) {
    //                     $respuesta = new Response('PAT_NOT_FOUND');         
    //                     return $respuesta->json(404);
    //                 } 
    //             }

    //             if ( array_key_exists("especialidad_id", $_POST) ) {

    //                 $_consultaModel = new ConsultaModel();
    //                 $especialidadConsulta = $_consultaModel->where('consulta_id','=',$consulta_id)->getFirst();
    //                 $medicoConsulta = $especialidadConsulta->medico_id;

    //                 if ($validarConsulta->isEliminated("especialidad", 'estatus_esp', $_POST['especialidad_id'])) {
    //                     $respuesta = new Response('SPE_NOT_FOUND');
    //                     return $respuesta->json(404);
    //                 } elseif (!$validarConsulta->isDuplicated('especialidad', 'especialidad_id', $_POST['especialidad_id'])) {
    //                     $respuesta = new Response('SPE_NOT_FOUND');         
    //                     return $respuesta->json(404);
    //                 } else if (!$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $medicoConsulta, 'medico_especialidad')) {
    //                     $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
    //                     return $respuesta->json(404);
    //                 }                    

    //             }

    //             if ( array_key_exists("medico_id", $_POST) ) {

    //                 $_consultaModel = new ConsultaModel();
    //                 $medicoConsulta = $_consultaModel->where('consulta_id','=',$consulta_id)->getFirst();
    //                 $especialidadConsulta = $medicoConsulta->especialidad_id;

    //                 if ($validarConsulta->isEliminated("medico", 'estatus_med', $_POST['medico_id'])) {
    //                     $respuesta = new Response('MD_NOT_FOUND');
    //                     return $respuesta->json(404);
    //                 } elseif (!$validarConsulta->isDuplicated('medico', 'medico_id', $_POST['medico_id'])) {
    //                     $respuesta = new Response('MD_NOT_FOUND');         
    //                     return $respuesta->json(404);
    //                 } else if (!$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $especialidadConsulta, $_POST['medico_id'], 'medico_especialidad')) {
    //                     $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
    //                     return $respuesta->json(404);
    //                 }
    //             }

    //             if ( array_key_exists('fecha_consulta', $_POST) ) {
    //                 if ( $validarConsulta->isDate($_POST['fecha_consulta'])) {

    //                     $respuesta = new Response('FECHA_INVALIDA');
    //                     return $respuesta->json(400);

    //                 } else if ($validarConsulta->isToday($_POST['fecha_consulta'], true)) {

    //                     $respuesta = new Response('FECHA_INVALIDA');
    //                     return $respuesta->json(400);
    //                 }

    //             }

    //             if ( array_key_exists('cita_id', $_POST) ) {

    //                 if ($validarConsulta->isEliminated("cita", 'estatus_cit', $_POST['cita_id'])) {
    //                     $respuesta = new Response(false, 'No se encontraron resultados de la cita indicada');
    //                     return $respuesta->json(404);
    //                 } elseif (!$validarConsulta->isDuplicated('cita', 'cita_id', $_POST['cita_id'])) {
    //                     $respuesta = new Response(false, 'No se encontraron resultados de la cita indicada');         
    //                     return $respuesta->json(404);
    //                 }

    //             }

    //             if ( array_key_exists('examenes', $_POST) ) {

    //                 $_consultaExamen = new ConsultaExamenController;
    //                 $bool = $_consultaExamen->actualizarConsultaExamen($_POST['examenes'],$consulta_id);

    //                 if ($bool == true) {

    //                     return $bool;

    //                 } else {
    //                     $_consultaModel = new ConsultaModel();
    //                     unset($_POST['examenes']);
    //                     $data = $validarConsulta->dataScape($_POST);

    //                     $actualizado = $_consultaModel->where('consulta_id','=',$consulta_id)->where('estatus_con','=','1')->update($data);
    //                     $mensaje = ($actualizado > 0);

    //                     if (!$bool && $mensaje) {

    //                         $respuesta = new Response(true, 'Todos los datos han sido actualizados exitosamente');
    //                         return $respuesta->json(200);

    //                     } else if ($bool && $mensaje) {

    //                         $respuesta = new Response(true, 'Ha ocurrido un error con los exámenes');
    //                         return $respuesta->json(400);

    //                     } else if (!$bool && !$mensaje) {

    //                         $respuesta = new Response(true, 'Ha ocurrido un error con los datos');
    //                         return $respuesta->json(400);

    //                     }
    //                 }
    //             }

    //             $data = $validarConsulta->dataScape($_POST);
    //             $_consultaModel = new ConsultaModel();
    //             $actualizado = $_consultaModel->where('consulta_id','=',$consulta_id)->where('estatus_con','=','1')->update($data);
    //             $mensaje = ($actualizado > 0);

    //             $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
    //             $respuesta->setData($actualizado);
    //             return $respuesta->json($mensaje ? 200 : 400);
    //     }
    // }

    public function eliminarConsulta($consulta_id)
    {

        $validarConsulta = new Validate;
        $token = $validarConsulta->validateToken(apache_request_headers());
        if (!$token) {
            $respuesta = new Response('TOKEN_INVALID');
            return $respuesta->json(401);
        }

        $_consultaModel = new ConsultaModel();
        $_consultaModel->byUser($token);
        $data = array(
            "estatus_con" => "2"
        );

        $eliminado = $_consultaModel->where('consulta_id', '=', $consulta_id)->update($data, 1);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Funciones para reutilizar

    public function insertarExamen($informacion, $id)
    {
        $_consultaModel = new ConsultaModel();

        // Insertando la relación consulta_examen
        $_consultaExamen = new ConsultaExamenController;
        $respuestaExamen = $_consultaExamen->insertarConsultaExamen($informacion, $id);

        if ($respuestaExamen == true) {

            $_consultaModel->where('consulta_id', '=', $id)->delete();
            return $respuestaExamen;
        } else {
            return false;
        }
    }

    public function insertarInsumo($informacion, $id)
    {
        $_consultaModel = new ConsultaModel();

        // Insertando relación consulta_insumo
        $_consultaInsumo = new ConsultaInsumoController;
        $respuestaInsumo = $_consultaInsumo->insertarConsultaInsumo($informacion, $id);

        if ($respuestaInsumo == true) {

            $_consultaModel->where('consulta_id', '=', $id)->delete();
            return $respuestaInsumo;
        } else {
            return false;
        }
    }
}
