<?php
include_once './services/Helpers.php';

class AuditoriaController extends Controller {

    protected $arraySelect = array(
        "auditoria.auditoria_id",
        "auditoria.fecha_creacion",
        "auditoria.usuario_id",
        "auditoria.accion",
        "auditoria.descripcion",
        "auditoria.modulo",
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

        if (isset($_GET['accion'])) {
            $_auditoriaModel->where('auditoria.accion', '=', $_GET['accion']);
        }

        if (isset($_GET['usuario_id'])) {
            $_auditoriaModel->where('auditoria.usuario_id', '=', $_GET['usuario_id']);
        }

        if (isset($_GET['modulo'])) {
            $_auditoriaModel->setWhere("`modulo` = " . $_GET['modulo']);
        }

        if (isset($_GET['fecha_inicio'])) {
            $_auditoriaModel->whereDate('DATE(auditoria.fecha_creacion)', $_GET['fecha_inicio'], $_GET['fecha_fin']);
        }

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

        $inners = $_auditoriaModel->listInner($this->arrayInner);
        
        if (isset($_GET['accion'])) {
            $_auditoriaModel->where('auditoria.accion', '=', $_GET['accion']);
        }

        if (isset($_GET['usuario_id'])) {
            $_auditoriaModel->where('auditoria.usuario_id', '=', $_GET['usuario_id']);
        }

        if (isset($_GET['modulo'])) {
            $_auditoriaModel->setWhere("`modulo` = " . $_GET['modulo']);
        }

        if (isset($_GET['fecha_inicio'])) {
            $_auditoriaModel->whereDate('DATE(auditoria.fecha_creacion)', $_GET['fecha_inicio'], $_GET['fecha_fin']);
        }

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

        $total_registros = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $lista);
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

            $inners = $_auditoriaModel->listInner($this->arrayInner);
            $_auditoriaModel->whereDate('DATE(auditoria.fecha_creacion)', $_GET['fecha_inicio'], $_GET['fecha_fin']);

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
            
            $total_registros = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
            Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $id);
        }
    }

    public function listarAuditoriaPorAccion() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

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

        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $_auditoriaModel->where('auditoria.accion', '=', $_GET['accion']);

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

        $total_registros = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $auditoria);
    }

    public function listarAuditoriaPorUsuario($usuario_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

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

        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $_auditoriaModel->where('auditoria.usuario_id', '=', $usuario_id);
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

        $total_registros = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $auditoria);
    }

    public function listarAuditoriaPorModulo() {
        $_auditoriaModel = new AuditoriaModel();

        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $modulo = $_GET['modulo'];
        $_auditoriaModel->setWhere("`modulo` = " . $modulo);

        if (isset($_GET['accion'])) {
            $_auditoriaModel->setWhere("`accion` = " . $_GET['accion']);
        }
        
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
        
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $_auditoriaModel->setWhere("`modulo` = " . $modulo);

        if (isset($_GET['accion'])) {
            $_auditoriaModel->setWhere("`accion` = " . $_GET['accion']);
        }

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

        $total_registros = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");
        Helpers::retornarGet((isset($_GET['draw']) ? $_GET['draw'] : 0), count($total_registros), $auditoria);
    }

    public function exportarBd() {
        // global $isEnabledAudit;
        // $isEnabledAudit = 'exportarBD';
        // $auditDatabase = new AuditHandleDatabase();
        
        $fecha = date("Ymd---His");

        $db_host = 'localhost';
        
        $usuario = 'root';
        
        $password = '';
        
        $bd = 'shenque_db';
        
        $salida_sql = $bd . '_' . $fecha . '.sql';
        
        // Comando local:
        $execute = "c:\\xampp\\mysql\\bin\\mysqldump.exe -u $usuario --password=$password --opt $bd > $salida_sql";
        // Comando del servidor:
        // $execute = "mysqldump -h mysql-shenque.alwaysdata.net -u shenque --password=ShenqueAdmin123$ shenque_db > $salida_sql";

        system($execute, $resultado);
        
        //Se construye el nombre del archivo ZIP ejemplo: mibase_20220101.zip
        
        $zip = new ZipArchive();
        
        $salida_zip = 'respaldo/'. $bd. '_' .$fecha . '.zip'; 

        if($zip->open($salida_zip,ZIPARCHIVE::CREATE) === true){
        
            //Creamos y abrimos el archivo ZIP
            $zip->addFile($salida_sql);
            $zip->close();
        
            // auditoría
            $accion_realizada = 'Exportó';
            $_usuarioModel = new UsuarioModel();
            $usuario = $_usuarioModel->where('rol', '=', 1)->getFirst();
            $description = "El usuario ".$usuario->nombre." exportó la base de datos";
            
            date_default_timezone_set('America/Caracas');
            $hoy = new DateTime();
            $hoy_formateado = $hoy->format('Y-m-d H:i:s');

            $row = [
                "usuario_id" => $usuario->usuario_id,
                "accion" => 'respaldo/restauración',
                "descripcion" => $description,
                "modulo" => 'base de datos',
                "fecha_creacion" => $hoy_formateado,
            ];

            $_auditModel = new AuditoriaModel();
            $inserted = $_auditModel->insert($row);
            // auditoría

            unlink($salida_sql); //Eliminamos el archivo temporal SQL
            header("location: $salida_zip");
        
        } else{
            echo 'Error';
        }
    }

    public function importarBd() {
        $conexionBd = new Database();
        $archivoSql = $_FILES["archivosql"];

        $conexionBd->connect()->exec(file_get_contents($archivoSql["tmp_name"]));
        
        // auditoría
        $_usuarioModel = new UsuarioModel();
        $usuario = $_usuarioModel->where('rol', '=', 1)->getFirst();
        $description = "El usuario ".$usuario->nombre." importó la base de datos";

        date_default_timezone_set('America/Caracas');
        $hoy = new DateTime();
        $hoy_formateado = $hoy->format('Y-m-d H:i:s');

        $row = [
            "usuario_id" => $usuario->usuario_id,
            "accion" => 'respaldo/restauración',
            "descripcion" => $description,
            "modulo" => 'base de datos',
            "fecha_creacion" => $hoy_formateado,
        ];

        $_auditModel = new AuditoriaModel();
        $inserted = $_auditModel->insert($row);
        // auditoría

        $respuesta = new Response(true, 'Se ha realizado correctamente la importación de la base de datos');
        return $respuesta->json(200);
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
