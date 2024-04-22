<?php
include_once './services/Helpers.php';

class AuditoriaController extends Controller {

    protected $arraySelect = array(
        "auditoria.auditoria_id",
        "auditoria.fecha_creacion",
        "auditoria.usuario_id",
        "auditoria.accion",
        "auditoria.descripcion",
        "usuario.nombre as nombre_usuario",
    );

    protected $arrayInner = array(
        "usuario" => "auditoria",
    );

    //Método index (vista principal)
    public function index() {
        return $this->view('auditoria/index');
    }

    public function listarAuditoria() {
        $_auditoriaModel = new AuditoriaModel();
        $inners = $_auditoriaModel->listInner($this->arrayInner);

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                
                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_auditoriaModel->limit([$primer_registro, $size]);
            }
            
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }
    
        $lista = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        $_auditoriaModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_auditoriaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_auditoriaModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_auditoriaModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $lista);
    }

    public function listarAuditoriaPorFecha() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarAuditoria = new Validate;

        if ($validarAuditoria->isDate($_GET['fecha_inicio']) || $validarAuditoria->isDate($_GET['fecha_fin'])) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);
        } else if ($_GET['fecha_inicio'] > $_GET['fecha_fin']) {
            $respuesta = new Response(false, 'La fecha de inicio no puede ser mayor a la fecha final');
            return $respuesta->json(400);
        } else {

            $_auditoriaModel = new AuditoriaModel();
            $inners = $_auditoriaModel->listInner($this->arrayInner);
            $_auditoriaModel->whereDate('DATE(auditoria.fecha_creacion)', $_GET['fecha_inicio'], $_GET['fecha_fin']);

            if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
                if (isset($_GET['start']) || isset($_GET['page'])) {
                    
                    $size = isset($_GET['length']) ? $_GET['length'] : 10;
                    $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                    
                    $ultimo_registro = $pagina_actual * $size;
                    $primer_registro = $ultimo_registro - $size;
                    $_auditoriaModel->limit([$primer_registro, $size]);
                }
                
                if(isset($_GET['search'])) {
                    if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                        $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
                    } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                        $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
                    }
                }
            }

            $id = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
            $_auditoriaModel->resetValues();

            if ( isset($_GET['search']) ) {
                if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
                } else if ( strlen($_GET['search']['value']) > 0) {
                    $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
                } else {
                    $_auditoriaModel->setSelect('COUNT(*) AS total');
                }
            } else {
                $_auditoriaModel->setSelect('COUNT(*) AS total');
            }

            $total_registros = $_auditoriaModel->getAll();
            Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $id);
        }
    }

    public function listarAuditoriaPorAccion() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        // ** Enrique
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $_auditoriaModel->where('auditoria.accion', '=', $_GET['accion']);
        
        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                
                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_auditoriaModel->limit([$primer_registro, $size]);
            }
            
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }

        $auditoria = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        $_auditoriaModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_auditoriaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_auditoriaModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_auditoriaModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $auditoria);
    }

    public function listarAuditoriaPorUsuario($usuario_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        // ** Enrique
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $_auditoriaModel->where('auditoria.usuario_id', '=', $usuario_id);

        if (isset($_GET['start']) || isset($_GET['search']) || isset($_GET['page']) ){
            if (isset($_GET['start']) || isset($_GET['page'])) {
                
                $size = isset($_GET['length']) ? $_GET['length'] : 10;
                $pagina_actual = isset($_GET['page']) ? $_GET['page'] : floor($_GET['start'] / $_GET['length']) + 1;
                
                $ultimo_registro = $pagina_actual * $size;
                $primer_registro = $ultimo_registro - $size;
                $_auditoriaModel->limit([$primer_registro, $size]);
            }
            
            if(isset($_GET['search'])) {
                if (is_array($_GET['search']) && strlen($_GET['search']['value']) > 0) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
                } else if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                    $_auditoriaModel->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
                }
            }
        }
        
        $auditoria = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        $_auditoriaModel->resetValues();

        if ( isset($_GET['search']) ) {
            if (!is_array($_GET['search']) && strlen($_GET['search']) > 0 && $_GET['select']) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']}%");
            } else if ( strlen($_GET['search']['value']) > 0) {
                $_auditoriaModel->setSelect('COUNT(*) AS total')->where('CONCAT(descripcion)', 'LIKE', "%{$_GET['search']['value']}%");
            } else {
                $_auditoriaModel->setSelect('COUNT(*) AS total');
            }
        } else {
            $_auditoriaModel->setSelect('COUNT(*) AS total');
        }

        $total_registros = $_auditoriaModel->getAll();
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), $total_registros[0]->total, $auditoria);
    }

    public function exportarBd() {

        $fecha = date("Ymd---His");

        $db_host = 'localhost'; // Servidor
        
        $usuario = 'root'; // Usuario de la base de datos
        
        $password = ''; //Contraseña bd
        
        $bd = 'shenque_db'; //Nombre de la base de datos
        
        $salida_sql = $bd . '_' . $fecha . '.sql'; //Nombre del archivo .sql
        
        $execute = "c:\\xampp\\mysql\\bin\\mysqldump.exe -u $usuario --password=$password --opt $bd > $salida_sql"; //Funciones para exportar la base de datos
        
        system($execute, $resultado);
        
        //Se construye el nombre del archivo ZIP ejemplo: mibase_20220101.zip
        
        $zip = new ZipArchive(); // Objeto de la libreria interna ZipArchive
        
        $salida_zip = $bd. '_' .$fecha . '.zip'; // Nombre del archivo ZIP
        
        if($zip->open($salida_zip,ZIPARCHIVE::CREATE) === true){
        
            //Creamos y abrimos el archivo ZIP
        
            $zip->addFile($salida_sql); //Agregamos el archivo SQL a ZIP
            $zip->close(); // Cerramos el ZIP
        
            unlink($salida_sql); //Eliminamos el archivo temporal SQL
            header("location: $salida_zip"); // Redireccionamos para descargar el archivo ZIP
        
        } else{
            echo 'Error'; // Enviamos el mensaje de error
        }
    }

    // utils
    public function retornarMensaje($id)
    {
        $mensaje = (count($id) > 0);

        if ($mensaje) {
            $respuesta = new Response('CORRECTO');
        } else {
            $respuesta = new Response(false, 'No existen registros auditables para esa fecha o acción');
        }
        $respuesta->setData($id);
        return $respuesta->json(200);
    }
}
