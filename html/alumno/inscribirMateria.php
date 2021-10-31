<?php include_once '../../php/general.php';
      include_once '../../includes/verificar_sesion.php'; 
  
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
        // VARIABLES
        $alumno_id = $_SESSION["id_alumno"];
        $alumno_cuenta = $_SESSION["numero_cuenta"];
        $alumno_nombre = $_SESSION["nombre_alumno"];

    ?>
    <!-- CSS -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/pruebas.css">

    
    <title>Sistema de Evaluación en Linea </title>
</head>
<body>
    <!-- HEADER -->
    <header>
        <?php include_once "../../includes/header.php"; ?>
    </header>

    <!-- NAVBAR -->
        <?php include_once "../../includes/navbarAlumno.php" ;?>
   
    <!-- DIVS DE ALERTAS -->
    <div class="container-fluid" id="msj_alerta"></div>

    <!-- CONTENIDO -->
    <h1 class="mt-3 text-center">Inscribir Materia</h1>
    <hr>
    
    <section class="buscar_materias">
        <div class="col-10 col-lg-7 mx-auto mt-3 " >
            <!-- VALORES QUE SE USAN EN inscribirMateria.js -->
            <input type="hidden" id="id_alumno" value="<?php echo $alumno_id ?>">
            <input type="hidden" id="numero_cuenta" value="<?php echo $alumno_cuenta?>">
            <!--  -->
            <label for="barra_buscar" class="form-label text-center label_buscar d-block">Buscar materia</label>
            <input type="text" class="form-control ps-1 mx-auto d-block w-75" id="barra_buscar" >
        </div>
        <div class="mostrar_busqueda col-12 col-lg-8 mx-auto mt-3 justify-content-between " id="busqueda_materias" >
            <table class="table table-md mt-4 text-center" id="tabla_materias" >
                <thead class="table_head">
                    <tr>
                        <th class="col-6">Profesor</th>
                        <th class="col-4">Materia</th>
                        <th class="col-1"></th>

                    </tr>
                </thead>
                <tbody id="output" class="bg-white">
                    
                </tbody>
            
            </table>

        </div>
    </section>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/inscribirMateria.js"></script>
</body>
</html>