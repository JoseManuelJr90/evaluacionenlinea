<?php 

include_once '../../php/general.php'; 
    // SESSION

    //Si un alumno se acaba de registrar, no puede retroceder a la seccion de registro
    session_start();
        if(isset($_SESSION["id_alumno"]) || !empty($_SESSION["id_alumno"])){
            header("Location:" . SITE_PATH ."html/alumno/inicio.php");
            return;
    }
         
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
          
    ?>
    
    <link rel="stylesheet" href="../../css/login.css">
    <script src="../../js/autenticacion/registro.js"></script>
    <title>Proyecto evaluacion en linea </title>

</head>
<body>
    <!-- HEADER -->
    <header>
        <?php 
            include_once "../../includes/header.php";
        ?>
    </header>
    
    <!-- CONTENIDO -->
    <div class="container-fluid form_container_registro ">
        <form class="form form_registro" id="registro" method="post" action="../../php/autenticacion/validar_registrar.php">
            <input type="hidden" name="registro_alumno" value="1">
            <h5 class="text-center pt-1">Registro</h5>
            <hr>
            <div class="container-fluid mb-3" id="msj_alerta" >
            </div> 
            <h6 class="text-center mb-3">Ingresa cuidadosamente los siguientes datos para tu registro.</h6>      
            <div class="row mb-2 ms-3">
                <div class="col-11 col-sm-3 ">
                <label for="input_nombre" class="col-sm-2 col-form-label">Nombre:</label>
                    <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="nombre_alumno" required placeholder="Nombre">
                </div>
                <div class="col-11 col-sm-4 ">
                    <label for="input_1erapellido" class="col-6 col-sm-12 col-form-label">Primer Apellido:</label>
                    <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="paterno_alumno" required placeholder="Primer Apellido">
                </div>
                <div class="col-11 col-sm-4 ">
                    <label for="input_2doapellido" class="col-6 col-sm-12 col-form-label">Segundo Apellido:</label>
                    <input type="text" class="form-control input_text" pattern="^[a-zA-Z\s]*$" name="materno_alumno" required placeholder="Segundo Apellido">
                </div>
            </div>
            <div class="row mb-2 form_input ms-3">
                <div class="col-11 col-md-11 ">
                    <label for="input_email" class="col-sm-2 col-form-label">Email:</label>
                    <input type="email" class="form-control input_text" name="email_alumno" required placeholder="Ejemplo@gmail.com">
                </div>
            </div>
            <div class="row mb-2 form_input ms-3">
                <div class="col-11 col-md-11 ">
                    <label for="input_nombre" class="col-6 col-md-4 col-form-label">Numero de cuenta:</label>
                    <input type="text" pattern="^[0-9]*$" minlength="10"maxlength="10" class="form-control input_text" name="numero_cuenta" required placeholder="10 digitos">
                </div>
            </div>
            <div class="row mb-2 ms-3">
                <div class="col-11 col-md-11">
                <label for="input_passwpord" class="col-sm-2 col-form-label">Password:</label>
                <input type="password" class="form-control input_text" name="password_alumno" required placeholder="******">
                </div>
            </div>
            <div class="row mb-2 ms-3">
                <div class="col-11 col-lg-11 ">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="check_datos_correctos" required>
                    <label class="form-check-label" for="check_datos_correctos">
                        Los datos son correctos?
                    </label>
                </div>
                </div>
            </div>
            <div class="row mb-5 ms-3">
                <div class="col-6 col-sm-8 ">
                    <button type="submit" class="btn btn-primary boton">Enviar</button>
                </div>
        </form>
                <div class="col-5 col-sm-4  " >
                    <form action="login.php" >
                        <button type="submit" class="btn boton_registrarse" >Ya tengo cuenta</button>
                    </form>
                </div>
               
            <div>
    </div>
    
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>