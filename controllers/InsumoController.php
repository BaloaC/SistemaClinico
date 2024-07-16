<?php

include_once './services/Helpers.php';

class InsumoController extends Controller{

    //Método index (vista principal)
    public function index(){

        return $this->view('insumos/index');
    }

    public function formRegistrarInsumo(){

        return $this->view('insumos/registrarInsumos');
    }

    public function formActualizarInsumo($insumo_id){
        
        return $this->view('insumos/actualizarInsumos', ['insumo_id' => $insumo_id]);
    } 

    public function insertarInsumo(/*Request $request*/){
        global $isEnabledAudit;
        $isEnabledAudit = 'insumos';

        $_POST = json_decode(file_get_contents('php://input'), true);
        
        $camposNumericos = array("precio", "cantidad_unidad", "capacidad_unidad", "cantidad_capacidad");
        $exclude = array("es_cobrado", "precio");
        $validarInsumo = new Validate;
        
        switch($validarInsumo) {
            case ($validarInsumo->isEmpty($_POST, $exclude)):
                $respuesta = new Response('DATOS_VACIOS');
                return $respuesta->json(400);

            case $validarInsumo->isDuplicated('insumo', 'nombre', $_POST["nombre"]):
                $respuesta = new Response('DATOS_DUPLICADOS');
                return $respuesta->json(400);

            case $validarInsumo->isNumber($_POST, $camposNumericos):
                $respuesta = new Response('DATOS_INVALIDOS');
                return $respuesta->json(404);

            default:
                
                $data = $validarInsumo->dataScape($_POST);
                
                $data['cantidad_capacidad'] = 0 * $data['capacidad_unidad'];

                if (!$data['es_cobrado']) {
                    $data['precio'] = 0;
                }
                
                $_insumoModel = new InsumoModel();
                $id = $_insumoModel->insert($data);
                $mensaje = ($id > 0);

                $respuesta = new Response($mensaje ? 'INSERCION_EXITOSA' : 'INSERCION_FALLIDA');
                return $respuesta->json($mensaje ? 201 : 400);
        }
    }

    public function listarInsumo(){

        $_insumoModel = new InsumoModel();
        $_insumoModel->where('estatus_ins', '!=', '2');

        if (isset($_GET['agotado']) && $_GET['agotado'] == 'false') {
            $_insumoModel->where('cantidad_unidad', '!=', '0');
        }

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = floor($_GET['start'] / $_GET['length']) + 1;

                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_insumoModel->limit([$primer_registro, $size]);
            }
    
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_insumoModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_insumoModel->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $lista = $_insumoModel->getAll();
        $_insumoModel->resetValues();

        if (isset($_GET['agotado']) && $_GET['agotado'] == 'false') {
            $_insumoModel->where('cantidad_unidad', '!=', '0');
        }
        
        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_insumoModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_insumoModel->setSelect('COUNT(*) AS total')->where('CONCAT(nombre)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_insumoModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_insumoModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_insumoModel->where('estatus_ins', '!=', '2')->getAll();        
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $lista);
    }

    public function listarInsumoPorId($insumo_id){

        $_insumoModel = new InsumoModel();
        $insumo = $_insumoModel->where('estatus_ins', '!=', '2')->where('insumo_id','=',$insumo_id)->getFirst();
        $mensaje = ($insumo != null);
        Helpers::retornarMensaje($mensaje, $insumo);
    }

    public function eliminarInsumo($insumo_id){
        global $isEnabledAudit;
        $isEnabledAudit = 'insumos';
        
        $_insumoModel = new InsumoModel();
        $data = array(
            "estatus_ins" => "2"
        );

        $eliminado = $_insumoModel->where('insumo_id','=',$insumo_id)->update($data);
        $mensaje = ($eliminado > 0);

        $respuesta = new Response($mensaje ? 'ELIMINACION_EXITOSA' : 'ELIMINACION_FALLIDA');
        $respuesta->setData($eliminado);
        return $respuesta->json($mensaje ? 200 : 404);

    }
}
