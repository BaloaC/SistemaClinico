<?php

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

        // ** Enrique
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $lista = $_auditoriaModel->innerJoin($this->arraySelect, $inners, "auditoria");

        return $this->retornarMensaje($lista);
    }

    public function listarAuditoriaPorFecha() {

        $_POST = json_decode(file_get_contents('php://input'), true);
        $validarAuditoria = new Validate;

        if ($validarAuditoria->isDate($_POST['fecha_inicio']) || $validarAuditoria->isDate($_POST['fecha_fin'])) {
            $respuesta = new Response('FECHA_INVALIDA');
            return $respuesta->json(400);
        } else if ($_POST['fecha_inicio'] > $_POST['fecha_fin']) {
            $respuesta = new Response(false, 'La fecha de inicio no puede ser mayor a la fecha final');
            return $respuesta->json(400);
        } else {

            $_auditoriaModel = new AuditoriaModel();

            // ** Enrique
            $inners = $_auditoriaModel->listInner($this->arrayInner);
            $id = $_auditoriaModel->whereDate('DATE(auditoria.fecha_creacion)', $_POST['fecha_inicio'], $_POST['fecha_fin'])->innerJoin($this->arraySelect, $inners, "auditoria");

            return $this->retornarMensaje($id);
        }
    }

    public function listarAuditoriaPorAccion() {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        // ** Enrique
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $auditoria = $_auditoriaModel->where('auditoria.accion', '=', $_POST['accion'])->innerJoin($this->arraySelect, $inners, "auditoria");
        return $this->retornarMensaje($auditoria);
    }

    public function listarAuditoriaPorUsuario($usuario_id) {
        $_POST = json_decode(file_get_contents('php://input'), true);
        $_auditoriaModel = new AuditoriaModel();

        // ** Enrique
        $inners = $_auditoriaModel->listInner($this->arrayInner);
        $auditoria = $_auditoriaModel->where('auditoria.usuario_id', '=', $usuario_id)->innerJoin($this->arraySelect, $inners, "auditoria");
        return $this->retornarMensaje($auditoria);
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

        $salida_zip = $bd . '_' . $fecha . '.zip'; // Nombre del archivo ZIP

        $ruta_salida_zip = '/respaldo/' . $salida_zip; // Ruta completa del archivo ZIP

        if ($zip->open($ruta_salida_zip, ZIPARCHIVE::CREATE) === true) {

            //Creamos y abrimos el archivo ZIP

            $zip->addFile($ruta_salida_zip, $salida_sql); //Agregamos el archivo SQL a ZIP
            $zip->close(); // Cerramos el ZIP

            unlink($ruta_salida_zip); //Eliminamos el archivo temporal SQL
            header("location: $ruta_salida_zip"); // Redireccionamos para descargar el archivo ZIP

        } else {
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
