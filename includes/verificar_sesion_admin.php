<?php 
// Si no se ha establecido una sesion mediante login, no permite el acceso
session_start();
if(!isset($_SESSION["id_admin"]) || empty($_SESSION["id_admin"])){
    header("Location:" . SITE_PATH ."html/autenticacion/admin/login.php");
}

?>