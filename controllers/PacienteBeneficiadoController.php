<?php

class PacienteBeneficiadoController extends Controller
{

    public function insertarPacienteBeneficiado($form, $id)
    {

        $paciente_beneficiado_id = $id;

        foreach ($form as $forms) {

            // $forms['paciente_id'] = $form['paciente_id'];
            $camposNumericos = array("tipo_relacion");
            $campoId1 = array("paciente_id");
            $validarPacienteBeneficiado = new Validate;

            switch ($forms) {
                case ($validarPacienteBeneficiado->isEmpty($forms)):
                    $respuesta = new Response(false, 'Los datos del seguro están vacíos');
                    return $respuesta->json(400);

                case $validarPacienteBeneficiado->isNumber($forms, $camposNumericos):
                    $respuesta = new Response(false, 'Los datos del seguro son inválidos');
                    return $respuesta->json(400);

                case !$validarPacienteBeneficiado->existsInDB($forms, $campoId1):
                    $respuesta = new Response(false, 'No se encontraron resultados del paciente titular indicado');
                    return $respuesta->json(404);

                case $forms['tipo_relacion'] > 3:
                    $respuesta = new Response(false, 'Tipo de relación inválida');
                    return $respuesta->json(400);

                default:

                    // Primero insertamos el paciente beneficiario en paciente_beneficiario
                    $data = $validarPacienteBeneficiado->dataScape($forms);
                    $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();

                    $formPacienteBeneficiado['paciente_id'] = $paciente_beneficiado_id;
                    $beneficiado_id = $_pacienteBeneficiadoModel->insert($formPacienteBeneficiado);
                    $mensaje = ($beneficiado_id > 0);

                    if (!$mensaje) {

                        $respuesta = new Response('INSERCION_FALLIDA');
                        return $respuesta->json(400);
                    } else {

                        // Si se inserto, se inserta la relación titular_beneficiario
                        $data['paciente_beneficiado_id'] = $beneficiado_id;

                        if ($validarPacienteBeneficiado->isDuplicatedId('paciente_id', 'paciente_beneficiado_id', $data['paciente_id'], $data['paciente_beneficiado_id'], 'titular_beneficiado')) {
                            $respuesta = new Response(false, 'Ese paciente ya se encuentra asociado a un titular');
                            return $respuesta->json(400);
                        }

                        $_pacienteModel = new PacienteModel();
                        $pacienteTitular = $_pacienteModel->where('paciente_id', '=', $forms['paciente_id'])->where('tipo_paciente', '=', '2')->orWhere('tipo_paciente', '=', '3')->getFirst();
                        $mensaje = ($id > 0);

                        if (!$mensaje) {
                            $respuesta = new Response(false, 'El paciente indicado no puede ser titular');
                            $respuesta->setData($_POST['paciente_id']);
                            return $respuesta->json(400);
                        } else {

                            $data['paciente_beneficiado_id'] = $beneficiado_id;
                            $_titularBeneficiadoModel = new TitularBeneficiadoModel();
                            $tb_id = $_titularBeneficiadoModel->insert($data);
                            $mensajeTitular = ($tb_id > 0);

                            if (!$mensajeTitular) {
                                $respuesta = new Response('INSERCION_FALLIDA');
                                return $respuesta->json(400);
                            }
                        }
                    }
            }
        }
        return false;
    }

    public function listarPacienteBeneficiadoId()
    {

        $arrayInner = array(
            "paciente" => "paciente_beneficiado"
        );

        $arraySelect = array(
            "paciente.paciente_id",
            "paciente.cedula",
            "paciente.nombre",
            "paciente.apellidos",
            "paciente.fecha_nacimiento",
            "paciente.edad",
            "paciente.telefono",
            "paciente.direccion",
            "paciente.tipo_paciente"
        );

        $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();
        $inners = $_pacienteBeneficiadoModel->listInner($arrayInner);
        $paciente = $_pacienteBeneficiadoModel->where('paciente_beneficiado.estatus_pac', '=', '1')->innerJoin($arraySelect, $inners, "paciente_beneficiado");

        $respuesta = new Response($paciente ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($paciente);
        return $respuesta->json(200);
    }

    public function eliminarPacienteBeneficiado($paciente_beneficiado_id)
    {

        $_pacienteBeneficiadoModel = new PacienteBeneficiadoModel();
        $data = array("estatus_pac" => "2");
        $eliminado = $_pacienteBeneficiadoModel->where('paciente_beneficiado_id', '=', $paciente_beneficiado_id)->update($data);

        if ($eliminado > 0) {
            // Una vez eliminado el beneficiado, hay que eliminar las relaciones
            $_titularBeneficiadoModel = new TitularBeneficiadoModel();
            $dataTit = array("estatus_tit" => "2");
            $eliminadoTitulares = $_titularBeneficiadoModel->where('paciente_beneficiado_id', '=', $paciente_beneficiado_id)->update($dataTit);
        }

        $mensaje = ($eliminadoTitulares > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'NOT_FOUND');
        $respuesta->setData($eliminadoTitulares);

        return $respuesta->json(200);
    }
}
