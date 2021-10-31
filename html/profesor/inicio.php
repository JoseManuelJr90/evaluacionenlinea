<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion_profesor.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <?php 
        // INCLUDES
        include_once "../../includes/headGeneral.php";
        include_once "../../includes/verificar_solicitudes.php";
        // Variables para mantener la seccion activa en el sidebar
        $nav_inicio="show";
        $active_inicio="activa";
        // Variable para modificar el tamaño en inicio general cuando hay sidebaer
        $inicio_md = "col-md-10"
              
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
    <!-- CUERPO -->
    <div class="d-md-flex">
        <!-- NAVBAR -->
        <?php include_once "../../includes/navbarProfesor.php" ;
            // INICIO
              include_once "../../includes/inicioGeneral.php";
        ?>
    </div>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/inicio.js"></script> 
</html>