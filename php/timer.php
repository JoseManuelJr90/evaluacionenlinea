<?php 

session_start();

// $tiempo1 = date("Y-m-d H:i:s");
// $tiempo2 = $_SESSION["tiempo_fin"];

// $tiempo_1 = strtotime($tiempo1);
// $tiempo_2 = strtotime($tiempo2);


// $resta=$tiempo_2 - $tiempo_1;

$_SESSION["tiempo_inicio"] = $_SESSION["tiempo_inicio"] -1 ;

$tiempo_fin =gmdate("i:s",$_SESSION["tiempo_inicio"]); 

     if($tiempo_fin=='00:00') { 
       echo "Fin"; 
        unset($_SESSION['tiempo_inicio']);
        unset($_SESSION['tiempo_fin']);
     }else {
      
      echo gmdate("H:i:s",$_SESSION["tiempo_inicio"]);
     }



?>