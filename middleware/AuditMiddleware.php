<?php

class AuditMiddleware extends Middleware {
    public $method;
    protected $row;
    protected $POST;
    protected $data;
    protected $code;
    protected $modulo;
    
    public function __construct() {
        parent::__construct();

        $this->code;
        $this->data;
        $this->POST = json_decode(file_get_contents('php://input'), true);
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    public function setValues($data, $code) {
        $this->code = $code;
        $this->data = $data;
    }

    public function handleRequest($request = null) {
        $this->getToken(); 
        $this->getUsuario(); 
        $this->insertAudit();
        global $isEnabledAudit;
        $this->modulo = $isEnabledAudit;

        $accion = '';
        
        switch ($this->method) {
            case 'POST':
                $this->row = $this->usuario->nombre." ha insertado un nuevo elemento ".$_POST['nombre']." en el módulo $isEnabledAudit";
                break;
            
            case 'PUT': {
                $campos = array_keys($_POST);
                $this->row = $this->usuario->nombre." ha actualizado al elemento id ".preg_replace('/[^0-9]/', '', $_GET['uri'])." los campos ".implode(", ", $campos)." en el módulo $isEnabledAudit";
                break;
            }
            
            case 'DELETE':
                $identificador = ""; $nombre_tabla = "";

                try {

                    if ($isEnabledAudit == 'exámenes') {
                        $nombre_tabla = 'examen';

                    } else if ($isEnabledAudit == 'proveedores') {
                        $nombre_tabla = 'proveedor';

                    } else {
                        $nombre_tabla = substr($isEnabledAudit, -1) == 's' ? substr($isEnabledAudit, 0, -1) : $isEnabledAudit;
                    }

                    $nombre_modelo = ucfirst($nombre_tabla)."Model";
                    $modelo = new $nombre_modelo();
                    $registro = $modelo->where($nombre_tabla.'_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();

                    if (isset($registro->nombre) || isset($registro->nombres)) {
                        $identificador = isset($registro->nombre) ? $registro->nombre : $registro->nombres;
                    }
                } catch (\Throwable $th) {
                    $identificador = "id ".preg_replace('/[^0-9]/', '', $_GET['uri']);
                }
                

                $this->row = $this->usuario->nombre." ha eliminado al elemento ".$identificador." en el módulo $isEnabledAudit";
                break;
        }

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        $accion = "";
        global $isEnabledAudit;

        if ( $this->method == 'POST' ) {
            $accion = 'inserción';
        } else {
            $accion = $this->method == 'PUT' ? 'actualización' : 'eliminación';
        }
        
        $data = [
            "usuario_id" => $this->usuario->usuario_id,
            "descripcion" => $this->row,
            "accion" =>  $accion,
            "modulo" => $this->modulo,
        ];

        $_auditModel = new AuditoriaModel();
        $_auditModel->insert($data);
    }

    public function insertAudit() {
        $_auditModel = new AuditoriaModel();
        $inserted = $_auditModel->insert($this->row);
    }
}