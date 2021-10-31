<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php 
        // INCLUDES
        include_once "../../includes/headGeneral.php";
        include_once "../../php/clases/DbProyectoEvaluacion.php";

        // INSTANCIAS
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();            
    ?>

    <!-- CSS -->
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/inicio.css">

    <title>Sistema de Evaluacion en Linea</title>
</head>
<body>

    <!-- HEADER -->
    <header>
        <?php include_once "../../includes/header.php"; ?>
    </header>

    <!-- NAVBAR -->
    <?php include_once "../../includes/navbarAlumno.php" ;
    
    // INICIO
          include_once "../../includes/inicioGeneral.php";
    ?>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/inicio.js"></script> 
</html>