<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion_admin.php'; 

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

         // Variables
        /**
         * Variables utilizadas en el sidebar(navbarAdmin.php) para mantener activa la seccion
         * al ingresar o actualizar
         */   
        $nav_inicio="show";
        $active_inicio="activa";
        //$inicio_md se utiliza en incioGeneral.php
        $inicio_md = "col-md-10"
            
    ?>
    <!-- CSS -->
    <script src="../../js/inicio.js"></script> 
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/inicio.css">

    <title>Sistema de Evaluacion en Linea</title>
</head>
<body>

    <!-- HEADER -->
    <header>
        <?php include_once "../../includes/header.php"; ?>
    </header>
    <!-- CUERPO -->
    <div class="d-md-flex">
        <!-- NAVBAR -->
        <?php include_once "../../includes/navbarAdmin.php" ;
        // INCLUDE DE INICIO
              include_once "../../includes/inicioGeneral.php"; 
        ?>
    </div>
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>