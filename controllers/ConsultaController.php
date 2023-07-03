<?php

class ConsultaController extends Controller {
    // variables para el inner join de consultas_sin cita
    protected $selectConsultaSinCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad"
    );

    protected $innerConsultaSinCita = array(
        "paciente" => "consulta_sin_cita",
        "medico" => "consulta_sin_cita",
        "especialidad" => "consulta_sin_cita"
    );

    // variables para el inner join de consultas con cita
    protected $selectConsultaCita = array(
        "paciente.paciente_id",
        "paciente.nombre AS nombre_paciente",
        "paciente.cedula",
        "medico.medico_id",
        "medico.nombre AS nombre_medico",
        "especialidad.especialidad_id",
        "especialidad.nombre AS nombre_especialidad",
        "consulta_cita.consulta_id",
        "consulta_cita.cita_id",
        "consulta.estatus_con",
        "cita.motivo_cita",
        "cita.cedula_titular",
        "cita.tipo_cita"
    );

    protected $innerConsultaCita = array(
        "cita" => "consulta_cita",
        "consulta" => "consulta_cita",
        "paciente" => "cita",
        "medico" => "cita",
        "especialidad" => "cita"
    );

    // variables para el inner join de seguros con cita
    protected $selectSeguro = array(
        "cita_seguro.cita_id",
        "cita.estatus_cit",
        "seguro.seguro_id",
        "seguro.nombre",
        "clave"
    );

    protected $innerSeguro = array(
        "cita" => "cita_seguro",
        "seguro" => "cita_seguro"
    );

    // no sé pa qué son estos
    protected $arrayInner = array(
        "paciente" => "consulta",
        "medico" => "consulta",
        "especialidad" => "consulta",
        "cita" => "consulta",
        // "consulta_indicaciones" => "consulta"
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
        "paciente.tipo_paciente",
        "paciente.edad",
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
        "cita.clave",
        "cita.tipo_cita",
        // "consulta_indicaciones.descripcion"
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
    //datos del inner con los insumos
    protected $arrayInnerRec = array(
        "medicamento" => "consulta_recipe"
    );

    protected $arraySelectRec = array(
        "consulta_recipe.consulta_recipe_id",
        "consulta_recipe.consulta_id",
        "consulta_recipe.consulta_recipe_id",
        "medicamento.medicamento_id",
        "medicamento.nombre_medicamento",
        "medicamento.tipo_medicamento",
        "consulta_recipe.uso"
    );

    //Método index (vista principal)
    public function index() {
        return $this->view('consultas/index');
    }

    public function formRegistrarConsultas() {
        return $this->view('consultas/registrarConsultas');
    }

    public function formActualizarConsulta($consulta_id) {
        return $this->view('consultas/actualizarConsultas', ['consulta_id' => $consulta_id]);
    }

    public function insertarConsulta(/*Request $request*/) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $exclude = array("peso","altura","es_emergencia","observaciones");
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

            case ($validarConsulta->isEmpty($_POST, $exclude)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarConsulta->isDate($_POST['fecha_consulta']):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            case $validarConsulta->isToday($_POST['fecha_consulta'], true):
                $respuesta = new Response('FECHA_INVALIDA');
                return $respuesta->json(400);

            default:
                // Separando los datos
                $examenes = isset($_POST['examenes']) ? $_POST['examenes'] : false;
                $insumos = isset($_POST['insumos']) ? $_POST['insumos'] : false;
                $recipe = isset($_POST['recipes']) ? $_POST['recipes'] : false;
                $indicaciones = isset($_POST['indicaciones']) ? $_POST['indicaciones'] : false;
                
                if ($examenes) {
                    unset($_POST['examenes']);
                }
                if ($insumos) {
                    unset($_POST['insumos']);
                }
                if ($recipe) {
                    unset($_POST['recipes']);
                }
                if ($indicaciones) {
                    unset($_POST['indicaciones']);
                }

                if (isset($_POST['es_emergencia'])) {
                    if ( $_POST['es_emergencia'] != 0 && $_POST['es_emergencia'] != 1 ) {
                        $respuesta = new Response(false, 'El atributo es_emergencia tiene que ser un booleano');
                        return $respuesta->json(400);
                    }
                }
                
                $data = $validarConsulta->dataScape($_POST);
                $por_cita = isset($data['cita_id']);
                $consulta_separada = $this->separarInformación($data, $por_cita);
                
                $header = apache_request_headers();
                $token = substr($header['Authorization'], 7);

                $_consultaModel = new ConsultaModel();
                $_consultaModel->byUser($token);
                $id = $_consultaModel->insert($consulta_separada[1]);
                $mensaje = ($id > 0);
                
                if ($por_cita && $mensaje) {

                    if ( $validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $_POST['cita_id'], 4, 'cita') ) {
                        $respuesta = new Response(false, 'La cita indicada ya se encuentra asociada a una consulta');
                        return $respuesta->json(400);
                    } else if ( $validarConsulta->isDuplicatedId('cita_id', 'estatus_cit', $_POST['cita_id'], 3, 'cita') ) {
                        $respuesta = new Response(false, 'A la cita indicada no se le puede asignar una consulta');
                        return $respuesta->json(400);
                    }

                    $consulta_separada[0]['consulta_id'] = $id;
                    $_consultaConCita = new ConsultaCitaModel();
                    $consulta_cita_id = $_consultaConCita->insert($consulta_separada[0]);
                    
                    if ($consulta_cita_id == 0) {
                        $_consultaModel = new ConsultaModel();
                        $_consultaModel->where('consulta_id', '=',$id)->delete();

                        $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_cita');
                        return $respuesta->json(400);
                    }

                } else if (!$por_cita && $mensaje) {

                    if (!$validarConsulta->isDuplicatedId('especialidad_id', 'medico_id', $_POST['especialidad_id'], $_POST['medico_id'], 'medico_especialidad')) {
                        $respuesta = new Response(false, 'El médico no atiende la especialidad indicada');
                        return $respuesta->json(400);
                    }

                    $consulta_separada[0]['consulta_id'] = $id;
                    $_consultaSinCita = new ConsultaSinCitaModel();
                    $consulta_sin_cita = $_consultaSinCita->insert($consulta_separada[0]);
                    
                    if ($consulta_sin_cita == 0) {
                        $_consultaModel = new ConsultaModel();
                        $_consultaModel->where('consulta_id', '=',$id)->delete();
                        
                        $respuesta = new Response(false, 'Ocurrió un error insertando la relación consulta_sin_cita');
                        return $respuesta->json(400);
                    }
                }

                if ($mensaje) {

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

                    if ($recipe) {

                        $respuestaRecipe = $this->insertarRecipe($recipe, $id);
                        if ( $respuestaRecipe) { return $respuestaRecipe; }
                    }

                    if ($indicaciones) {
                        
                        $respuestaIndicaciones = $this->insertarIndicaciones($indicaciones, $id);
                        if ($respuestaIndicaciones) {
                            return $respuestaIndicaciones;
                        }
                    }

                    $respuesta = new Response('INSERCION_EXITOSA');

                    if ($por_cita) {
                    
                        $cambioEstatus = array('estatus_cit' => '4');
                        $_citaModel = new CitaModel;
                        $res = $_citaModel->where('cita_id', '=', $data['cita_id'])->update($cambioEstatus);
                        
                        if ($res <= 0) {
                            $respuesta->setData('La consulta fue insertada, pero la cita no fue actualizada correctamente, por favor actualicela manualmente para evitar errores');
                        }
                    }

                    return $respuesta->json(201);
                } else {
                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarConsultas() {
        $_consultaModel = new ConsultaModel();
        $consultaList = $_consultaModel->where('estatus_con', '=', 1)->getAll();
        $consultas = [];
        
        foreach ($consultaList as $consulta) {
            $consultas[] = $this->getInformacion($consulta);
        }

        $mensaje = (count($consultas) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($consultas);
        return $respuesta->json(200);
    }

    public function listarConsultasPorPaciente($paciente_id) {

        $consultaList = $this->listarConsultas();
        $consultas = json_decode($consultaList)->data;
        
        $consultasPaciente = array_filter($consultas, fn($consulta) => $consulta->paciente_id == $paciente_id);
        
        $_antecedenteModel = new AntecedenteMedicoModel();
        $selectAntecedentes = [
            "antecedentes_medicos.descripcion",
            "antecedentes_medicos.antecedentes_medicos_id",
            "tipo_antecedente.nombre AS nombre"
        ];

        $innerAntecedentes = [
            "tipo_antecedente" => "antecedentes_medicos"
        ];

        $inners = $_antecedenteModel->listInner($innerAntecedentes);
        $antecedentList = $_antecedenteModel->where('estatus_ant', '!=', '2')
                                    ->where('antecedentes_medicos.paciente_id', '=', $paciente_id)
                                    ->innerJoin($selectAntecedentes, $inners, "antecedentes_medicos");

        $resultado['antecedentes_medicos'] = $antecedentList;
        $consultasCompletas = [];

        if (count($consultasPaciente)) {
            foreach ($consultasPaciente as $consulta) {
                $consultasCompletas[] = $this->setRelaciones($consulta->consulta_id);
            }
    
            if ( count($consultasCompletas) > 0) {
                $consulta = (object) array_merge((array) $consulta, (array) $consultasCompletas);
            }
        }
        
        $resultado['consultas'] = $consultasPaciente;

        $mensaje = (count($resultado) > 0);
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($resultado);

        return $respuesta->json($mensaje ? 200 : 404);

        // $mensaje = (!is_null($consultas));
        //     $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        //     $respuesta->setData($consultas);
        //     return $respuesta->json(200);
    }

    public function listarConsultaPorId($consulta_id) {

        $_consultaModel = new ConsultaModel();
        $consultaList = $_consultaModel->where('estatus_con', '=', 1)
                                        ->where('consulta_id', '=', $consulta_id)
                                        ->getFirst();
        
        if ( !is_null($consultaList) ) {
            $consultas = $this->getInformacion($consultaList);
        
            $mensaje = (!is_null($consultas));
            $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
            $respuesta->setData($consultas);
            return $respuesta->json(200);

        } else {
            $respuesta = new Response('false', 'La consulta indicada no existe');
            return $respuesta->json(400);
        }
    }

    // public function eliminarConsulta($consulta_id) {

    //     $validarConsulta = new Validate;
    //     $token = $validarConsulta->validateToken(apache_request_headers());
    //     if (!$token) {
    //         $respuesta = new Response('TOKEN_INVALID');
    //         return $respuesta->json(401);
    //     }

    //     $_consultaModel = new ConsultaModel();
    //     $_consultaModel->byUser($token);
    //     $data = array(
    //         "estatus_con" => "2"
    //     );

    //     $eliminado = $_consultaModel->where('consulta_id', '=', $consulta_id)->update($data, 1);
    //     $mensaje = ($eliminado > 0);

    //     $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
    //     $respuesta->setData($eliminado);

    //     return $respuesta->json($mensaje ? 200 : 400);
    // }

    public function getInformacion($consulta) {
        // Obtenemos el resto de la información de la consulta
        $_consultaCita = new ConsultaCitaModel();
        $innersCita = $_consultaCita->listInner($this->innerConsultaCita);
        $es_citada = $_consultaCita->where('consulta_cita.consulta_id', '=', $consulta->consulta_id)
                                ->where('consulta.estatus_con','=',1)
                                ->innerJoin($this->selectConsultaCita, $innersCita, "consulta_cita");

        if (is_null($es_citada) || count($es_citada) == 0 ) {
            $_consultaSinCita = new ConsultaSinCitaModel();
            $innersConsulta = $_consultaSinCita->listInner($this->innerConsultaSinCita);
            $consultaCompleta = $_consultaSinCita->where('consulta_sin_cita.consulta_id', '=', $consulta->consulta_id)
                                                ->innerJoin($this->selectConsultaSinCita, $innersConsulta, "consulta_sin_cita");

            $relaciones = $this->setRelaciones($consulta->consulta_id);
            
            if (count((array) $relaciones) > 0) {
                $consultaCompleta[0] = (object) array_merge((array) $consultaCompleta[0], (array) $relaciones);
            }
            
            return $consultas[] = (object) array_merge((array) $consulta, (array) $consultaCompleta[0]);
            
        } else {
            $_cita = new CitaModel();
            $cita = $_cita->where('cita_id', '=', $es_citada[0]->cita_id)->getFirst();

            // $_citaSeguro = new CitaSeguroModel();
            // $innerSeguro = $_citaSeguro->listInner($this->innerSeguro);
            // $citaSeguro = $_citaSeguro->where('cita.estatus_cit', '=', 1)
            //                         ->where('cita_seguro.cita_id', '=', $cita->cita_id)
            //                         ->innerJoin($this->selectSeguro, $innerSeguro, 'cita_seguro');

            $relaciones = $this->setRelaciones($consulta->consulta_id);
            if (count((array) $relaciones) > 0) {
                $consultaCompleta = (object) array_merge((array) $consulta, (array) $relaciones);
            }
            return $consultas[] = (object) array_merge((array) $consulta, (array) $cita);
            
        }
    }

    // insertar recipe
    public function insertarRecipe($recipes, $consulta) {

        $consulta_id = $consulta;
        foreach ($recipes as $recipe) {

            $newRecipe = $recipe;
            $newRecipe['consulta_id'] = $consulta_id;
            $camposId = array("medicamento_id");
            $validarRecipe = new Validate;

            switch ($_POST) {
                case ($validarRecipe->isEmpty($newRecipe)):
                    $respuesta = new Response(false, 'No se pueden enviar recipes vacíos');
                    return $respuesta->json(400);

                case !$validarRecipe->existsInDB($newRecipe, $camposId):
                    $respuesta = new Response(false, 'El medicamento indicado no se encuentra registrado en el sistema');
                    return $respuesta->json(404);

                default:
                    
                    $data = $validarRecipe->dataScape($newRecipe);
                    $_consultaRecipeModel = new ConsultaRecipeModel();
                    $row = $_consultaRecipeModel->insert($data);
                    
                    $isInsert = ($row > 0);

                    if (!$isInsert) {
                        $respuesta = new Response(false, 'Ocurrió un error insertando el recipe');
                        $respuesta->setData("Ha ocurrido un error insertando el recipe".$newRecipe['medicamento_id']."con uso".$newRecipe['uso']);
                        return $respuesta->json(400);
                    }
            }
        }
        return false;
    }

    // insertar indicaciones
    public function insertarIndicaciones($indicaciones, $consulta) {

        $consulta_id = $consulta;
        foreach ($indicaciones as $indicacion) {

            $newIndicacion = $indicacion;
            $newIndicacion['consulta_id'] = $consulta_id;
            $validarIndicacion = new Validate;
            
            if ($validarIndicacion->isEmpty($newIndicacion)) {
                $respuesta = new Response(false, 'No se pueden enviar indicaciones vacías');
                return $respuesta->json(400);
            }
            
            $data = $validarIndicacion->dataScape($newIndicacion);
            $_consultaIndicacionesModel = new ConsultaIndicacionesModel();
            $row = $_consultaIndicacionesModel->insert($data);
            
            $isInsert = ($row > 0);

            if (!$isInsert) {
                $respuesta = new Response(false, 'Ocurrió un error insertando las indicaciones');
                $respuesta->setData("Ha ocurrido un error insertando la indicacion".$newIndicacion['descripcion']);
                return $respuesta->json(400);
            }
        }
        return false;
    }

    // Funciones para reutilizar
    public function separarInformación($informacion, $es_cita) {

        if ($es_cita) {
            $consultaConCita = array("cita_id" => $informacion['cita_id']);
            unset($informacion['cita_id']);
            return array($consultaConCita, $informacion);

        } else {
            $consultaSinCita = array(
                "especialidad_id" => $informacion['especialidad_id'],
                "medico_id" => $informacion["medico_id"],
                "paciente_id" => $informacion["paciente_id"],
            );

            unset($informacion['especialidad_id']);
            unset($informacion['medico_id']);
            unset($informacion['paciente_id']);
            return array($consultaSinCita, $informacion);
        }
    }

    public function insertarExamen($informacion, $id) {
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

    public function insertarInsumo($informacion, $id) {
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

    public function setRelaciones($consulta_id) {

        $_consultaModel = new ConsultaModel();
        $innersExa = $_consultaModel->listInner($this->arrayInnerExa);
        $consulta_examenes = $_consultaModel->where('consulta_examen.consulta_id', '=', $consulta_id)->where('consulta_examen.estatus_con', '=', 1)->innerJoin($this->arraySelectExa, $innersExa, "consulta_examen");
        $consultas = new stdClass();

        if ($consulta_examenes) {
            $consultas->examenes = $consulta_examenes;
        }

        $_consultaModel = new ConsultaModel();
        $innersIns = $_consultaModel->listInner($this->arrayInnerIns);
        $consulta_insumos = $_consultaModel->where('consulta_insumo.consulta_id', '=', $consulta_id)->where('consulta_insumo.estatus_con', '=', 1)->innerJoin($this->arraySelectIns, $innersIns, "consulta_insumo");

        if ($consulta_insumos) {
            $consultas->insumos = $consulta_insumos;
        }

        $_consultaIndicacionesModel = new ConsultaIndicacionesModel();
        $consulta_indicaciones = $_consultaIndicacionesModel->where('consulta_indicaciones.consulta_id', '=', $consulta_id)->getAll();

        if($consulta_indicaciones){
            $consultas->indicaciones = $consulta_indicaciones;
        }

        $_consultaRecipeModel = new ConsultaRecipeModel();
        $innersRec = $_consultaRecipeModel->listInner($this->arrayInnerRec);
        $consulta_recipes = $_consultaRecipeModel->where('consulta_recipe.consulta_id', '=', $consulta_id)->innerJoin($this->arraySelectRec, $innersRec, "consulta_recipe");

        if($consulta_recipes){
            $consultas->recipes = $consulta_recipes;
        }

        $_consultaModel = new ConsultaModel();
        $innersRec = $_consultaModel->listInner($this->arrayInnerRec);
        $recipesList = $_consultaModel->where('consulta_recipe.consulta_id', '=', $consulta_id)
                                        ->innerJoin($this->arraySelectRec, $innersRec, "consulta_recipe");
        
        if ($recipesList) {
            $consultas->recipes = $recipesList;
        }

        $_indicacionesModel = new ConsultaIndicacionesModel();
        $indicacionesList = $_indicacionesModel->where('consulta_indicaciones.consulta_id', '=', $consulta_id)
                                                ->getAll();

        if ($indicacionesList) {
            $consultas->indicaciones = $indicacionesList;
        }
        
        return $consultas;
    }
}
