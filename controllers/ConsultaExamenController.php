<?php

class ConsultaExamenController extends Controller{

    public function insertarConsultaExamen($form, $id){
        
        $consulta_id = $id;

        foreach ($form as $forms) {
            // echo $forms;
            $newForm = $forms;
            $newForm['consulta_id'] = $consulta_id;
            $camposNumericos = array("examen_id", "consulta_id");
            $validarConsultaExamen = new Validate;
            
            switch($_POST) {
                case ($validarConsultaExamen->isEmpty($newForm)):
                    $respuesta = new Response(false, 'Los datos de los exámenes están vacíos');
                    return $respuesta->json(400);

                case $validarConsultaExamen->isEliminated("examen",'estatus_exa',$forms['examen_id']):
                    $respuesta = new Response(false, 'El examen indicado no ha sido encontrado en el sistema');
                    return $respuesta->json(404);

                case $validarConsultaExamen->isNumber($newForm, $camposNumericos):
                    $respuesta = new Response(false, 'Los datos de los exámenes seguro son inválidos');
                    return $respuesta->json(400);

                case !$validarConsultaExamen->existsInDB($newForm, $camposNumericos):   
                    $respuesta = new Response(false, 'No se encontraron resultados de los datos indicados en la base de datos');         
                    return $respuesta->json(404);

                case $validarConsultaExamen->isDuplicatedId('consulta_id', 'examen_id', $newForm['consulta_id'], $newForm['examen_id'], 'consulta_examen'):
                    $respuesta = new Response(false, 'Ese examen ya está registrado en la consulta');
                    return $respuesta->json(400);

                default: 
                    
                    $_examenModel = new ExamenModel();
                    $examen = $_examenModel->where('examen_id', '=', $newForm['examen_id'])->getFirst();
                    $newForm['precio_examen_usd'] = $examen->precio_examen;

                    $_globalModel = new GlobalModel();
                    $valorDivisa = $_globalModel->whereSentence('key', '=', 'cambio_divisa')->getFirst();

                    $newForm['precio_examen_bs'] = $examen->precio_examen * $valorDivisa->value;

                    $data = $validarConsultaExamen->dataScape($newForm);
                    $_consultaExamenModel = new ConsultaExamenModel();
                    $idExamen = $_consultaExamenModel->insert($data);
                    $mensaje = ($idExamen > 0);
                    
                    if (!$mensaje) {  

                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json(400);
                    }
                    
           }
        }
        return false;
    }
    
    public function eliminarConsultaExamen($consulta_examen_id){

        $_consultaExamenModel = new ConsultaExamenModel();
        $data = array(
            "estatus_con" => "2"
        );

        $eliminado = $_consultaExamenModel->where('consulta_examen_id','=',$consulta_examen_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }

    // public function actualizarConsultaExamen($form, $id){
    //     $consultaID = $id;
    //     foreach ($form as $forms) {
            
    //         $newForm = $forms;
    //         $newForm['consulta_id'] = $consultaID;
    //         $camposNumericos = array("examen_id", "consulta_id");
    //         $validarConsultaExamen = new Validate;
            
    //         switch($_POST) {
    //             case $validarConsultaExamen->isEliminated("examen",'estatus_exa',$forms['examen_id']):
    //                 $respuesta = new Response(false, 'El examen indicado no ha sido encontrado en el sistema');
    //                 return $respuesta->json(404);

    //             case ($validarConsultaExamen->isEmpty($newForm)):
    //                 $respuesta = new Response(false, 'Los datos de los exámenes están vacíos');
    //                 return $respuesta->json(400);

    //             case $validarConsultaExamen->isNumber($newForm, $camposNumericos):
    //                 $respuesta = new Response(false, 'Los datos de los exámenes seguro son inválidos');
    //                 return $respuesta->json(400);

    //             case !$validarConsultaExamen->existsInDB($newForm, $camposNumericos):   
    //                 $respuesta = new Response(false, 'No se encontraron resultados de los datos indicados en la base de datos');         
    //                 return $respuesta->json(404);

    //             case $validarConsultaExamen->isDuplicatedId('consulta_id', 'examen_id', $newForm['consulta_id'], $newForm['examen_id'], 'consulta_examen'):
    //                 $respuesta = new Response(false, 'Ese examen ya está registrado en la consulta');
    //                 return $respuesta->json(400);

    //             default: 
                    
    //                 $data = $validarConsultaExamen->dataScape($newForm);
    //                 $_consultaExamenModel = new ConsultaExamenModel();
    //                 $id = $_consultaExamenModel->insert($data);
    //                 $mensaje = ($id > 0);
                    
    //                 if (!$mensaje) {
    //                     $respuesta = new Response('INSERCION_FALLIDA');
    //                     return $respuesta->json(400);
    //                 }
    //         }
                    
    //     }
    //        return false;
    // }
}
