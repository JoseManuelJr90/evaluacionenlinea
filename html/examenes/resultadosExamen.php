<?php include_once "../../php/general.php";
    // SESSION
    // Si no se esta accediendo desde examen.php, no permite ingresar a resultadosExamen.php
    session_start();
    if(!isset($_SESSION["id_resultados"])) header("Location: ../../html/alumno/pruebas.php");
    // Variable para indicar que se accedio a los resultados 
    $_SESSION['resultados_examen'] =  uniqid($_SESSION['id_alumno']);
    // De html/examen.php se envia mediante post las respuestas a examen.php, hacemos include aqui para utilizar los datos
    //que recibio mediante post
    include_once "../../php/examen/examen.php"; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        // Includes
        include_once "../../includes/headGeneral.php";
        include_once "../../includes/header.php";
        // Consultas
        $respuestasExamen = $objExamenes->obtenerPreguntas($id_parcial);
        
        
    ?>    
    <script src="../../js/sweetalert2.all.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/examen.css">
    <title>Sistema de Evaluación en Linea</title>
</head>
<body >
    <!-- HEADER -->
    <header>
        <?php  include_once "../../includes/header.php";?>
    </header>
    <!-- CUERPO -->
    <!-- NAVBAR con tiempo -->
    <div class="nav_statica container-fluid">
        <div class="row">
            <div class="col-4 nav_texto nav_scroll fs-5 text-start" >
                <i class="bi bi-person-circle"></i>
                <?= $_SESSION["nombre_alumno"] ?>
            </div>
            <div class="col-4 nav_texto nav_scroll nav_centro text-center fs-3" >
                    
            </div>
            <div class="col-4 nav_texto tiempo_texto text-end">
                <i class="bi bi-clock d-inline"></i>
                <span class="d-inline">
                    Regresar a inicio en: 
                </span>
                <div class="d-inline"id="timer_examen">
                    00:00
                </div>
                    
            </div>
        </div>
    </div>
    <!-- DIV DE ALERTA -->
    <div class="container-fluid" id="msj_alerta">
        <!-- Si se ingreso mediante tiempo agotado, se muestra una alerta indicandolo -->
        <input type="hidden" class="msj_valor" value = <?php echo $tiempo_agotado ?>>
    </div>
    <!-- Resultados -->
    <main class="container container-md examen my-5 pt-3 examen">
        <h3 class="text-center "><span class="me-5">Resultados:</span>  <?php echo ($correctas ."   Aciertos de   ".count($numero_pregunta)) ?> </h3>
            <table class="table mt-4 tabla_preguntas">
                <?php 
                    $count_preguntas = 1;
                    for($i=0; $i < count($pregunta); $i++){
                        // Si la respuesta es correcta, se mostrara el background verde, rojo para incorrecta
                        $respuesta[$i] == $respuesta_correcta[$i] ? $bg = "respuesta_correcta" : $bg = "respuesta_incorrecta";
                ?>      
                        <!-- Pregunta -->
                        <thead class="tabla_encabezado">
                            <tr>
                                <th > <?= $numero_pregunta[$i].". ".$pregunta[$i] ?>  </th>
                            </tr>
                        </thead>
                        <!-- Respuestas -->
                        <tbody>
                            <tr class=" campos_preguntas container-md  <?= $bg ?>" >
                                    <td>
                                        <div class=" px-2 pb-2" > 
                                            <span class="px-1 d-block fw-bold ">Tu respuesta: </span>
                                            <?php isset($respuestasExamen[$i][$respuesta[$i]]) ?  $r = $respuestasExamen[$i][$respuesta[$i]] : $r = "Sin responder"?>
                                            <span class="d-block px-1 "><?= $r ?></span>
                                        </div>
                                        <hr>                          
                                        <div class=" px-2 pb-2" > 
                                            <span class="px-1 d-block fw-bold">Respuesta correcta: </span>
                                            <span class="d-block px-1"><?= $respuestasExamen[$i][$respuesta_correcta[$i]] ?></span>
                                        </div>
                                    </td>                     
                            </tr> 
                        </tbody>
                <?php
                        $count_preguntas ++;
                    }
                ?>
                </table>
                <div class="mb-3 btn_examen">
                    <a href="../../html/alumno/pruebas.php" class="btn btn-primary " id="enviar_examen"> Salir </a>

                </div>
        
    </main>
    <!-- JS  -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/resultadosExamen.js"></script>
</body>
</html>