<?php

include_once "./services/facturas/medico/FacturaMedicoHelpers.php";
include_once "./services/facturas/medico/FacturaMedicoService.php";
include_once "./services/facturas/medico/FacturaMedicoValidate.php";

class FacturaMedicoController extends Controller{
    
    protected $arrayInner = array (
        "medico" => "factura_medico"
    );

    protected $arraySelect = array(
        "medico.nombre",
        "medico.apellidos",
        "factura_medico.medico_id",
        "factura_medico.factura_medico_id",
        "factura_medico.acumulado_seguro_total",
        "factura_medico.acumulado_consulta_total",
        "factura_medico.pago_total",
        "factura_medico.pacientes_seguro",
        "factura_medico.pacientes_consulta",
        "factura_medico.fecha_pago"
    );

    //Método index (vista principal)
    public function index(){

        return $this->view('facturas/medico/index');
    }

    public function formRegistrarFacturaMedico(){

        return $this->view('facturas/medico/registrarFacturas');
    }

    public function formActualizarFacturaMedico($factura_medico_id){
        
        return $this->view('facturas/medico/actualizarFacturas', ['factura_medico_id' => $factura_medico_id]);
    } 

    public function solicitarFacturasMedicos(/*Request $request*/) { // método para obtener todas las facturas
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        FacturaMedicoValidate::validacionesPrincipales($_POST);
        $validarFactura = new Validate;
        
        $_medicoModel = new MedicoModel();
        $medicoList = $_medicoModel->where('estatus_med','=', 1)->getAll();
        $data = $validarFactura->dataScape($_POST);

        $_facturaMedicoModel = new FacturaMedicoModel();

        foreach ($medicoList as $medico) {
            
            $factura = array(
                "fecha_actual" => $data['fecha_actual'],
                "medico_id" => $medico->medico_id
            );

            $facturaMedico = FacturaMedicoService::contabilizarFactura($factura);
            $estaDuplicado = FacturaMedicoValidate::validarFacturaMes($factura);

            if (!$estaDuplicado) {
                $isInserted = $_facturaMedicoModel->insert($facturaMedico);

                if ( !($isInserted  > 0) ) {
                    $respuesta = new Response('INSERCION_FALLIDA');
                    $respuesta->setData('Error generando la factura del medico_id' + $medico->medico_id);
                    return $respuesta->json(400);

                } else {
                    FacturaMedicoHelpers::reiniciarAcumuladoMedico($medico->medico_id);
                }

            } else {
                $_facturaMedicoModel = new FacturaMedicoModel();
                $factura = $_facturaMedicoModel->where('factura_medico_id', '=', $estaDuplicado->factura_medico_id)->update($facturaMedico);

                if ( !($factura <= 0) ) {
                    $respuesta = new Response('ACTUALIZACION_FALLIDA');
                    $respuesta->setData('Error generando la factura del medico_id' + $medico->medico_id);
                    return $respuesta->json(400);
                }
            }
        }

        $respuesta = new Response('INSERCION_EXITOSA');
        return $respuesta->json(201);
    }

    public function insertarFacturaMedicoPorId(/*Request $request*/){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        FacturaMedicoValidate::validateInsertMedico($_POST);

        $validarFactura = new Validate;
        $data = $validarFactura->dataScape($_POST);
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $id = $_facturaMedicoModel->insert($data);
        $mensaje = ($id > 0);

        if ($mensaje) {
            FacturaMedicoHelpers::reiniciarAcumuladoMedico($_POST['medico_id']);
        }

        $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
        return $respuesta->json($mensaje ? 201 : 400);
    }

    public function actualizarFacturaMedico($factura_medico_id){

        $_facturaMedico = new FacturaMedicoModel();
        $factura_medico = $_facturaMedico->where('factura_medico_id', '=', $factura_medico_id)->getFirst();

        if ($factura_medico->estatus_fac != '1') {
            $respuesta = new Response(false, 'No puede realizar operaciones con una factura ya cancelada o eliminada');
            $respuesta->setData("Error al actualizar la factura $factura_medico_id con estatus ".($factura_medico->estatus_fac == '2' ? 'anulada' : 'pagado'));
            return $respuesta->json(400);
        }

        date_default_timezone_set('America/Caracas');
        $data = array(
            'estatus_fac' => '3',
            'fecha_pago' => date("Y-m-d H:i:s")
        );
        
        $actualizado = $_facturaMedico->where('factura_medico_id', '=', $factura_medico_id)->update($data);
        
        $isTrue = ($actualizado > 0);
        $respuesta = new Response($isTrue ? 'ACTUALIZACION_EXITOSA' : 'ACTUALIZACION_FALLIDA');
        return $respuesta->json($isTrue ? 200 : 400);
    }

    // Los listar traen los get de facturas registradas en base de datos

    public function listarFacturaMedico(){

        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
        FacturaMedicoHelpers::retornarMensaje($id);
    }

    public function listarFacturaMedicoPorId($factura_medico_id){
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        FacturaMedicoHelpers::retornarMensaje($id);
    }

    public function listarFacturaPorMedico($medico_id){
        
        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->where('medico.medico_id','=',$medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
        FacturaMedicoHelpers::retornarMensaje($id);
    }

    public function listarFacturaPorFecha(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        
        if ( $validarFactura->isDate($_POST['fecha_inicio']) || $validarFactura->isDate($_POST['fecha_fin']) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);

        } else {

            $_facturaMedicoModel = new FacturaMedicoModel();
            $inners = $_facturaMedicoModel->listInner($this->arrayInner);
            $id = $_facturaMedicoModel->whereDate('factura_medico.fecha_pago',$_POST['fecha_inicio'],$_POST['fecha_fin'])->innerJoin($this->arraySelect, $inners, "factura_medico");
            
            FacturaMedicoHelpers::retornarMensaje($id);
        }        
    }

    // Los listar traen los get de facturas registradas en base de datos

    public function calcularFacturaMedicoId() {
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        FacturaMedicoValidate::validateGeneral($_GET); // Validaciones
            
        $formulario = [
            "fecha_actual" => $_GET['fecha'],
            "medico_id" => $_GET['medico'],
        ];
        
        $factura = FacturaMedicoService::contabilizarFactura($formulario);
        
        $respuesta = new Response( ( count($factura) > 0) ? 'CORRECTO' : 'NOT_FOUND');
        $respuesta->setData($factura);
        return $respuesta->json( ( count($factura) > 0) ? 201 : 400);
    }

}
