<?php

require_once 'database/Database.php';

class BaseModel{

    protected $connection;
    protected $table;
    protected $sql = null;
    protected $wheres = "";
    protected $user;
    protected $campo;

    public function __construct($table = null){

        $this->connection = (new Database())->connect();
        $this->table = $table;
    }  

    //Método para obtener todos los registros de una tabla
    public function getAll(){
        try {

            $this->sql = "SELECT * FROM {$this->table} {$this->wheres}";
            
            $query = $this->connection->prepare($this->sql);
            $query->execute();

            return $query->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $error) {

            return $error->getMessage();
        }
    }

    //Método para obtener el primer registro de una consulta
    public function getFirst(){

        $list = $this->getAll();
        
        if(count($list) > 0){

            return $list[0];

        } else{

            return null;
        }
    }

    //Método para insertar un registro
    public function insert($obj){
        try {
            $keys = implode("`, `",array_keys($obj));
            $values = ":" . implode(", :",array_keys($obj));
            
            $this->sql = "INSERT INTO $this->table (`$keys`) VALUES($values)";
            // echo $this->sql;
            $this->campo = str_replace("_"," ",$this->table);
            $this->execute($obj);

            $id = $this->connection->lastInsertId();

            $this->insertarAuditoria('Inserto', 'insert', $id);
            return $id;

        } catch (PDOException $error) {
            
            //Para solucionar el error de validación en el controller retornar $id = 0;
            return $error->getMessage();
        }
    }

    //Método para realizar un update a un registro
    public function update($obj, $option){

        try {
            
            $keys = "";
            // Código para la auditoria
            $userAfectado = preg_replace('/[^0-9]/', '', $this->wheres);
            $this->campo = str_replace("_"," ",$this->table);
        
            foreach($obj as $key => $value){
                $keys .= "`$key`=:$key,";
            }

            $keys = rtrim($keys,',');
            $this->sql = "UPDATE $this->table SET $keys $this->wheres";
            $affectedRows = $this->execute($obj); 
            
            if ($option == 0) { $this->insertarAuditoria('Actualizó', 'update', $userAfectado); }
            else  { $this->insertarAuditoria('Eliminó', 'delete', $userAfectado); }

            return $affectedRows;

        } catch (PDOException $error) {
            
            return $error->getMessage();
        }
    }

    //Método para eliminar un registro (hay que modificarlo xd)
    public function delete(){

        try {

            $this->sql = "DELETE FROM $this->table $this->wheres";
            $affectedRows = $this->execute();

            return $affectedRows;
            
        } catch (PDOException $error) {

            return $error->getMessage();
        }
    }

    //Método para filtrar con AND
    public function whereDate($key,$fecha_inicio,$fecha_fin){

        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "$key BETWEEN '$fecha_inicio' AND '$fecha_fin' ";
        
        return $this;
    }

    //Método para filtrar con AND
    public function where($key,$condition, $value){

        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " AND " : " WHERE ";
        $this->wheres .= "$key $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";
        
        return $this;
    }

    //Método para filtrar con OR
    public function orWhere($key,$condition, $value){

        $this->wheres .= (strpos($this->wheres, "WHERE")) ? " OR " : " WHERE ";
        $this->wheres .= "$key $condition " . ((is_string($value)) ? "\"$value\"" : $value) . " ";

        return $this;
    }

    // Armar los inner del inner join
    public function listInner($obj) {
        $inner = array();

        foreach ($obj as $key => $ref) {
            $line = "INNER JOIN $key ON $key.$key"."_id = $ref".".$key"."_id";
            $inner[] = $line;
        }
        
        return implode(" ", $inner);
    }

    // Armar el inner join completo
    public function innerJoin($obj, $listInner, $table) {

        try {
            
            $inner_join = implode(", ", $obj);
            $this->table = $table;
            $inners = $listInner;

            $this->sql = "SELECT $inner_join FROM $this->table"." $inners $this->wheres";
            
            $query = $this->connection->prepare($this->sql);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_OBJ);

        } catch (PDOException $error) {
            
            return $error->getMessage();
        }
    }

    //Método para enviar el id del usuario que está realizando la acción
    public function byUser($obj, $option = 0) {
        
        if ($option == 0) { $sql = 'SELECT * FROM usuario WHERE tokken = "'.$obj.'"';
        } else { $sql = "SELECT * FROM $this->table WHERE $this->table"."_id = $obj"; }

        $query = $this->connection->prepare($sql);
        $query->execute();
        $user = $query->fetchAll(PDO::FETCH_OBJ);
        if ($option == 0) {
            $this->user = $user[0]->usuario_id;
        } else {
            
            if (isset($user[0]->nombre)) {
                return $user[0]->nombre;
            } else {
                return "";   
            }
            
        }
    }

    //Método para ejectuar una consulta
    private function execute($obj = null){

        $query = $this->connection->prepare($this->sql);

        if($obj !== null){
            
            foreach($obj as $key => $value){

                if(empty($value) && $value != 0){

                    $value = null;
                }
                $query->bindValue(":$key",$value);
            }
        }

        $query->execute();
        $this->resetValues();

        return $query->rowCount();
    }

    //Reestablecer los valores de los atributos wheres y sql
    private function resetValues(){
        
        $this->wheres = "";
        $this->sql = null;
    }

    //Auditoria
    private function insertarAuditoria($accion, $sentencia, $usuario_Afectado) {
        $nombre_Insercion = $this->byUser($usuario_Afectado, 1);
        $insertar_Accion = "{$accion} {$this->campo} {$nombre_Insercion}";
    
        // ** Enrique
        if($this->user !== null){
            $this->sql = 'INSERT INTO auditoria (usuario_id, accion, descripcion) VALUES ("'.$this->user.'", "'.$sentencia.'", "'.$insertar_Accion.'")';
            $query = $this->connection->prepare($this->sql);
            $query->execute();
        }
    }
}


?>