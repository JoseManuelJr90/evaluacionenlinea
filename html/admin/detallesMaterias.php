<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion_admin.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    <?php
        // Includes
        include_once "../../includes/headGeneral.php";
        include_once "../../php/clases/DbProyectoEvaluacion.php";
        include_once "../../php/clases/admin/Materias.php";

        // Instancias
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();
        $objMaterias = new Materias($db);

        //GET
        $materia_detalles = $_GET["num"];
        
        // Variables
        /**
         * Variables utilizadas en el sidebar(navbarAdmin.php) para mantener activa la seccion
         * al ingresar o actualizar
         */
        $nav_materias="show";
        $active_materias="activa";

        $materias = $objMaterias -> obtenerProfesoresDeMateria($materia_detalles);
            
    ?>

    <!-- CSS -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/admin/materias.css">
    

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
        <?php include_once "../../includes/navbarAdmin.php" ; ?>

        <!-- CONTENIDO -->
        
        <div class="container-fluid container_materias ">
            <!-- DIVS DE ALERTAS Y MODALES -->
            <div class="container-fluid" id="msj_alerta"></div>
            <div class="container-fluid" id="msj_modal"></div>
            <div class="container-fluid" id="crear_modal"></div>
            <!-- CONTENIDO -->
            <h1 class="mt-3 text-center">Detalles de la Materia</h1>
            <hr>
            <!-- BOTON REGRESAR -->
            <div class="mb-3 text-end btn_regresar">
                <a class="btn fs-5 text-secondary" href="../../html/admin/materias.php"><i class="bi bi-arrow-left-square me-2"></i>Regresar</a>
            </div>
            <!-- TABLA -->
            <div class="row align-items-center ">
                <div class=" col-md-12 pt-3">
                    <!-- Si no hay profesores asignados a materias -->
                    <?php if(empty($materias)){ ?>
                            <div class="text-center fs-3">
                                No hay profesores asignados. 
                            <a class="fs-5" href="../../html/admin/profesores.php">Ir a seccion de profesores.</a>
                            </div>
                    <!-- Si hay profesores, se muestran los datos  -->
                    <?php }else{ ?>
                    <table class="table table-md mt-4 text-center" id="tabla_materias">
                        <thead class="table_head">
                            <tr>
                                <th>Profesor</th>
                                <th>Materia</th>
                                <th>Numero de alumnos</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody class="body_tabla">
                            <?php foreach($materias as $materia){ ?>
                                <tr>
                                    <td><?= $materia["nombre_maestro"] ." ". $materia["paterno_maestro"]?></td>
                                    <td><?= $materia["nombre_materia"] ?></td>
                                    <td><?= $materia["alumnos"] ?> </td>
                                    <td><a href="../../html/admin/editarProfesor.php?num=<?= $materia["numero_cuenta"] ?>" class="btn btn-outline-primary" title="Detalles del profesor" ><i class="bi bi-search"></i></a> </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php } ?> 
                </div>
            </div>
        </div>       
    </div>
    
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/admin/materias.js"></script>                              
   
        
    
</body>
</html>