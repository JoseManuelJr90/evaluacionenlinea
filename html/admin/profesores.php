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
        include_once "../../php/clases/admin/Profesores.php";

        // INSTANCIAS
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();
      
         // Variables
        /**
         * Variables utilizadas en el sidebar(navbarAdmin.php) para mantener activa la seccion
         * al ingresar o actualizar
         */   
        $nav_profesores="show";
        $active_profesores="activa";
      
        if(isset($_GET["editar"])) $editar=true;


        $objProfesores = new Profesores($db);
        $profesores = $objProfesores-> obtenerProfesores();
    ?>
    <!-- CSS -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../css/responsive.bootstrap5.min.css">
    <link rel="stylesheet" href="../../css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/admin/profesores.css">
   
    
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
        <div class="container-fluid container_profesores ">
            <!-- DIVS DE ALERTAS Y MODALES -->
            <div class="container-fluid" id="msj_alerta"></div>
            <div class="container-fluid" id="msj_modal"></div>
            <!-- CONTENIDO -->
            <h1 class="mt-3 text-center">Profesores registrados</h1>
            <hr>
            <!-- BOTON AGREGAR -->
            <div class="d-flex justify-content-start mb-2"  >
                <a class="btn btn-primary" title="Agregar profesor" href="../../html/admin/registrarProfesor.php"><i class="bi bi-plus-lg"></i> Agregar profesor </a>
            </div> 
            <!-- TABLA -->
            <div class="row">
                <div class="col-md-12 pt-3">
                    <table class="table  mt-4  display nowrap" cellspacing="0" width="100%" id="tabla_profesores">
                        <thead class="table_head">
                            <tr>
                                <th>Profesor</th>
                                <th>No. cuenta</th>
                                <th>Materias</th>
                                <th>Email</th>
                                <th>Fecha registro</th>
                                <th>Accion</th>
                            </tr>
                        </thead>
                        <tbody class="body_tabla">
                            <?php
                                if($profesores == 0){ 
                            ?>
                                    <tr>
                                        <td colspan="4" class="fs-5 text-secondary"> No hay profesores</td>
                                    </tr>
                            <?php
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>  
    </div>
    
    <!-- JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    
    <script src ="../../js/responsive.bootstrap5.min.js"></script>
    <script src ="../../js/dataTables.responsive.min.js"></script>
    <script src="../../js/admin/profesores.js"></script>                              
   
</body>
</html>