<?php

class AuditMedicamento extends AuditMiddleware {
    
    public function __construct() {
        parent::__construct();
    }

    public function handleRequest($request = null) {
        
        $this->getToken();
        $this->getUsuario();
        $row = '';
        $accion = '';
        
        if ($this->method == 'POST') {
            $tipo_medicamento = "";

            switch ($_POST['tipo_medicamento']) {
                case '1':
                    $tipo_medicamento = "de tipo Cápsula";
                    break;
                
                case '2':
                    $tipo_medicamento = "de tipo Jarabe";
                    break;
    
                case '3':
                    $tipo_medicamento = "de tipo Inyección";
                    break;
    
                case '4':
                    $tipo_medicamento = "de tipo Solución";
                    break;

                case '5':
                    $tipo_medicamento = "de tipo Gotas";
                    break;

                case '6':
                    $tipo_medicamento = "de tipo Crema/Loción";
                    break;
                
                default:
                    $tipo_medicamento = "";
                    break;
            }
            
            $row = "El usuario ".$this->usuario->nombre." insertó un nuevo medicamento ".$tipo_medicamento." llamado ".$_POST['nombre_medicamento'];
            $accion = 'inserción';
        
        } else if ($this->method == 'PUT') {
            $_medicamentoModel = new MedicamentoModel();
            $medicamento = $_medicamentoModel->where('medicamento_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();
            $nombre_medicamento = !is_null($medicamento) ? $medicamento->nombre_medicamento : 'con id'.preg_replace('/[^0-9]/', '', $_GET['uri']);

            $row = "El usuario ".$this->usuario->nombre." actualizó el medicamento ".$nombre_medicamento;
            $accion = 'actualización';

        } else if ($this->method == 'DELETE') {
            $_medicamentoModel = new MedicamentoModel();
            $medicamento = $_medicamentoModel->where('medicamento_id', '=', preg_replace('/[^0-9]/', '', $_GET['uri']))->getFirst();

            $row = "El usuario ".$this->usuario->nombre." eliminó el medicamento ".$medicamento->nombre_medicamento;
            $accion = 'eliminación';
        }
        
        $this->row = [
            "usuario_id" => $this->usuario->usuario_id,
            "accion" => $accion,
            "descripcion" => $row,
            "modulo" => 'medicamentos',
        ];

        $this->handleResponse();
    }

    public function handleResponse($request = null) {
        
        $this->insertAudit($this->row);
    }
}