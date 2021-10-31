<?php 
// Si no se ha establecido una sesion mediante login, no permite el acceso
session_start();
if(!isset($_SESSION["id_alumno"]) || empty($_SESSION["id_alumno"])){
    header("Location:" . SITE_PATH ."html/autenticacion/login.php");
}

?>