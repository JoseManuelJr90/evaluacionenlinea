<?php include_once "../../php/general.php"; 
    session_start();
    
    // Variable obtenida en confirmar.php y en resultadosExamen.php

    // Si no se paso por la opcion de confirmar o si ya accedio a resultados examen, no puede ingresar a examen.php
    if(!isset($_SESSION["id_confirmar"])  || isset($_SESSION["resultados_examen"])){
        
        header("Location: ../../html/alumno/pruebas.php"); 
    }
    //$_SESSION['id_prueba'] =  uniqid($_SESSION['nombre_alumno']);
    // Variable para indicar que se podra acceder a resultadosExamen.php
    $_SESSION["id_resultados"] = 1;
    // Variable que nos indica que se ingreso al examen
    $_SESSION["insertar_una_vez"] = 1;
    // Se da un tiempo de 20 segundos para verificar los resultados
    $_SESSION['tiempo_resultados'] = 20;
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <?php
            // Includes
            include_once "../../includes/headGeneral.php";
            include_once "../../php/clases/DbProyectoEvaluacion.php";
            include_once "../../php/clases/Examenes.php";
            //Instancias
            $dbEvaluacion = new DbProyectoEvaluacion();
            $db = $dbEvaluacion->connect();
            $objExamenes = new Examenes($db);
            //Post    
            
            // Post obtenidos de confirmar.php
            $nombre_alumno = $_SESSION["nombre_alumno"];
            $id_alumno = $_SESSION["id_alumno"];
            $id_maestro = $_POST["id_maestro"];
            $nombre_maestro = $_POST["nombre_maestro"];
            $paterno_maestro = $_POST["paterno_maestro"];
            $id_materia = $_POST["id_materia"];
            $nombre_materia = $_POST["nombre_materia"];
            $id_parcial = $_POST["id_parcial"];
            $nombre_parcial = $_POST["nombre_parcial"];
            // Se genera el id de la prueba que se ingresara a la base
            $id_parcial_alumno = uniqid($_SESSION['nombre_alumno']);
            

            //Consultas
            //Se valida si ya se tiene el registro de la participacion por si se recarga la pagina
            $validarParticipacion = $objExamenes->validarParticipacion($id_alumno, $id_parcial);
            //Se registra la participacion del alumno al entrar al examen, si cierra la pagina quedara su calificacion en 0
            if($validarParticipacion == 0) $participacion = $objExamenes->registrarAlumoParcial($id_parcial_alumno, $id_alumno, $id_parcial, 0);
            $preguntas = $objExamenes->obtenerPreguntas($id_parcial);
            
        
?>
    <script src="../../js/sweetalert2.all.min.js"></script>
     <!--CSS  -->
    <link rel="stylesheet" href="../../css/examen.css">
    <title>Sistema de Evaluación en Linea</title>
</head>


<body >
    <!-- HEADER -->
    <header>
        <?php  include_once "../../includes/header.php";?>
    </header>
    <!-- CONTENIDO -->
    <div class="nav_statica container-fluid">
        <!-- Navbar con el tiempo -->
        <div class="row">
            <div class="col-4 nav_texto nav_scroll fs-5 text-start" >
                <i class="bi bi-person-circle"></i>
                <?= $nombre_alumno?> 
            </div>
            <div class="col-4 nav_texto nav_scroll nav_centro" >
            </div>
            <div class="col-4 nav_texto tiempo_texto text-end">
                <i class="bi bi-clock d-inline"></i>
                <span class="d-inline">
                    Tiempo : 
                </span>
                <div class="d-inline"id="timer_examen">
                    00:00:00
                </div>
            </div>
        </div>
    </div>
    <!-- Contenido -->
    <main class="container container-md examen my-5 pt-3 examen">
        <h3 class="text-center "><span class="me-5"><?= $nombre_materia ?>:</span>   <span><?= $nombre_parcial ?></span>   </h3>
        <p>Selecciona la respuesta que creas correcta.</p>
        <!-- Preguntas -->
        <form action="../../html/examenes/resultadosExamen.php" method="post" id="form_examen">         
            <table class="table mt-4 tabla_preguntas"> 
                <?php 
                    $count_preguntas = 0;
                    foreach ($preguntas as $pregunta){  
                ?>       
                        <!-- PREGUNTAS -->
                        <thead class="tabla_encabezado">
                            <tr>
                                <th > <?= $pregunta["numero_pregunta"].". ".$pregunta["pregunta"] ?>  </th>
                                <!-- Inputs hidden con los datos de la pregunta, parcial y alumno -->
                                <input type="hidden" name="tiempo_agotado" value ="0">
                                <input type="hidden" name="id_parcial_alumno" value ="<?php echo $id_parcial_alumno ?>">
                                <input type="hidden" name="id_alumno" value ="<?php echo $id_alumno ?>">
                                <input type="hidden" name="pregunta[]" value ="<?php echo $pregunta["pregunta"]?>">
                                <input type="hidden" name="id_parcial" value ="<?php echo $pregunta["id_parcial"]?>">
                                <input type="hidden" name="id_pregunta[]" value ="<?php echo $pregunta["id_pregunta"]?>">
                                <input type="hidden" name ="numero_pregunta[]" value= "<?php echo $pregunta["numero_pregunta"]?>">
                                <input type="hidden" name ="respuesta_correcta[]" value= "<?php echo $pregunta["respuesta_correcta"]?>">
                            </tr>
                        </thead>
                        <!-- RESPUESTAS -->
                        <tbody>
                            <tr class=" campos_preguntas container-md" >
                                <td>
                                    <!-- Respuesta default null por si termina el tiempo y no se respondio -->
                                    <div class="checkbox">
                                        <input  class="respuesta_check" type="hidden"  name="respuesta[<?= $count_preguntas ?>]"   value="NULL" id="check_n<?= $count_preguntas ?>">
                                    </div>
                                     <!--A,B,C,D,E  -->
                                    <div class=" campo d-flex  px-2 pb-2" > 
                                        <span class="px-1">a. </span>
                                        <div class="checkbox">
                                            <input  class="respuesta_check" type="radio"  name="respuesta[<?= $count_preguntas ?>]"   value="a" id="check_a<?= $count_preguntas ?>">
                                        </div> 
                                        <label for="check_a<?= $count_preguntas ?>" class="respuesta_check px-1">
                                                <?=$pregunta['a']?>
                                        </label>
                                    </div>
                                    <div class=" campo d-flex px-1 pb-2"> 
                                        <span class="px-1">b. </span>
                                        <div class="form-checkbox">
                                            <input class="respuesta_check" type="radio" name="respuesta[<?= $count_preguntas ?>]"  value="b" id="check_b<?= $count_preguntas ?>">
                                        </div>  
                                        <label for="check_b<?= $count_preguntas ?>" class="respuesta_check px-1">
                                            <?=$pregunta['b']?>
                                        </label>
                                    </div>   
                                    <div class="campo d-flex px-2 pb-2"> 
                                        <span class="px-1">c. </span>
                                        <div class="form-checkbox">
                                            <input class="respuesta_check "  type="radio"  name="respuesta[<?= $count_preguntas ?>]" value="c" id="check_c<?= $count_preguntas ?>">
                                        </div> 
                                        <label for="check_c<?= $count_preguntas ?>" class="respuesta_check px-2" >
                                            <?=$pregunta['c']?>
                                        </label>
                                    </div>       
                                    <div class="campo d-flex px-2 pb-2"> 
                                        <span class="px-1">d.</span>
                                        <div class="form-checkbox">
                                            <input class="respuesta_check" type="radio"  name="respuesta[<?= $count_preguntas ?>]" value="d" id="check_d<?= $count_preguntas ?>">
                                        </div>  
                                        <label for="check_d<?= $count_preguntas ?>" class="respuesta_check px-2" >
                                            <?=$pregunta['d']?>
                                        </label>
                                    </div>                        
                                    <div class="campo d-flex px-2 pb-2"> 
                                        <span class="px-1">e. </span>
                                        <div class="form-checkbox">
                                            <input class="respuesta_check" type="radio" name="respuesta[<?= $count_preguntas ?>]" value="e" id="check_e<?= $count_preguntas ?>">
                                        </div>  
                                        <label for="check_e<?= $count_preguntas ?>" class="respuesta_check px-2" >
                                            <?=$pregunta['e']?>
                                        </label>
                                    </div>    
                                </td>             
                            </tr> 
                        </tbody>
                <?php
                        $count_preguntas ++;
                    }
                ?>
                <!--Submit  -->
                </table>
                <div class="mb-3 btn_examen">
                    <button type="submit" class="btn btn-primary " id="enviar_examen"> Enviar </button>
                </div>
        </form>
    </main>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/examen.js"></script>
</body>
</html>