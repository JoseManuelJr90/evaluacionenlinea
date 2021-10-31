<?php include ('php/general.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
         include_once ("php/clases/DbProyectoEvaluacion.php");


         $dbEvaluacion = new DBProyectoEvaluacion();
         $db = $dbEvaluacion->connect();
         $index = true;

        include_once ("includes/headGeneral.php");
        include_once ("includes/header.php");  
    ?>
    
    <title>Proyecto Evaluacion en Linea </title>
   
    <link rel="stylesheet" href="css/index.css">
    <script src="js/index.js"></script>
</head>
<body style="background-color: <?= $imagenHeader[0]["color_fondo"] ?>">


    <header class="content_banner" >
        
        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-md-12">
                    <div class="banner-con text-center">
                        <p class="banner_titulo">Bienvenido al sistema de evaluación en linea </p>
                        <p class="banner_desc">Aqui podras realizar tus examenes desde casa</p>
                        <a href="html/autenticacion/login.php"  class="banner_btn">Acceso</a>
                    </div>
                </div>
            </div>
        </div>
     
    </header>

   
 
    <script src="js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" ></script>

</html>