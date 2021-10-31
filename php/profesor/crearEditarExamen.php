<?php 

include_once "../general.php";
include "../clases/DbProyectoEvaluacion.php";
include "../clases/profesor/Examenes.php";
include "../clases/profesor/ParcialesProfesor.php";
include_once "../../php/clases/profesor/MateriasProfesor.php";

//instancias
$dbEvaluacion = new DBProyectoEvaluacion();
$db = $dbEvaluacion->connect();
$objParcial = new Examenes($db);
$objDatosParcial = new ParcialesProfesor($db);
$objMateriasProfesor = new MateriasProfesor($db);


//Post


/**
 * Edita los datos de un parcial, si no se crean, solo actualiza el nombre, duracion y numero de parcial
 * Si ya se tenian preguntas, las edita
 * 
 */
if(isset($_POST["editar"])){


    $id_parcial = $_POST["id_parcial"];
    $nombre_parcial = $_POST["nombre_parcial"];
    $numero_parcial = $_POST["numero_parcial"];
    $duracion_parcial = $_POST["duracion_parcial"];
    $id_maestro = $_POST["id_maestro"];
    if(isset($_POST["id_pregunta"])){
        $id_pregunta = $_POST["id_pregunta"];
        $pregunta = limpiarDato($_POST["pregunta"]);
        $numero_pregunta = limpiarDato($_POST["numero_pregunta"]);
        $respuesta_a = limpiarDato($_POST["respuesta_a"]);
        $respuesta_b = limpiarDato($_POST["respuesta_b"]);
        $respuesta_c = limpiarDato($_POST["respuesta_c"]);
        $respuesta_d = limpiarDato($_POST["respuesta_d"]);
        $respuesta_e = limpiarDato($_POST["respuesta_e"]);
        $respuesta_correcta = $_POST["respuesta_correcta"];
    }

    $db->beginTransaction();


        $actualizarParcial = $objDatosParcial->actualizarParcial($id_parcial, $id_maestro, $nombre_parcial, $numero_parcial, $duracion_parcial );
        if($actualizarParcial === "error") header("Location: ../../html/profesor/examenes.php?mensaje=error");

    if(isset($_POST["id_pregunta"])){
        for ($i=0; $i < count($id_pregunta); $i++) { 
            $actualizarPreguntas = $objParcial->actualizarPreguntasyRespuestas($id_parcial,$id_pregunta[$i],$pregunta[$i],$numero_pregunta[$i],$respuesta_a[$i],$respuesta_b[$i],$respuesta_c[$i],$respuesta_d[$i],$respuesta_e[$i],$respuesta_correcta[$i]);
            if($actualizarPreguntas === "error") header("Location: ../../html/profesor/examenes.php?mensaje=error");
        }
    }


    $db->commit();

    header("Location: ../../html/profesor/formatoExamen.php?mensaje=1&parcial={$id_parcial}");


}
/**
 * Borra una pregunta del parcial
 */
if(isset($_GET["pregunta"])){
    $db->beginTransaction();
    $borrarPregunta = $objParcial->borrarPregunta($_GET["parcial"], $_GET["pregunta"]);
    $db->commit();

    header("Location: ../../html/profesor/formatoExamen.php?mensaje=2&parcial={$id_parcial}");

}

/**
 * Agrega una pregunta al parcial
 */
if(isset($_POST["agregar"])){
    
    $id_parcial = $_POST["id_parcial"];
    $pregunta = limpiarDato($_POST["pregunta"]);
    $numero_pregunta = limpiarDato($_POST["numero_pregunta"]);
    $respuesta_a = limpiarDato($_POST["respuesta_a"]);
    $respuesta_b = limpiarDato($_POST["respuesta_b"]);
    $respuesta_c = limpiarDato($_POST["respuesta_c"]);
    $respuesta_d = limpiarDato($_POST["respuesta_d"]);
    $respuesta_e = limpiarDato($_POST["respuesta_e"]);
    $respuesta_correcta = $_POST["respuesta_correcta"];


    $db->beginTransaction();
    $agregarPRegunta = $objParcial->agregarPregunta($id_parcial, $pregunta,$numero_pregunta, $respuesta_a, $respuesta_b, $respuesta_c, $respuesta_d, $respuesta_e, $respuesta_correcta);
    $db->commit();
    header("Location: ../../html/profesor/formatoExamen.php?mensaje=3&parcial={$id_parcial}");

}


/**
 * Obtiene las materias que imparte el profesor
 */
if(isset($_GET["obtener"])){
    $materiasProfesor = $objMateriasProfesor->obtenerDatosMateriasProfesor($_GET["id_profesor"]);
   
    echo json_encode(['data'=> $materiasProfesor]);
    exit();

}

/**
 * Crar un nuevo parcial
 */

if(isset($_POST["crear"])){
    
    $datos_materia = $_POST["datos_materia"];
    $id_profesor = $_POST["id_maestro"];
    $nombre_parcial = limpiarDato($_POST["nombre_parcial"]);
    $duracion_parcial = limpiarDato($_POST["duracion_parcial"]);
    $numero_parcial = limpiarDato($_POST["numero_parcial"]);
    $id_nombre_materia = explode('|',$datos_materia); // [0] id, [1] nombre
    $id_parcial = limpiarDato($id_nombre_materia[1] . $numero_parcial . $id_profesor) ;
    $id_parcial = uniqid($id_parcial);
    
    $db->beginTransaction();
    
    $crearParcial = $objDatosParcial->crearParcial($id_parcial, $id_profesor, $id_nombre_materia[0],$numero_parcial,$nombre_parcial,"Sin publicar", $duracion_parcial );

    $db->commit();

    header("Location: ../../html/profesor/examenes.php?mensaje=4");

}




?>