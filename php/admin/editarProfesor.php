<?php 
include_once "../general.php";
include "../clases/DbProyectoEvaluacion.php";
include "../../php/clases/admin/Profesores.php";

$dbEvaluacion = new DBProyectoEvaluacion;
$db = $dbEvaluacion->connect();

$objProfesores = new Profesores($db);



/**
 * Eliminar profesor de la base de datos
 */

if(isset($_GET["eliminar"])){
    $id_profesor = $_GET["eliminar"];

    $db->beginTransaction();
    $eliminar_profesor = $objProfesores -> eliminarProfesor($id_profesor);
    if($eliminar_profesor === "error"){
        header("Location: ../../html/admin/profesor.php?error=5");
        exit();
    }
    $db->commit();

}


/**
 * Obtiene los datos de los profesores cuando se obtiene el GET listar
 */
if(isset($_GET["listar"])){
    $profesores = $objProfesores->obtenerProfesores();
    $data = [];
    // Se crea un array of arrays con los datos de los profesores para poder manejar los dataTables
    foreach($profesores as $profesor){
        $sub_array = [];
        $sub_array[] = $profesor["nombre_maestro"]." ". $profesor["paterno_maestro"];
        $sub_array[] =  $profesor["numero_cuenta"] ;
        $sub_array[] = $profesor["materias"] ;
        $sub_array[] = $profesor["email"] ;
        $sub_array[] = $profesor["fecha_creado"] ;
        $sub_array[] = '<a href="../../html/admin/editarProfesor.php?num='.$profesor["numero_cuenta"].'" class="btn btn-outline-success" title="Editar" ><i class="bi bi-pencil-fill"></i></a> <button class="btn btn-outline-danger" title="Eliminar" onClick="mostrarModal(`eliminar`,`'.$profesor["id_maestro"].'`,`'.$profesor["nombre_maestro"]." ". $profesor["paterno_maestro"].'`);"><i class="bi bi-x-lg"></i></button> ';
        $data[] = $sub_array;
    }
    // Se asignan los datos al formato para datatables
    $results = array(
        "sEcho"=>1,
        "iTotalRecords"=>count($data),
        "iTotalDisplayRecords"=>count($data),
        "aaData"=>$data);
    //Enviamos los datos en formato Json
    echo json_encode($results);

}

/**
 * Remover una materia asignada a un profesor
 */
if(isset($_GET["remover"])){

    $id_materia = $_GET["remover"];
    $id_profesor = $_GET["profesor"];

    $db->beginTransaction();

    $remover = $objProfesores->removerMateria($id_materia,$id_profesor);
    if($remover === "error"){
        header("Location: ../../html/admin/profesor.php?error=5");
        exit();
    }

    $db->commit();

}

/**
 * Asignar una materia a un profesor
 */
if(isset($_GET["asignar"])){
    $id_profesor = $_GET["profesor"];

    $materias = $objProfesores-> materiasNoAsignadas($id_profesor);
    echo json_encode(['data'=> $materias]);
     
}

/**
 *  Agregar un nuevo profesor a la base
 */
if(isset($_POST["agregar"])){
    $numero_cuenta = $_POST["numero_cuenta"];
    $id_profesor = $_POST["id_profesor"];
    $id_nombre_materia = explode('|',$_POST["datos_materia"]); // [0] id, [1] nombre

    $db->beginTransaction();

    $agregarMateria = $objProfesores->agregarMateria($id_profesor, $id_nombre_materia[0]);
    if($agregarMateria === "error"){
        header("Location: ../../html/admin/profesor.php?error=5");
        exit();
    }

    $db->commit();
    header("Location: ../../html/admin/editarProfesor.php?num=".$numero_cuenta."&mensaje=5");
}

/**
 * Editar los datos de un profesor
 */

if(isset($_POST["editar"])){
    $id_profesor = $_POST["id_profesor"];
    $nombre_profesor = limpiarDato($_POST["nombre_profesor"]);
    $paterno_profesor = limpiarDato($_POST["paterno_profesor"]);
    $materno_profesor = limpiarDato($_POST["materno_profesor"]);
    $email_profesor = limpiarDato($_POST["email_profesor"]);
    $numero_cuenta = limpiarDato($_POST["numero_cuenta"]);

    $db->beginTransaction();

    $editar = $objProfesores->actualizarProfesor($id_profesor, $nombre_profesor, $paterno_profesor, $materno_profesor, $email_profesor, $numero_cuenta);
    if($agregarMateria === "error"){
        header("Location: ../../html/admin/profesor.php?error=5");
        exit();
    }

    $db->commit();
    header("Location: ../../html/admin/profesores.php?mensaje=5");

}

?>




