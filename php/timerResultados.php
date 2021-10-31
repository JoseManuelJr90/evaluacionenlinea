<?php 

session_start();

$_SESSION["tiempo_resultados"] = $_SESSION["tiempo_resultados"] -1 ;

$tiempo_fin =gmdate("i:s",$_SESSION["tiempo_resultados"]); 

     if($tiempo_fin==='00:00') { 

       echo "Fin"; 
        unset($_SESSION['tiempo_resultados']);
        
     }else {
      
      echo gmdate("i:s",$_SESSION["tiempo_resultados"]);
     }



?>