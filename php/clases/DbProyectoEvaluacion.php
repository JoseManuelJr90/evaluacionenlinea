<?php

/*
    Conexion a la base de datos

 */

 class DBProyectoEvaluacion{
    private $host = 'localhost';
    private $dbname = ''; 
    private $username = ''; 
    private $password = ''; 
    private $conn;

    public function connect(){
       try{
          $this->conn = new PDO("mysql:host={$this->host}; dbname={$this->dbname};charset=utf8",$this->username, $this->password);
          $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          
          return $this->conn;
       }catch(Exception $e){
          echo 'Error en la conexión: ' . $e->getMessage() ;
          return 'error';

       }
    }





 }


?>
