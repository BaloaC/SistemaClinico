<?php

include_once './services/seguros/seguro/SeguroHelpers.php';
include_once './services/seguros/seguro/SeguroValidaciones.php';

class SeguroService {

    public static function ListarTodos($seguros) {
        
        $seguro_id = $seguros->seguro_id;
        $validarSeguro = new Validate;

        // Verificamos si hay que aplicarle un inner join a ese seguro en específico
        $respuesta = $validarSeguro->isDuplicated('seguro_empresa', 'seguro_id', $seguro_id);

        if($respuesta){
            $seguros->empresas = SeguroHelpers::listarEmpresasSeguros($seguro_id);
        }

        $examenes = SeguroHelpers::listarEmpresasCostos($seguro_id);
        
        if ( $examenes ) {
            $seguros->examenes = $examenes;
        }

        return $seguros;
    }

    public static function insertarSeguro($seguro) {
        
        $validarSeguro = new Validate;
        
        SeguroValidaciones::validacionesGenerales($seguro);
        SeguroValidaciones::validarNombre($seguro['nombre']);
        SeguroValidaciones::validarRif($seguro['rif']);
        SeguroValidaciones::validarSeguroExamenes($seguro);
        SeguroValidaciones::validarExistenciaExamen($seguro);

        $seguro_examenes['examenes'] = $seguro['examenes'];
        $seguro_examenes['costos'] = $seguro['costos'];
        unset($seguro['examenes']); unset($seguro['costos']);
                
        $data = $validarSeguro->dataScape($seguro);
        $_seguroModel = new SeguroModel();
        $id = $_seguroModel->insert($data);

        $isInsert = $id > 0;

        if (!$isInsert) {
            $respuesta = new Response('INSERCION_FALLIDA');
            echo $respuesta->json(400);
            exit();
        }

        $seguro_examenes['seguro_id'] = $id;
        SeguroService::insertarSeguroExamen($seguro_examenes);
    }

    public static function actualizarSeguro($seguro, $seguro_id) {

        $validarSeguro = new Validate();
        SeguroValidaciones::validacionesGenerales($seguro);
        SeguroValidaciones::validarExistenciaSeguro($seguro_id);

        if (isset($seguro['nombre'])) {
            SeguroValidaciones::validarNombre($seguro['nombre']);
        }

        if (isset($seguro['rif'])) {
            SeguroValidaciones::validarRif($seguro['rif']);
        }

        $data = $validarSeguro->dataScape($_POST);
        $_seguroModel = new SeguroModel();
        $actualizado = $_seguroModel->where('seguro_id','=',$seguro_id)->update($data);

        if ( $actualizado <= 0) {
            
            $respuesta = new Response('ACTUALIZACION_FALLIDA');
            $respuesta->setData($actualizado);
            echo $respuesta->json(400);
            exit();
        }
    }

    /**
     * @param formulario int o id
     * Formulario puede ser un id que corresponde a una ruta o un formulario que corresponde al llamado de otro controlador
 */
    public static function insertarSeguroExamen($formulario) {
        
        $seguro = null;
        $_POST = json_decode(file_get_contents('php://input'), true);
        $seguro_examen = is_numeric($formulario) ? $_POST : $formulario;

        if ( !is_numeric($formulario) ) { // Si no es un id, insertamos información nueva
            
            SeguroValidaciones::validarExistenciaExamen($seguro_examen);
            $seguro_examen['examenes'] = implode(',', $seguro_examen['examenes']);
            $seguro_examen['costos'] = implode(',', $seguro_examen['costos']);

            $_seguroExamen = new SeguroExamenModel();
            $isInserted = $_seguroExamen->insert($seguro_examen);
            SeguroHelpers::retornarMensaje($isInserted != 0, $seguro_examen);

        } else { // Si es un id, actualizamos el registro existente
            
            SeguroValidaciones::validarExistenciaSeguro($formulario);
            SeguroValidaciones::validarExistenciaExamen($seguro_examen);

            // Obtenemos el seguro para después obtener el seguro_examen
            $_seguroModel = new SeguroModel();
            $seguro = $_seguroModel->where('seguro_id', '=', $formulario)->getFirst();
        
            $examenes_separados = $seguro_examen['examenes'];
            $seguro_examen['examenes'] = implode(',', $seguro_examen['examenes']);
            $seguro_examen['costos'] = implode(',', $seguro_examen['costos']);
            $validarExamenes = new Validate();
            $data = $validarExamenes->dataScape($seguro_examen);

            if ( !is_null($seguro) && count((array) $seguro) > 0) {// actualizamos el registro existente
                
                // Obtenemos el registro existente para actualizarlo
                $_seguroExamenModel = new SeguroExamenModel();
                $seguro_examen = $_seguroExamenModel->where('seguro_id', '=', $formulario)->getFirst();

                // Volvemos los string array para verificar que el examen que estamos insertando no existe ya
                foreach ($examenes_separados as $examen) {                
                    $isExist = array_search( $examen, explode(',', $seguro_examen->examenes));
                    
                    if ($isExist) {
                        $respuesta = new Response(false, 'El examen indicado ya se encuentra relacionado a ese seguro');
                        $respuesta->setData('Error procesando el examen id '.$examen);
                        echo $respuesta->json(400);
                        exit();
                    }
                }

                // Juntamos el string viejo con el nuevo
                $seguro_examen->examenes .= ",".$data['examenes'];
                $seguro_examen->costos .= ",".$data['costos'];

                $isUpdated = $_seguroExamenModel->update((array) $seguro_examen);
                SeguroHelpers::retornarMensaje($isUpdated != 0, $seguro_examen);

            }
        }
    }

    public static function eliminarSeguroExamen($form, $seguro_id) {

        $_seguroExamen = new SeguroExamenModel();
        $seguro_examen = $_seguroExamen->where('seguro_id', '=', $seguro_id)->getFirst();

        // Volvemos los string array para manejar la información por índices
        $examenes = explode(',', $seguro_examen->examenes);
        $costos = explode(',', $seguro_examen->costos);
        
        SeguroValidaciones::validarUltimoExamenSeguro($examenes);

        if ( array_search( ($form['examen_id']) , $examenes ) ) {
            
            // Obtenemos el índice donde se encuentre el examen a eliminar
            $index_examen = array_search( ($form['examen_id']) , $examenes ); 

        } else if ($form['examen_id'] == $examenes[0]) {
            $index_examen = 0;

        } else {
            $respuesta = new Response(false, 'El examen indicado no está relacionado a ese seguro');
            return $respuesta->json(400);
        }
        
        unset($examenes[$index_examen]);
        unset($costos[$index_examen]);
        
        // Los volvemos string de nuevo
        $info_update['examenes'] = implode(',', $examenes);
        $info_update['costos'] = implode(',', $costos);
        $isUpdated = $_seguroExamen->update($info_update);

        if ($isUpdated <= 0) {
            $respuesta = new Response('ACTUALIZACION_FALLIDA');
            echo $respuesta->json(400);
            exit();
        }
    }
}
