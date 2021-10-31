<?php

/*
    Conexion a la base de datos

 */

 class DBProyectoEvaluacion{
    private $host = 'localhost';
    private $dbname = 'proyectoevaluacion'; //local: proyectoevaluacion, 00web id17803113_adminevaluacion hostinger: u842468539_evaluacionenli
    private $username = 'adminEvaluacion'; //local adminEvaluacion, 000web: id17803113_adminevaluacion, hostinger: u842468539_adminEvaluacio
    private $password = 'jAdminEvaluacion'; //local: jAdminEvaluacion, 000web: jAdminEvaluacion4150$
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