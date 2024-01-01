<?php

class Database{
    
    private $connection;
    private $host = '127.0.0.1';
    private $user = 'root';
    private $pass = '';
    private $db = 'shenque_db';
    private $charset = 'utf8mb4';

    public function connect(){
        try {
                 
            $connection = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];

            $this->connection = new PDO($connection, $this->user, $this->pass, $options);

            return $this->connection;

        } catch(PDOException $e) {
            
            echo 'Error en la conexión: ' . $e->getMessage();
        }
    }

}



?>