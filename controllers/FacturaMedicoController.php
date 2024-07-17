<?php

include_once "./services/facturas/medico/FacturaMedicoHelpers.php";
include_once "./services/facturas/medico/FacturaMedicoService.php";
include_once "./services/facturas/medico/FacturaMedicoValidate.php";
include_once './services/consulta/consultaService.php';
include_once "./services/Helpers.php";

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
        "factura_medico.sumatoria_consultas_aseguradas",
        "factura_medico.sumatoria_consultas_naturales",
        "factura_medico.acumulado_medico",
        "factura_medico.pago_total",
        "factura_medico.pacientes_seguro",
        "factura_medico.pacientes_consulta",
        // "factura_medico.fecha_pago",
        "factura_medico.fecha_emision",
        "factura_medico.estatus_fac"
        // "factura_medico.precio_dolar"
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

    public function insertarAcumuladosConsultas() {
        global $isEnabledAudit;
        $isEnabledAudit = 'recibo de pago médico';

        $_POST = json_decode(file_get_contents('php://input'), true);
        FacturaMedicoValidate::validacionesPrincipales($_POST);
        $validarFactura = new Validate;

        $_facturaMedicoModel = new FacturaMedicoModel();
        $_medicoModel = new MedicoModel();
        $medicoList = [];
        $data = $validarFactura->dataScape($_POST);

        if ( isset($_POST['medico_id']) && !is_null($_POST['medico_id']) ) {
            $medicoList[] = $_medicoModel->where('estatus_med','=', 1)->where('medico_id', '=', $_POST['medico_id'])->getFirst();
        } else {
            $medicoList = $_medicoModel->where('estatus_med','=', 1)->getAll();
        }

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
                    echo $respuesta->json(400);
                    exit();

                } else {
                    FacturaMedicoHelpers::reiniciarAcumuladoMedico($medico->medico_id);
                }
            } else {
                $_facturaMedicoModel = new FacturaMedicoModel();
                $factura = $_facturaMedicoModel->where('factura_medico_id', '=', $estaDuplicado->factura_medico_id)->update($facturaMedico);

                if ( !($factura <= 0) ) {
                    $respuesta = new Response('ACTUALIZACION_FALLIDA');
                    $respuesta->setData('Error generando la factura del medico_id' + $medico->medico_id);
                    echo $respuesta->json(400);
                    exit();
                }
            }
        }

        $respuesta = new Response('INSERCION_EXITOSA');
        echo $respuesta->json(201);
        exit();
    }

    // Los listar traen los get de facturas registradas en base de datos

    public function listarFacturaMedico(){

        $_facturaMedicoModel = new FacturaMedicoModel();
        if (isset($_GET['start']) || isset($_GET['search'])) {
            if (isset($_GET['start'])) {
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_facturaMedicoModel->limit([$primer_registro, $size]);
            }

            if (strlen($_GET['search']['value']) > 0) {
                $_facturaMedicoModel->where('CONCAT(medico.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            }
        }

        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");

        $_facturaMedicoModel->resetValues();

        if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
            $_facturaMedicoModel->setSelect('COUNT(*) AS total')->where('CONCAT(medico.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
        } else {
            $_facturaMedicoModel->setSelect('COUNT(*) AS total');
        }

        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $total = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
        
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total), $id);
    }

    public function listarFacturaMedicoPorId($factura_medico_id){
        $_facturaMedicoModel = new FacturaMedicoModel();
        $inners = $_facturaMedicoModel->listInner($this->arrayInner);
        $id = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        $factura_total = FacturaMedicoHelpers::calcularMontosBs($id[0]);
        Helpers::retornarMensaje($id, $factura_total);
    }
    // public function listarFacturaMedicoPorId($factura_medico_id){
        
    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //     $id = $_facturaMedicoModel->where('factura_medico_id','=',$factura_medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
    //     $factura_total = FacturaMedicoHelpers::calcularMontosBs($id[0]);
    //     Helpers::retornarMensaje($id, $factura_total);
    // }

    // public function listarFacturaPorMedico($medico_id){
        
    //     $_facturaMedicoModel = new FacturaMedicoModel();
    //     $inners = $_facturaMedicoModel->listInner($this->arrayInner);
    //     $id = $_facturaMedicoModel->where('medico.medico_id','=',$medico_id)->innerJoin($this->arraySelect, $inners, "factura_medico");
        
    //     FacturaMedicoHelpers::retornarMensaje($id);
    // }

    public function listarFacturaPorFecha(){
        
        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarFactura = new Validate;
        
        if ( isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin']) && ($validarFactura->isDate($_GET['fecha_inicio']) || $validarFactura->isDate($_GET['fecha_fin'] )) ) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);

        } else {

            $_facturaMedicoModel = new FacturaMedicoModel();

            if (isset($_GET['start']) || isset($_GET['search'])) {
                if (isset($_GET['start'])) {
                    $size = isset($_GET['length']) ? $_GET['length'] : 10;
                    $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;
    
                    $ultimo_registro = $pagina_actual * $size;
                    $primer_registro = $ultimo_registro - $size;
                    $_facturaMedicoModel->limit([$primer_registro, $size]);
                }
    
                if (strlen($_GET['search']['value']) > 0) {
                    $_facturaMedicoModel->where('CONCAT(medico.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
                }
            }

            $inners = $_facturaMedicoModel->listInner($this->arrayInner);
            if ( isset($_GET['medico']) && !is_null($_GET['medico']) ) {
                $_facturaMedicoModel->where('factura_medico.medico_id', '=', $_GET['medico']);
            }

            if ( isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin']) ) {
                $_facturaMedicoModel->whereDate('factura_medico.fecha_emision',$_GET['fecha_inicio'],$_GET['fecha_fin']);
            }

            $lista = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
            
            $_facturaMedicoModel->resetValues();
            
            if (isset($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                $_facturaMedicoModel->setSelect('COUNT(*) AS total')->where('CONCAT(medico.nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_facturaMedicoModel->setSelect('COUNT(*) AS total');
            }

            $inners = $_facturaMedicoModel->listInner($this->arrayInner);
            if ( isset($_GET['medico']) && !is_null($_GET['medico']) ) {
                $_facturaMedicoModel->where('factura_medico.medico_id', '=', $_GET['medico']);
            }

            if ( isset($_GET['fecha_inicio']) && isset($_GET['fecha_fin']) ) {
                $_facturaMedicoModel->whereDate('factura_medico.fecha_emision',$_GET['fecha_inicio'],$_GET['fecha_fin']);
            }

            $total_registros = $_facturaMedicoModel->innerJoin($this->arraySelect, $inners, "factura_medico");
            Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($lista), $lista);
        }        
    }

    public function listarConsultasPorAcumulado($factura_medico_id) {
        $_facturaMedicoModel = new FacturaMedicoModel();
        $factura = $_facturaMedicoModel->where('factura_medico_id', '=', $factura_medico_id)->getFirst();

        if (is_null($factura)) {
            $respuesta = new Response('NOT_FOUND');
            $respuesta->setData('El registro indicado no existe en el sistema '.$factura_medico_id);
            echo $respuesta->json(404);
            exit();
        }
        $_facturaMedicoModel->resetValues();

        $fecha_factura = $factura->fecha_emision;
        $fecha_mes = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_factura);
        
        $fecha_mes->modify('first day of this month');
        $fecha_inicio = $fecha_mes->format("Y-m-d");
        
        $fecha_mes->modify('last day of this month');
        $fecha_fin = $fecha_mes->format("Y-m-d");

        $inner = 'INNER JOIN consulta_cita ON consulta_cita.cita_id = cita.cita_id INNER JOIN consulta ON consulta.consulta_id = consulta_cita.consulta_id';
        $citas_medico = $_facturaMedicoModel->where('cita.medico_id', '=', $factura->medico_id)
                                                ->whereDate('consulta.fecha_consulta', $fecha_inicio, $fecha_fin)
                                                ->innerJoin(['consulta_cita.consulta_id', 'consulta.fecha_consulta'], $inner, 'cita');
        
        $consultas_por_citas = [];
        if (!is_null($citas_medico)) {
            foreach ($citas_medico as $consulta_cita) {
                $consultas_por_citas[] = ConsultaService::obtenerConsultaNormal($consulta_cita, false);
            }
        }

        $_consultaSinCita = new ConsultaSinCitaModel();
        $inner_consulta = $_consultaSinCita->listInner(['consulta' => 'consulta_sin_cita']);
        $consultas_medicos = $_consultaSinCita->where('consulta_sin_cita.medico_id', '=', $factura->medico_id)
                                                ->whereDate('consulta.fecha_consulta', $fecha_inicio, $fecha_fin)
                                                ->innerJoin(['consulta_sin_cita.consulta_id', 'consulta.fecha_consulta'], $inner_consulta, 'consulta_sin_cita');
        
        $consultas_sin_citas = [];
        if (!is_null($consultas_medicos)) {
            foreach ($consultas_medicos as $consulta) {
                $consultas_sin_citas[] = ConsultaService::obtenerConsultaNormal($consulta_cita, false);
            }
        }
        
        $consultas_totales = array_merge((Array) $consultas_por_citas, (Array) $consultas_por_citas);

        $respuesta = new Response( 'CORRECTO');
        $respuesta->setData($consultas_totales);
        return $respuesta->json(200);
    }

}
