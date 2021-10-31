<?php 

/**
 * Destruimos las sessiones creadas y direccionamos al login
 */
session_start();
session_unset();
header ('location: ../../html/autenticacion/login.php');

?>
