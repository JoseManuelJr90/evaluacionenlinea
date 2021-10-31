<?php 


include_once "../general.php";
include_once "../clases/DbProyectoEvaluacion.php";
include_once "../clases/Autenticacion.php";


//Instancias

$dbEvaluacion = new DbProyectoEvaluacion();
$db = $dbEvaluacion->connect();
$objAutenticacion = new Autenticacion($db);

//POST
$password = trim($_POST["password"]);
$numero_cuenta = trim($_POST["numero_cuenta"]);
$usuario = limpiarDato($_POST["usuario"]);

/**
 * Validamos si el alumno esta registrado con el numero de cuenta y password obtenidos
 */

if($usuario=="alumno"){
    $alumno = $objAutenticacion->validarAutenticacionAlumno($numero_cuenta, $password);
    if($alumno === 'error'){
        echo 'Error al validar';
        header("Location: ../../html/autenticacion/login.php?mensaje=error");
        exit();
    }
    //Si la consulta regresa 1, se encontro un numero de cuenta registrado pero no coincide con la contraseña
    if($alumno == 1){
        header('Location: ../../html/autenticacion/login.php?mensaje=1');
        exit();

    }else if($alumno == 0){ //Si la consulta regresa 0, no se encontro el numero de cuenta registrado
        header('Location: ../../html/autenticacion/login.php?mensaje=0');
        exit();

    }else{ //Si no regresa 1 o 0 ya hay un usuario registrado y se accedio correctamente.

        //Creacion de las variables de session para el acceso
        session_start();
        $nombre_completo = strtoupper($alumno["nombre_alumno"] ." ". $alumno["paterno_alumno"]);
        $_SESSION["nombre_alumno"] = $nombre_completo;
        $_SESSION["id_alumno"] = $alumno["id_alumno"];
        $_SESSION["numero_cuenta"] = $numero_cuenta;
        header("Location: ../../html/alumno/inicio.php");
        exit();

    }
}


/**
 * Validamos si el profesor esta registrado con el numero de cuenta y password obtenidos
 */

if($usuario=="profesor"){

    $profesor = $objAutenticacion->validarAutenticacionProfesor($numero_cuenta, $password);
    if($profesor === 'error'){
        echo 'Error al validar';
        header("Location: ../../html/autenticacion/login.php?mensaje=error");
        exit();
    }

    //Si la consulta regresa 1, se encontro un numero de cuenta registrado pero no coincide con la contraseña
    if($profesor == 1){
        header('Location: ../../html/autenticacion/login.php?mensaje=1');
        exit();

    }else if($profesor == 0){ //Si la consulta regresa 0, no se encontro el numero de cuenta registrado
        header('Location: ../../html/autenticacion/login.php?mensaje=0');
        exit();

    }else{ //Si no regresa 1  ya hay un usuario registrado y se accedio correctamente.

        //Creacion de las variables de session para el acceso

        //ACCESO A ADMIN
        if($profesor["id_maestro"] == "adminEvaluacion"){
            session_start();
            $_SESSION["nombre_admin"] = "Administrador";
            $_SESSION["id_admin"] = $profesor["id_maestro"];
            header("Location: ../../html/admin/inicio.php");
            exit();
            
        //ACCESO A PROFESOR
        }else{
            session_start();
            $nombre_completo = strtoupper($profesor["nombre_maestro"] ." ". $profesor["paterno_maestro"]);
            $_SESSION["nombre_profesor"] = $nombre_completo;
            $_SESSION["id_profesor"] = $profesor["id_maestro"];
            header("Location: ../../html/profesor/inicio.php");
            exit();
        }

    }
}


?>

