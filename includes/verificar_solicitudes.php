<?php 
// Script que se incluye en todos los html de profesor para verificar siempre si se ha recibido solicitud al navegar por las secciones
include_once "../../php/clases/DbProyectoEvaluacion.php";
include_once "../../php/clases/profesor/NumeroSolicitudes.php";
$dbEvaluacion = new DbProyectoEvaluacion();
$db = $dbEvaluacion->connect();
$objNumeroSolicitudes = new NumeroSolicitudes($db);
// Este valor se pasa siempre al navbarProfesor.php
$numeroSolicitudes = $objNumeroSolicitudes->obtenerNumeroSolicitudes($_SESSION["id_profesor"]);



?>