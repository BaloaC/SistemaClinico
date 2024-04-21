<?php

include_once './services/Helpers.php';
include_once './services/medico/medico/MedicoService.php';

class MedicoController extends Controller {

    //Método index (vista principal)
    public function index() {

        return $this->view('medicos/index');
    }

    public function formRegistrarMedicos() {

        return $this->view('medicos/registrarMedicos');
    }

    public function formActualizarMedico($medico_id) {

        return $this->view('medicos/actualizarMedicos', ['medico_id' => $medico_id]);
    }

    public function perfilMedico() {
        return $this->view('medicos/perfilMedico');
    }

    public function insertarMedico(/*Request $request*/) {
        global $isEnabledAudit;
        $isEnabledAudit = 'médicos';

        $_POST = json_decode(file_get_contents('php://input'), true);
        MedicoService::insertarMedico($_POST);

        $respuesta = new Response('INSERCION_EXITOSA');
        return $respuesta->json(201);
    }

    public function listarMedicos() {

        $_medicoModel = new MedicoModel();
        $_medicoModel->where('estatus_med', '=', '1');
        
        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_medicoModel->limit([$primer_registro, $size]);
            }

            if (strlen($_GET['search']['value']) > 0) {
                $_medicoModel->where("CONCAT(nombre, ' ', apellidos, ' ', direccion, ' ', cedula)", 'LIKE', "%{$_GET['search']['value']}%");
            }
        }

        $medico2 = $_medicoModel->getAll();
        $_medicoModel->resetValues();

        if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
            $_medicoModel->setSelect('COUNT(*) AS total')->where("CONCAT(nombre, ' ', apellidos, ' ', direccion, ' ', cedula)", 'LIKE', "%{$_GET['search']['value']}%");
        } else {
            $_medicoModel->setSelect('COUNT(*) AS total');
        }
        $total_registros = $_medicoModel->where('estatus_med', '=', '1')->getAll();

        if ($medico2) {
            $resultado = array();

            foreach ($medico2 as $medicos) {
                $resultado[] = MedicoHelpers::obtenerRelaciones($medicos, false);
            }

            Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $resultado);
            // Helpers::retornarMensaje($resultado, $resultado);
        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function listarMedicoPorId($medico_id) {

        $_medicoModel = new MedicoModel();
        $medicos = $_medicoModel->where('estatus_med', '=', '1')->where('medico_id', '=', $medico_id)->getFirst();

        if ($medicos) {
            $resultado = array();
            $resultado[] = MedicoHelpers::obtenerRelaciones($medicos);
            Helpers::retornarMensaje($resultado, $resultado);

        } else {
            $respuesta = new Response('NOT_FOUND');
            return $respuesta->json(200);
        }
    }

    public function actualizarMedico($medico_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'médicos';

        $_POST = json_decode(file_get_contents('php://input'), true);

        MedicoService::actualizarMedico($_POST, $medico_id);
        $respuesta = new Response(true, 'Información insertada correctamente');
        return $respuesta->json(200);
    }

    public function eliminarMedico($medico_id) {
        global $isEnabledAudit;
        $isEnabledAudit = 'médicos';

        $_medicoModel = new MedicoModel();
        $data = array(
            "estatus_med" => "2"
        );

        $eliminado = $_medicoModel->where('medico_id', '=', $medico_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);

        return $respuesta->json($mensaje ? 200 : 400);
    }
}
