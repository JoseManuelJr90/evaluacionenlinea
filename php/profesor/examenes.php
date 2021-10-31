<?php 


include "../clases/DbProyectoEvaluacion.php";
include "../clases/profesor/ParcialesProfesor.php";

//instancias
$dbEvaluacion = new DBProyectoEvaluacion();
$db = $dbEvaluacion->connect();
$objParciales = new ParcialesProfesor($db);

/**
 * Elimina un parcial o actualiza su estado (Sin publicar, publicado)
 */

if(isset($_GET['parcial']) && $_GET['id_profesor']){
    
    $db->beginTransaction();

    if($_GET["tipo_parcial"] == "borrar"){

        $parciales = $objParciales->eliminarParcial($_GET['parcial']);
        echo $parciales;
    }
    else{

        $_GET["tipo_parcial"] == "publicar" ? $tipo_parcial = "Publicado" : $tipo_parcial = "Sin publicar";
        $parciales = $objParciales->actualizarEstadoParcial($_GET['parcial'],$tipo_parcial);
        echo $parciales;
        
     }

    
    $db->commit();
}    


?>