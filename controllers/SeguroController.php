<?php

class SeguroController extends Controller{

    protected $seguro = [];

    protected $arrayInner = array(
        "empresa" => "seguro_empresa",
        "seguro" => "seguro_empresa",
    );

    protected $arraySelect = array(
        "empresa.empresa_id",
        "empresa.nombre AS nombre_empresa",
        "empresa.rif",
        "empresa.direccion"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('seguros/index');
    }

    public function formRegistrarSeguros(){

        return $this->view('seguros/registrarSeguros');
    }

    public function formActualizarSeguro($seguro_id){
        
        return $this->view('seguros/actualizarSeguros', ['seguro$seguro_id' => $seguro_id]);
    } 

    public function insertarSeguro(/*Request $request*/){

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        // Creando los strings para las validaciones
        $camposNumericos = array("telefono");
        $validarSeguro = new Validate;
        
        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isDuplicated('seguro', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarSeguro->isDuplicated('seguro', 'rif', $_POST["rif"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case count($_POST['examenes']) != count($_POST['costos']):
                $respuesta = new Response(false, 'Todos los exámenes deben tener un precio indicado');
                return $respuesta->json(400);

            case count($_POST['examenes']) != count( array_unique(($_POST['examenes'])) ):
                $respuesta = new Response(false, 'No pueden existir exámenes repetidos');
                return $respuesta->json(400);

            default: 

                $isValid = $this->validarSeguroExamen($_POST);
                if ($isValid) { return $isValid; }

                $seguro_examenes['examenes'] = $_POST['examenes'];
                $seguro_examenes['costos'] = $_POST['costos'];
                unset($_POST['examenes']); unset($_POST['costos']);
                
                $data = $validarSeguro->dataScape($_POST);
                $_seguroModel = new SeguroModel();
                $id = $_seguroModel->insert($data);

                if ( $id > 0 ) {
                    $seguro_examenes['seguro_id'] = $id;
                    $this->seguro = $data;
                    return $this->insertarSeguroExamen($seguro_examenes);

                } else {
                    $respuesta = new Response('INSERCION_FALLIDA');
                    return $respuesta->json(400);
                }
        }
    }

    public function listarSeguros(){
                     
        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('estatus_seg', '=', '1')->getAll();
        $resultado = array();   

        foreach ($seguro as $seguros) {
        
            $id = $seguros->seguro_id;
            $validarSeguro = new Validate;
            // Verificamos si hay que aplicarle un inner join a ese seguro en específico
            $respuesta = $validarSeguro->isDuplicated('seguro_empresa', 'seguro_id', $id);
            $newArray = get_object_vars($seguros);
            
            if($respuesta){
                
                $newArray['empresas'] = '';
                $_seguroModel = new SeguroModel();
                $inners = $_seguroModel->listInner($this->arrayInner);
                $EmpresaSeguro = $_seguroModel->where('seguro.seguro_id','=',$id)->where('seguro.estatus_seg', '=', '1')->innerJoin($this->arraySelect, $inners, "seguro_empresa");
                $arraySeguro = array();

                foreach ($EmpresaSeguro as $empresas) {
                    // Guardamos cada empresa en un array
                    $arraySeguro[] = $empresas;
                }
                // Agregamos las empresas en el seguro al que pertenecen
                $newArray['empresas'] = $arraySeguro;
                $resultado[] = $newArray;

            } else { $resultado[] = $newArray; } // Si no necesita inner join, lo agregamos tal cual como está
        }

        $mensaje = ($resultado != null);
        return $this->retornarMensaje($mensaje, $resultado);
        // $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        // $respuesta->setData($resultado);
        // return $respuesta->json($mensaje ? 200 : 404);
    }

    public function listarSeguroPorId($seguro_id){

        $_seguroModel = new SeguroModel();
        $seguro = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->getFirst();

        if ($seguro) {

            $arraySeguro = get_object_vars($seguro);

            $inners = $_seguroModel->listInner($this->arrayInner);
            $empresa = $_seguroModel->where('seguro.seguro_id','=',$seguro_id)->where('seguro.estatus_seg', '=', '1')->innerJoin($this->arraySelect, $inners, "seguro_empresa");
            $mensaje = ($empresa != null);

            if ( $mensaje ) { $arraySeguro['empresas'] = $empresa; } 
            return $this->retornarMensaje($arraySeguro, $arraySeguro);
            // $respuesta = new Response($arraySeguro ? 'CORRECTO' : 'ERROR');
            // $respuesta->setData($arraySeguro);
            // return $respuesta->json($arraySeguro ? '200' : '400');
            
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarSeguro($seguro_id){

        $_POST = json_decode(file_get_contents('php://input'), true);

        // Creando los strings para las validaciones
        $camposNumericos = array("telefono");
        $validarSeguro = new Validate;

        switch($_POST) {
            case ($validarSeguro->isEmpty($_POST)):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case $validarSeguro->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(400);

            case !$validarSeguro->isDuplicated("seguro", 'seguro_id', $seguro_id):
                $respuesta = new Response('NOT_FOUND');
                return $respuesta->json(200);

            case array_key_exists('nombre', $_POST):
                if ($validarSeguro->isDuplicated('seguro', 'nombre', $_POST["nombre"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(400);  
                };
            
            default: 

            if (array_key_exists('rif', $_POST)) {
                if ($validarSeguro->isDuplicated('seguro', 'rif', $_POST["rif"])) {
                    $respuesta = new Response('DATOS_DUPLICADOS');
                    return $respuesta->json(404);  
                }
            }

            $data = $validarSeguro->dataScape($_POST);
                
            $_seguroModel = new SeguroModel();

            $actualizado = $_seguroModel->where('seguro_id','=',$seguro_id)->update($data);
            $mensaje = ($actualizado > 0);

            $respuesta = new Response($mensaje ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
            
            return $respuesta->json($mensaje ? 200 : 400);
        }
    }

    public function eliminarSeguro($idSeguro){

        $_seguroModel = new SeguroModel();
        $data = array(
            "estatus_seg" => "2"
        );

        $eliminado = $_seguroModel->where('seguro_id','=',$idSeguro)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // Seguro_examen
    protected function validarSeguroExamen($form) {
        $validarSeguro = new Validate;
        $limite = count($form['examenes']);

        for ($i = 0; $i < $limite; $i++) { 
            if ( !$validarSeguro->isDuplicatedId('examen_id', 'hecho_aqui', $form['examenes'][$i], 1, 'examen') ) {
                $respuesta = new Response(false, 'El examen no existe o no se realiza en la clínica');
                $respuesta->setData('Error relacionando el examen_id '.$form['examenes'][$i]);
                return $respuesta->json(400);

            } else if ($form['costos'][$i] <= 0) {
                $respuesta = new Response(false, 'El monto del examen es obligatorio');
                $respuesta->setData('Error con el examen id '.$form['examenes'][$i].' asociandolo al monto '.$form['costos'][$i]);
                return $respuesta->json(400);
            }
        }

        return false;
    }

    public function insertarSeguroExamen($form) { // form puede ser el seguro_id o un array de datos

        $seguro = null;
        $_POST = json_decode(file_get_contents('php://input'), true);
        $info = is_numeric($form) ? $_POST : $form;
        
        if ( !is_numeric($form) ) { // Si no es un id, insertamos información nueva

            $isValid = $this->validarSeguroExamen($info);
            if ($isValid) { return $isValid; }

        } else { // Si es un id, actualizamos el registro existente
            
            $validarSeguro = new Validate();
            if ( !$validarSeguro->isDuplicated('seguro', 'seguro_id', $form) ) {
                $respuesta = new Response(false, 'El seguro indicado no existe');
                return $respuesta->json(400);
            }

            // Obtenemos el seguro para después obtener el seguro_examen
            $_seguroModel = new SeguroModel();
            $seguro = $_seguroModel->where('seguro_id', '=', $form)->getFirst();
        }

        $examenes_separados = $info['examenes'];
        $info['examenes'] = implode(',', $info['examenes']);
        $info['costos'] = implode(',', $info['costos']);
        $validarExamenes = new Validate();
        $data = $validarExamenes->dataScape($info);

        if ( !is_null($seguro) && count((array) $seguro) > 0) {// actualizamos el registro existente
            
            // Obtenemos el registro existente para actualizarlo
            $_seguroExamenModel = new SeguroExamenModel();
            $seguro_examen = $_seguroExamenModel->where('seguro_id', '=', $form)->getFirst();

            // Volvemos los string array para verificar que el examen que estamos insertando no existe ya
            foreach ($examenes_separados as $examen) {                
                $isExist = array_search( $examen, explode(',', $seguro_examen->examenes));

                if ($isExist) {
                    $respuesta = new Response(false, 'El examen indicado ya se encuentra relacionado a ese seguro');
                    $respuesta->setData('Error procesando el examen id '.$examen);
                    return $respuesta->json(400);
                }
            }

            // Juntamos el string viejo con el nuevo
            $seguro_examen->examenes .= ",".$data['examenes'];
            $seguro_examen->costos .= ",".$data['costos'];

            $isUpdated = $_seguroExamenModel->update((array) $seguro_examen);
            return $this->retornarMensaje($isUpdated != 0, $seguro_examen);

        } else { // creamos un registro

            $_seguroExamen = new SeguroExamenModel();
            $isInserted = $_seguroExamen->insert($data);
            return $this->retornarMensaje($isInserted != 0, $this->seguro);
        }
    }

    public function eliminarSeguroExamen($seguro_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarSeguro = new Validate();
        
        // Validamos que el seguro exista
        if ( !$validarSeguro->isDuplicated('seguro', 'seguro_id', $seguro_id) ) {
            $respuesta = new Response(false, 'El seguro indicado no existe');
            return $respuesta->json(400);
        }

        $_seguroExamen = new SeguroExamenModel();
        $seguro_examen = $_seguroExamen->where('seguro_id', '=', $seguro_id)->getFirst();

        // Volvemos los string array para manejar la información por índices
        $examenes = explode(',', $seguro_examen->examenes);
        $costos = explode(',', $seguro_examen->costos);
        $index_examen = array_search( $_POST['examen_id'], $examenes ); // Obtenemos el índice donde se encuentre el examen a eliminar
        
        if ( !$index_examen ) { // Validamos que el examen esté asociado a ese seguro
            $respuesta = new Response(false, 'El examen indicado no está relacionado a ese seguro');
            return $respuesta->json(400);
        }

        unset($examenes[$index_examen]);
        unset($costos[$index_examen]);
        
        // Los volvemos string de nuevo
        $info_update['examenes'] = implode(',', $examenes);
        $info_update['costos'] = implode(',', $costos);
        
        $isUpdated = $_seguroExamen->update($info_update);
        $bool = $isUpdated > 0;

        $respuesta = new Response($bool ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        $respuesta->setData($isUpdated);
        return $respuesta->json(200);
    }

    // Funciones
    public function retornarMensaje($mensaje, $data) {
        $respuesta = new Response($mensaje ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($data);
        return $respuesta->json(200);
    }
}