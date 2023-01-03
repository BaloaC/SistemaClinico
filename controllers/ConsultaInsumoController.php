<?php

class ConsultaInsumoController extends Controller{

    public function insertarConsultaInsumo($form, $id){
        
        foreach ($form as $forms) {
            
            $newForm = $forms;
            $newForm['consulta_id'] = $id;
            $camposNumericos = array("insumo_id", "consulta_id");
            $validarConsultaInsumo = new Validate;
            
            switch($_POST) {
                case ($validarConsultaInsumo->isEmpty($newForm)):
                    $respuesta = new Response(false, 'Los datos de los exámenes están vacíos');
                    return $respuesta->json(400);

                case $validarConsultaInsumo->isEliminated("insumo",'estatus_ins',$forms['insumo_id']):
                    $respuesta = new Response(false, 'El insumo indicado no ha sido encontrado en el sistema');
                    return $respuesta->json(404);

                case $validarConsultaInsumo->isNumber($newForm, $camposNumericos):
                    $respuesta = new Response(false, 'Los datos de los insumos seguro son inválidos');
                    return $respuesta->json(400);

                case !$validarConsultaInsumo->existsInDB($newForm, $camposNumericos):   
                    $respuesta = new Response(false, 'No se encontraron resultados de los datos indicados en la base de datos');         
                    return $respuesta->json(404);

                case $validarConsultaInsumo->isDuplicatedId('consulta_id', 'insumo_id', $newForm['consulta_id'], $newForm['insumo_id'], 'consulta_insumo'):
                    $respuesta = new Response(false, 'Ese insumo ya está registrado en la consulta');
                    return $respuesta->json(400);

                default: 
                    
                    $data = $validarConsultaInsumo->dataScape($newForm);
                    $_consultaInsumoModel = new ConsultaInsumoModel();
                    $id = $_consultaInsumoModel->insert($data);
                    $mensaje = ($id > 0);
                    
                    if ($mensaje) {
                        
                        // Restando la cantidad de la factura al stock del inventario
                        $_insumoModel = new InsumoModel();
                        $insumo = $_insumoModel->where('insumo_id', '=', $newForm['insumo_id'])->getFirst();

                        if ( $newForm['cantidad'] > $insumo->stock ) {
                            
                            $respuesta = new Response(false, 'Cantidad de insumos mayor a la que hay en existencia');
                            return $respuesta->json(400);
                        }

                        $unidadesPosts = $insumo->stock - $newForm['cantidad'];
                        $actualizar = array('stock' => $unidadesPosts);

                        // actualizando el stock del insumo
                        $actualizado = $_insumoModel->where('insumo_id', '=', $newForm['insumo_id'])->update($actualizar);
                        if (!$actualizado) {

                                $respuesta = new Response(false, 'Hubo un error en la actualización del insumo');
                                $respuesta->setData($newForm);
                                return $respuesta->json(400);
                        }

                    } else if (!$mensaje) {  
                        $respuesta = new Response(false, 'Actualización del insumo fallida');
                        return $respuesta->json(400);
                    }
                    
           }
        }
        return false;
    }
}



?>