<?php include_once '../../php/general.php';
      include_once '../../includes/verificar_sesion_profesor.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <?php 
    // Includes
    include_once "../../includes/verificar_solicitudes.php";
    include_once "../../php/clases/profesor/ParcialesProfesor.php";
    include_once "../../includes/headGeneral.php";
    

    //Instancias
   
    $objParciales = new ParcialesProfesor($db);
    
    //Consultas
    $parciales = $objParciales->obtenerParciales($_SESSION["id_profesor"]);
   

    //variables
    // Variables para mantener activa la seleccion en el sidebar
    $nav_materias="show";
    $active_examenes = "activa";
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/profesor/examenes.css">
    <script src="../../js/sweetalert2.all.min.js"></script>
    
    <title>Sistema de Evaluación en Linea</title>
</head>

    
<body>
    <!-- HEADER -->
    <header>
        <?php include_once "../../includes/header.php"; ?>
    </header>
    <!-- CUERPO -->
    <div class="d-md-flex">
        <!-- NAVBAR -->
        <?php include_once "../../includes/navbarProfesor.php" ;?>
        <!-- CONTENIDO -->
        <div class="col-12 col-md-10 ">  
            <div class="container-fluid">
                <!-- DIVS DE ALERTAS Y MODALES -->
                <div class="container-fluid" id="msj_alerta"></div>
                <div class="container-fluid" id="msj_modal"></div>
                <div class="container-fluid" id="crear_modal"></div> 
                <h1 class="mt-3 text-center">Parciales actuales</h1>
                <hr>
                <main class="pruebas col-11 col-sm-8 mx-auto">
                    <div class="accordion accordion-flush" id="materias_acordeon">
                        <div class="accordion-item">
                            <?php 
                            // Arreglo que contendra las materias que imparte el profesor para evitar duplicados
                            $materiasAgrupadas = [];
                            if($parciales == null){
                            ?>
                                <h5 class="text-center text-secondary py-2"> No tienes parciales creados.  Selecciona la opción para crear uno.</h5>       
                            <?php
                            }else{
                                // Ciclo para guardar las materias en el arreglo que evitara duplicados
                                foreach($parciales as $parcial){
                                    $materiasAgrupadas[$parcial["nombre_materia"]] = $parcial["nombre_materia"];
                                }
                                // Variable count sirve para hacer diferentes ids en las etiquetas html
                                $count=1;
                                // Ciclo para hacer los acordion con la cantidad de materias del profesor
                                for($i=0; $i < sizeof($materiasAgrupadas); $i++){?>
                                    <h3 class="accordion-header" id="flush-heading<?php echo $count ?>">
                                        <button class="accordion-button collapsed boton_acordeon" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse<?php echo $count ?>" aria-expanded="false" aria-controls="flush-collapse<?php echo $count ?>"  >
                                            <?php echo key($materiasAgrupadas); ?> 
                                        </button>
                                    </h3>
                                    <div id="flush-collapse<?php echo $count ?>" class="accordion-collapse collapse" aria-labelledby="flush-heading<?php echo $count ?>" data-bs-parent="#materias_acordeon">
                                    <?php 
                                        // Ciclo para colocar los parciales en cada una de las materias en la que nos encontramos
                                        foreach($parciales as $datosMaterias){
                                            if(key($materiasAgrupadas) == $datosMaterias["nombre_materia"]){  ?>               
                                                <div class="accordion-body fs-5 d-flex justify-content-between">
                                                    <div>
                                                        Parcial <?php echo $datosMaterias["numero_parcial"]; ?>. <?php echo $datosMaterias["nombre_parcial"] ?>
                                                        <span class="text-muted" style="font-size:15px">(<?= $datosMaterias["estado"]?>)</span>
                                                    </div>
                                                    <div>
                                                        <?php
                                                        // Si el parcial no esta publicado, se coloca boton para publicar 
                                                        if($datosMaterias["estado"] == "Sin publicar"){ ?>
                                                            <button  class="btn btn-outline-primary"  title="Publicar Parcial" onclick="mostrarModal('publicar','<?= $datosMaterias['nombre_parcial']?>','<?= $datosMaterias['id_parcial']?>', '<?= $datosMaterias['id_maestro']?>')">
                                                                <i class="bi bi-file-earmark-arrow-up-fill"></i>
                                                            </button>
                                                        <?php
                                                        // Si esta publicado se coloca boton para ocultar
                                                        }else{?>
                                                            <button  class="btn btn-outline-secondary"  title="Ocultar parcial" onclick="mostrarModal('ocultar','<?= $datosMaterias['nombre_parcial']?>','<?= $datosMaterias['id_parcial']?>', '<?= $datosMaterias['id_maestro']?>')">
                                                                <i class="bi bi-file-earmark-lock2-fill"></i>
                                                            </button>
                                                        <?php
                                                        } ?>
                                                        <!-- Boton editar -->
                                                        <a class="btn btn-outline-success " title="Editar" href="../../html/profesor/formatoExamen.php?parcial=<?= $datosMaterias["id_parcial"] ?>">
                                                            <i class="bi bi-pencil-fill"></i>
                                                        </a>
                                                        <!-- Boton eliminar -->
                                                        <button  class="btn btn-outline-danger"  title="Eliminar" onclick="mostrarModal('borrar','<?= $datosMaterias['nombre_parcial']?>','<?= $datosMaterias['id_parcial']?>', '<?= $datosMaterias['id_maestro']?>')">
                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>
                                                    </div>  
                                                </div>                                        
                                            <?php    
                                            }     
                                        }  ?>
                                    </div>     
                                    <?php
                                    next($materiasAgrupadas);
                                    $count++;
                                }
                            }                 
                            ?>
                        </div>
                    </div>
                </main>
                <!-- Boton para cear parciales -->
                <div class="btn_inscribir">
                    <a  class="btn" onclick="crearParcial('<?= $_SESSION['id_profesor']?>')"><i class="bi bi-plus"></i>
                    Crear nuevo parcial</a>           
                </div>
            </div> 
        </div>   
    </div>
    
<!-- JS -->
<script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="../../js/profesor/examenes.js"></script>
</body>
</html>