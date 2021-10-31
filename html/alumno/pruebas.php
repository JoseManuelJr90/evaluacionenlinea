<?php include_once '../../php/general.php';
      include_once '../../includes/verificar_sesion.php'; 
// VARIABLES PARA VERIFICAR SI SE DIO CONTINUAR EN LA CONFIRMACION, SI ACCEDIO AL EXAMEN Y SI LLEGO A LA MUESTRA DE RESULTADOS
 if (isset($_SESSION["id_confirmar"]))  unset($_SESSION["id_confirmar"]) ;
 if (isset($_SESSION["id_resultados"]))  unset($_SESSION["id_resultados"]) ;
 if (isset($_SESSION["resultados_examen"]))  unset($_SESSION["resultados_examen"]) ;
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <?php 
    // INCLUDES
    include_once "../../php/clases/DbProyectoEvaluacion.php";
    include_once "../../php/clases/Parciales.php";
    include_once "../../includes/headGeneral.php";

    //Instancias
    $dbEvaluacion = new DbProyectoEvaluacion();
    $db = $dbEvaluacion->connect();
    $objParciales = new Parciales($db);

    //Session
    
    $id_alumno = $_SESSION["id_alumno"];

    //Consultas
    $parciales = $objParciales->obtenerParciales($id_alumno, "inscrito");

    //variables
    
       
    
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/pruebas.css">

    <title>Sistema de Evaluación en Linea</title>
</head>
<body>
    <!-- HEADER -->
    <header>
        <?php include_once "../../includes/header.php"; ?>
    </header>

    <!-- NAVBAR -->
    <?php include_once "../../includes/navbarAlumno.php" ;?>
        
    <!-- DIV ALERTAS -->
    <div class="container-fluid" id="msj_alerta">

    </div>
    <!-- CONTENIDO -->
    <h1 class="mt-3 text-center">Examenes disponibles</h1>
    <hr>
    <main class="pruebas col-11 col-sm-8 mx-auto">
        <div class="accordion accordion-flush" id="materias_acordeon">
            <div class="accordion-item">
                <?php
                    // Variable para obtener las materias y no repetir 
                    $materiasAgrupadas = [];
                    
                    if($parciales == null){
                 ?>
                        <h5 class="text-center text-secondary py-2"> No hay materias inscritas o parciales publicados</h5>       
                <?php
                    }else{
                        // Ciclo para agrupar las materias sin repetir
                        foreach($parciales as $parcial){
                            $materiasAgrupadas[$parcial["nombre_materia"]] = $parcial["nombre_materia"];
                        }
                        // count sirve para hacer diferentes ids en las etiquetas id de html
                        $count=1;
                        for($i=0; $i < sizeof($materiasAgrupadas); $i++){
                    ?>
                            <h3 class="accordion-header" id="flush-heading<?php echo $count ?>">
                                <button class="accordion-button collapsed boton_acordeon" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $count ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $count ?>"  >
                                    <?php echo key($materiasAgrupadas); ?> 
                                </button>
                            </h3>
                            <div id="flush-collapse<?php echo $count ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $count ?>" data-bs-parent="#materias_acordeon">
                            <?php 
                                foreach($parciales as $datosMaterias){
                                    // Si la materia de datosMaterias es igual a materiasAgrupadas(Para evitar repeticiones)
                                    if(key($materiasAgrupadas) == $datosMaterias["nombre_materia"]){ 
                                        // Y si, la calificacion es difente de null, es decir, ya se tiene una calificacion en ese parcial, se muestra
                                        //el nombre del parcial y la leyenda de que ya se realizo
                                        if($datosMaterias["calificacion"]!=""){ ?>
                                            <div class="accordion-body fs-5  d-flex justify-content-between"> 
                                                Parcial <?php echo $datosMaterias["numero_parcial"]; ?>. <?php echo $datosMaterias["nombre_parcial"]; ?> <span class="fs-6 text-secondary"> Realizado </span>
                                            </div>
                                        <?php
                                        // Si no se tiene registro de haberse realizado, pasamos todos los datos del parcial por si se desea realizar   
                                        }else{
                                        ?>
                                        <form action="../../html/alumno/confirmar.php" method="post" >
                                            <input type="hidden" name="id_maestro" value="<?php echo $datosMaterias["id_maestro"] ?>">
                                            <input type="hidden" name="nombre_maestro" value="<?php echo $datosMaterias["nombre_maestro"] ?>">
                                            <input type="hidden" name="paterno_maestro" value="<?php echo $datosMaterias["paterno_maestro"] ?>">
                                            <input type="hidden" name="id_materia" value="<?php echo $datosMaterias["id_materia"] ?>">
                                            <input type="hidden" name="nombre_materia" value="<?php echo $datosMaterias["nombre_materia"] ?>">
                                            <input type="hidden" name="id_parcial" value="<?php echo $datosMaterias["id_parcial"] ?>">
                                            <input type="hidden" name="nombre_parcial" value="<?php echo $datosMaterias["nombre_parcial"] ?>">
                                            <input type="hidden" name="duracion_parcial" value="<?php echo $datosMaterias["duracion_parcial"] ?>">
                                           
                                            <div class="accordion-body fs-5 d-flex justify-content-between">
                                                Parcial <?php echo $datosMaterias["numero_parcial"]; ?>. <?php echo $datosMaterias["nombre_parcial"] ?>
                                                <button class="btn btn_realizar ">
                                                    Realizar
                                                </button>

                                            </div>
                                            
                                        </form>
                                        <?php    
                                        }   
                                    }
                                }   
                                ?>
                            </div>     
                            <?php
                            // Siguiente al key de materiasAgrupadas
                            next($materiasAgrupadas);
                            $count++;
                        }
                    }                 
                    ?>
            </div>
        </div>

    </main>
    <!-- Boton que lleva a inscribirMateria.php -->
    <div class="btn_inscribir">
        <a href="inscribirMateria.php" >Inscribir una materia</a>           
    </div>

    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/pruebas.js"></script>
</body>
</html>