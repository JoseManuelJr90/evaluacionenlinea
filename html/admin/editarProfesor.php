<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion_admin.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    
    
    <?php
        //INCLUDES 
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
       
        $numero_cuenta = $_GET["num"];
        $objProfesores = new Profesores($db);
        $materias = $objProfesores-> obtenerMateriasDeProfesor($numero_cuenta);
        $profesor = $objProfesores-> obtenerDatosProfesor($numero_cuenta);
    ?>
    <script src="../../js/sweetalert2.all.min.js"></script>
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
            <div class="container-fluid" id="crear_modal"></div>
            <!-- CONTENIDO -->
            <h1 class="mt-3 text-center">Editar Profesor</h1>
            <hr>
            <div class="row align-items-center ">
                <div class="col-12 pt-3 mx-auto">
                    <!-- BOTON REGRESAR -->
                    <div class="mb-3 text-end btn_regresar">
                        <a class="btn fs-5 text-secondary" href="../../html/admin/profesores.php"><i class="bi bi-arrow-left-square me-2"></i>Regresar</a>
                    </div>
                    <!--FORMULARIO  -->
                    <form class="form form_registro" id="registro" method="post" action="../../php/admin/editarProfesor.php">
                        <input type="hidden" name="editar" value="1">
                        <input type="hidden" name="id_profesor" value="<?= $profesor[0]["id_maestro"]?>">
                        <h5 class="text-center pt-1">Edición</h5>
                        <hr> 
                          <!--INPUTS  -->
                        <div class="row mb-2 ms-1">
                            <div class="col-12 col-md-4 ">
                                <label for="input_nombre" class="col-sm-2 col-form-label">Nombre:</label>
                                <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="nombre_profesor" required  value="<?= $profesor[0]["nombre_maestro"]?>">
                            </div>
                            <div class="col-12 col-md-4 ">
                                <label for="input_1erapellido" class="col-6 col-sm-12 col-form-label">Primer Apellido:</label>
                                <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="paterno_profesor" required  value="<?= $profesor[0]["paterno_maestro"]?>">
                            </div>
                            <div class="col-12 col-md-4 ">
                                <label for="input_2doapellido" class="col-6 col-sm-12 col-form-label">Segundo Apellido:</label>
                                <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="materno_profesor" required  value="<?= $profesor[0]["materno_maestro"]?>">
                            </div>
                        </div>
                        <div class="row mb-2 form_input ms-1">
                            <div class="col-12 col-md-12 ">
                                <label for="input_email" class="col-sm-2 col-form-label">Email:</label>
                                <input type="email" class="form-control input_text" name="email_profesor" required  value="<?= $profesor[0]["email"]?>">
                            </div>
                        </div>
                        <div class="row mb-2 form_input ms-1">
                            <div class="col-12 col-md-12 ">
                                <label for="input_nombre" class="col-6 col-md-4 col-form-label">Numero de cuenta:</label>
                                <input type="text" pattern="^[0-9]*$" minlength="10"maxlength="10" class="form-control input_text" name="numero_cuenta"  value="<?= $profesor[0]["numero_cuenta"]?>">
                            </div>
                        </div>
                        <!-- TABLA DE MATERIAS -->
                        <div class="row mb-2 ms-3">
                            <label for="input_passwpord" class="col-12 mb-4 col-form-label">Materias asignadas:</label>
                                <?php foreach ($materias as $materia){ ?>
                                    <div class="col-6 col-md-4 mb-2">
                                        <?= $materia["nombre_materia"]; ?>
                                    </div>
                                    <div class="col-6 col-md-8 mb-3">
                                        <a class="btn btn-outline-danger " style="font-size:12px" title="Remover materia" onclick="mostrarModal('eliminar','<?= $materia['id_materia'] ?>', '<?= $materia['nombre_materia']?>','<?= $profesor[0]['id_maestro']?>')"><i class="bi bi-x-lg"></i></a>
                                    </div>
                                    <hr>
                                <?php } ?>
                        </div>
                        <!-- BOTON AGREGAR -->
                        <div class="row mb-4 form_input ms-3">
                            <div class="col-5 col-md-5 mx-auto btn_asignar">                                      
                                <a class=" btn btn_asignar" onclick="asignarMateria('<?= $profesor[0]['id_maestro']?>','<?= $profesor[0]['numero_cuenta']?>')"><i class="bi bi-plus"></i>
                                Asignar nueva materia</a>                         
                            </div>
                        </div>
                        <!-- SUBMIT -->
                        <div class="col-12 d-flex justify-content-end mb-2"  >
                            <button type="submit" class="btn btn-primary" title="Guardar"> Guardar</button>
                        </div>
                    </form>
                </div>  
            </div>    
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/admin/editarProfesor.js"></script>                              

</body>
</html>