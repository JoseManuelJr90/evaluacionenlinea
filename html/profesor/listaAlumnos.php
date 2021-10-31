<?php include_once '../../php/general.php';
    include_once '../../includes/verificar_sesion_profesor.php'; 
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    
   
    <?php 
    // INCLUDES
    include_once "../../includes/verificar_solicitudes.php";
    include_once "../../php/clases/profesor/AlumnosProfesor.php";
    include_once "../../php/clases/Examenes.php";
    include_once "../../php/clases/profesor/MateriasProfesor.php";
    include_once "../../php/clases/profesor/ParcialesProfesor.php";
    include_once "../../includes/headGeneral.php";

    //Instancias   
    $objAlumnos = new AlumnosProfesor($db);
    $objExamenes = new Examenes($db);
    $objMaterias = new MateriasProfesor($db);
    $objParciales = new ParcialesProfesor($db);
    
    //Consultas
    
    $materias = $objMaterias->obtenerDatosMateriasProfesor($_SESSION["id_profesor"]);
    $parciales = $objParciales->obtenerParciales($_SESSION["id_profesor"]);
    $alumnos = $objAlumnos->obtenerAlumnos($_SESSION["id_profesor"]);
    $calificaciones = $objExamenes->obtenerCalificacion($_SESSION["id_profesor"]);
    
    //variables
    // Variable para mantener el tab de la materia activa al recargar la pagina
    if(isset($_GET["materia"])) $materiaActive = $_GET["materia"];
    // Variable para editar o mostrar datos
    if(isset($_GET["accion"])) $editar = $_GET["accion"];
    // Variables para mantener la secccion activa en el sidebar
    $nav_alumnos = "show";
    $active_lista = "activa";
 
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/profesor/lista.css">
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
                <!-- CONTENIDO -->
                <h1 class="mt-3 text-center"> Lista de Alumnos </h1>
                <hr>
                <main class=" col-12 col-sm-10 mx-auto">
                    <?php 
                    if($alumnos == null){   ?>
                        <h5 class="text-center text-secondary py-2"> No hay alumnos</h5>       
                    <?php
                    }else{ ?> 
                        <ul class="nav nav-tabs d-flex justify-content-center" role="tablist">
                            <?php
                            // Si hay alumnos inscritos, nos colocamos en cada una de las materias del profesor
                            foreach($materias as $materia) {
                                // Comparamos si ya se habia seleccionado la pestaña de la materia al recargar la pagina   
                                if(isset($materiaActive)){
                                    if($materiaActive == $materia["nombre_materia"]){
                                        $active="active";
                                        $selected="true"; 
                                    }else{
                                        $active="";
                                        $selected="false"; 
                                    }
                                }else{
                                    $active = "";
                                } ?>
                                <!-- CREACION DE LOS TABS DE CADA MATERIA -->
                                <li class="nav-item " role="presentation">
                                    <button class="nav-link <?= $active ?> text-dark " id="<?= $materia["nombre_materia"]?>-tab" data-bs-toggle="tab" data-bs-target="#<?= $materia["nombre_materia"]?>" type="button" role="tab" aria-controls="<?= $materia["nombre_materia"]?>" aria-selected="<?= $selected ?>"> <?= $materia["nombre_materia"]?> </button>
                                    
                                </li>  
                                <?php        
                            } ?>   
                        </ul>
                        <div class="tab-content" style="font-size:14px" id="myTabContent">           
                            <?php    
                            /**Si no se tiene la variable editar mediante GET, nos muestra los datos fijos */    
                            if(!isset($editar)){
                                /**For que recorre cada una de las materias en las que el profesor esta inscrito */
                                foreach($materias as $materia){ 
                                    /**Compara la variable materiaActive obtenida mediante GET si se recargo la pagina
                                     * en caso de que sean iguales, nos activa el contenido del tab de la materia
                                    */
                                    if(isset($materiaActive)){
                                        if($materiaActive == $materia["nombre_materia"]){
                                            $active="active";
                                        }else{
                                            $active="";
                                        }
                                    } ?>     

                                    <div class="tab-pane fade <?= $active ?> show my-3" id="<?= $materia["nombre_materia"] ?>" role="tabpanel" aria-labelledby="<?= $materia["nombre_materia"]?>-tab">
                                        <div class="nav-item d-flex justify-content-end mb-4"  >
                                            <a class="btn btn-success" title="Editar" href="../../html/profesor/listaAlumnos.php?accion=editar&materia=<?= $materia["nombre_materia"]?>"> <i class="bi bi-pencil-fill"></i> </a>
                                        </div>
                                            <!--Tabla dentro del tab de la materia  -->
                                        <table class="table "  id="table_<?= $materia["nombre_materia"]?>">
                                            <!-- head -->
                                            <thead>
                                                <tr>
                                                    <th class="col-2">Alumno</th>
                                                    <th class="col-1">No. cuenta</th>
                                                    <?php                    
                                                    //Se crean los parciales de cada materia 
                                                    foreach($parciales as $parcial){
                                                        if($parcial["id_materia"] == $materia["id_materia"]){ ?>
                                                            <th class="col-1">Parcial <?= $parcial["numero_parcial"] ?> </th>
                                                        <?php
                                                        }
                                                    } ?>
                                                </tr>
                                            </thead>
                                            <!-- Body -->
                                            <tbody class=" w-100 " style="font-size:15px" >
                                                <?php                               
                                                if(!in_array($materia["nombre_materia"], array_column($alumnos,"nombre_materia"))){ ?>
                                                    <td class="col-12 text-center">No hay alumnos</td>
                                                <?php
                                                }else{        
                                                    foreach($alumnos as $alumno){
                                                        // Si el alumno esta inscrito en la materia que nos encontramos, se colocan sus datos
                                                        if($materia["nombre_materia"] == $alumno["nombre_materia"]){  ?>                                          
                                                            <tr>
                                                                <td>
                                                                    <?= $alumno["nombre_alumno"] ." ". $alumno["paterno_alumno"] ." ".$alumno["materno_alumno"]?> 
                                                                </td>
                                                                <td>
                                                                    <?= $alumno["numero_cuenta"] ?>
                                                                </td>    
                                                                <?php   
                                                                foreach($parciales as $parcial){
                                                                    // $c es un Contador que nos permitira llevar el numero de parciales recorridos
                                                                    $c=0;
                                                                    // Si el parcial es de la materia en la que nos encontramos
                                                                    if($parcial["nombre_materia"] == $materia["nombre_materia"]){
                                                                        // Buscamos que el id del alumno este dentro del arreglo calificaciones, lo que quiere decir que ha realizado evaluaciones
                                                                        // Si no esta, se coloca un campo vacio en ese parcial
                                                                        if(!in_array($alumno["id_alumno"], array_column($calificaciones,"id_alumno"))){ ?>        
                                                                            <td></td>
                                                                        <?php
                                                                        // Si esta dentro de calificaciones
                                                                        }else{
                                                                            // Recorremos el arreglo calificaciones
                                                                            foreach($calificaciones as $calificacion){ 
                                                                                // Primero nos posicionamos en el parcial, cada que se encuentre en otro parcial diferente, se aumenta un contador
                                                                                if($calificacion["id_parcial"]!=$parcial["id_parcial"] ){ $c++;}
                                                                                // Si nos encontramos en el parcial que tiene el id del alumno, se coloca su calificacion
                                                                                else if($calificacion["id_alumno"] == $alumno["id_alumno"]){ ?>
                                                                                    <td><?= $calificacion["calificacion"]; ?></td>                           
                                                                                <?php
                                                                                // Si nos encontramos en el parcial pero no esta el id del alumno, se aumenta el contador
                                                                                }else{$c++;}
                                                                                // Si ya se recorrieron todos los parciales, se coloca casilla en blanco
                                                                                if($c == sizeof($calificaciones)){?>
                                                                                    <td></td>               
                                                                                <?php
                                                                                }
                                                                            }      
                                                                        }
                                                                    }    
                                                                } ?>                                                            
                                                            </tr>
                                                        <?php                                                                                                        
                                                        }    
                                                    }
                                                } ?>                              
                                            </tbody>
                                        </table>
                                    </div>
                            
                                    <?php   
                                
                                }
                            /**Si se obtiene la variable editar mediante GET nos muestra este formato en el cual se puede editar */
                            }else{   
                    
                                /**For que recorre cada una de las materias en las que el profesor esta inscrito */
                                foreach($materias as $materia){ 
                                    /**Compara la variable materiaActive obtenida mediante GET si se recargo la pagina
                                     * en caso de que sean iguales, nos activa el contenido del tab de la materia
                                    */
                                    if(isset($materiaActive)){
                                        if($materiaActive == $materia["nombre_materia"]){
                                            $active="active";
                                        
                                        }else{
                                            $active="";
                                        }
                                    }  ?>                  
                                    <!-- Contenido del tab -->
                                    <div class="tab-pane fade <?= $active ?> show my-3" id="<?= $materia["nombre_materia"] ?>" role="tabpanel" aria-labelledby="<?= $materia["nombre_materia"]?>-tab">
                                        <form action="../../php/profesor/alumnos.php" method="post">
                                            <input type="hidden" name="editar" value="editar">
                                            <input type="hidden" name="materia" value ="<?= $materia["nombre_materia"]?>">
                                            <div class="nav-item d-flex justify-content-end mb-2"  >
                                                <button class="btn btn-primary "> Guardar </button>
                                            </div> 
                                            <table class="table "  id="table_<?= $materia["nombre_materia"]?>">
                                                <thead>
                                                    <tr>
                                                        <th class="col-2">Alumno</th>
                                                        <th class="col-1">No. cuenta</th>
                                                        <?php       
                                                        //Se crea cada uno de los parciales de la materia  
                                                        foreach($parciales as $parcial){
                                                            if($parcial["id_materia"] == $materia["id_materia"]){ ?>
                                                                <th class="col-1">Parcial <?= $parcial["numero_parcial"] ?> </th>
                                                                <?php
                                                            }
                                                        } ?>
                                                        <th class="col-1">Accion</th>
                                                    </tr>
                                                </thead>
                                                <tbody class=" w-100 " style="font-size:15px" >
                                                    <?php
                                                    foreach($alumnos as $alumno){ 
                                                        // Si el alumno se encuentra inscrito en la materia, se colocan sus datos 
                                                        if($materia["nombre_materia"] == $alumno["nombre_materia"]){?>                                          
                                                            <tr>
                                                                <td>
                                                                    <?= $alumno["nombre_alumno"] ." ". $alumno["paterno_alumno"] ." ".$alumno["materno_alumno"]?> 
                                                                </td>
                                                                <td>
                                                                    <?= $alumno["numero_cuenta"] ?>
                                                                </td>
                                                                <?php
                                                                foreach($parciales as $parcial){
                                                                    // $c es un Contador que nos permitira llevar el numero de parciales recorridos
                                                                    $c=0;
                                                                    // Si el parcial es de la materia en la que nos encontramos
                                                                    if($parcial["nombre_materia"] == $materia["nombre_materia"]){
                                                                        // Buscamos que el id del alumno este dentro del arreglo calificaciones, lo que quiere decir que ha realizado evaluaciones
                                                                        // Si no esta, se coloca un input vacio en ese parcial
                                                                        if(!in_array($alumno["id_alumno"], array_column($calificaciones,"id_alumno"))){ ?>        
                                                                            <td><input class="w-50" type="text" pattern="^[0-9]?[0-9]?(\.[0-9][0-9]?)?$" oninvalid="this.setCustomValidity('Numero con dos decimales')" oninput="this.setCustomValidity('')" name="nueva_calificacion[<?= $alumno["id_alumno"] ?>][<?= $parcial["id_parcial"] ?>]" value=""></td>                                     
                                                                        <?php
                                                                        // Si esta dentro de calificaciones
                                                                        }else{
                                                                            // Recorremos el arreglo calificaciones
                                                                            foreach($calificaciones as $calificacion){
                                                                                // Primero nos posicionamos en el parcial, cada que se encuentre en otro parcial diferente, se aumenta un contador
                                                                                if($calificacion["id_parcial"]!=$parcial["id_parcial"] ){ $c++;}
                                                                                // Si nos encontramos en el parcial que tiene el id del alumno, se coloca su calificacion
                                                                                else if($calificacion["id_alumno"] == $alumno["id_alumno"]){ ?>
                                                                                    <td> <input class="w-50" type="text" pattern="^[0-9]?[0-9]?(\.[0-9][0-9]?)?$" oninvalid="this.setCustomValidity('Numero con dos decimales')" oninput="this.setCustomValidity('')" name="calificacion[]" value="<?= $calificacion["calificacion"]?>">
                                                                                    <input type="hidden" name="id_parcial_alumno[]" value="<?= $calificacion["id_parcial_alumno"] ?>">
                                                                                    <input type="hidden" name="id_parcial[]" value="<?= $calificacion["id_parcial"] ?>">
                                                                                    </td>   
                                                                                <?php
                                                                                // Si nos encontramos en el parcial pero no esta el id del alumno, se aumenta el contador
                                                                                }else{$c++;}
                                                                                // Si ya se recorrieron todos los parciales, se coloca casilla en blanc
                                                                                if($c == sizeof($calificaciones)){?>
                                                                                    <td><input class="w-50" type="text" pattern="^[0-9]?[0-9]?(\.[0-9][0-9]?)?$" oninvalid="this.setCustomValidity('Numero con dos decimales')" oninput="this.setCustomValidity('')" name="nueva_calificacion[<?= $alumno["id_alumno"] ?>][<?= $parcial["id_parcial"] ?>]" value=""></td>                  
                                                                                <?php
                                                                                }
                                                                            }
                                                                            
                                                                            
                                                                        }
                                                                    }    

                                                                } ?>
                                                                <!-- BOTON ELIMINAR ALUMNO -->
                                                                <td>
                                                                    <a class="btn btn-outline-danger" onclick="mostrarModal('eliminar','<?= $alumno['id_alumno']?>','<?= $alumno['id_materia'] ?>','<?= $_SESSION['id_profesor']?>','<?= $materia['nombre_materia']?>')" title="Dar de baja"><i class="bi bi-x-lg"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php                                             
                                                        }
                                                    } ?>                              
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                
                                    <?php       
                                }  
                            } //End else ?>          
                        </div>
                     <?php
                    } //End else ?>
 
                </main>
            </div> 
        </div>   
    </div>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/profesor/alumnos.js"></script>
</body>
</html>