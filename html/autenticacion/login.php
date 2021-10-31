<?php include_once ('../../php/general.php'); 

// Session

// Si alguna session ya esta iniciada, no se puede regresar al login
session_start();
if(isset($_SESSION["id_admin"]) || !empty($_SESSION["id_admin"])){
    header("Location:" . SITE_PATH ."html/admin/inicio.php");
    return;
}

if(isset($_SESSION["id_alumno"]) || !empty($_SESSION["id_alumno"])){
    header("Location:" . SITE_PATH ."html/alumno/inicio.php");
    return;
}

if(isset($_SESSION["id_profesor"]) || !empty($_SESSION["id_profesor"])){
    header("Location:" . SITE_PATH ."html/profesor/inicio.php");
    return;
}

?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        // Includes 
        include_once ("../../includes/headGeneral.php");
        include_once ("../../php/clases/DbProyectoEvaluacion.php");

        // Instancias
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/login.css">
    
    <title>Proyecto evaluacion en linea</title>

</head>
<body>
    <!-- HEADER -->
    <header>
        <?php 
            include_once ("../../includes/header.php");
        ?>
    </header>
    <!-- CONTENIDO -->
    <div class="container form_container_login pb-3">
        <h5 class="text-center pt-2">Iniciar sesión</h5>
        <hr>  
        <div class="container-fluid mb-3" id="msj_alerta" ></div> 
        <h6 class="text-center mb-4">Introduce tu informacion</h6>
        <form class="form form_registro" id="login" action="../../php/autenticacion/validar_login.php" method="post">         
            <div class="d-flex justify-content-center mb-3">
                <div class="form-check form-check-inline me-5">
                    <input type="radio" class="btn-check " name="usuario" id="check_profesor" value="profesor" required autocomplete="off">
                    <label class="btn  btn_usuario" for="check_profesor">Profesor</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" class="btn-check " name="usuario" id="check_alumno" value="alumno" required autocomplete="off">
                    <label class="btn  btn_usuario" for="check_alumno">Alumno</label>
                </div>
            </div>
            <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-9 col-lg-8 ">
                        <label for="input_nombre" class="col-6 col-md-6 col-form-label">Numero de cuenta:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" pattern="^[0-9]*$" minlength="10" maxlength="10" class="form-control input_text" name="numero_cuenta" required placeholder="10 digitos">
                        </div>
                    </div>
            </div>
            <!-- <div class="row mb-3 form_input d-flex justify-content-center">
                
                    <div class="col-9 col-lg-8 ">
                        <label for="input_email" class="col-sm-2 col-form-label">Email:</label>
                        <div class="input-group">
                            <div class="input-group-text"><i class="bi bi-envelope"></i></div>
                            <input type="email" class="form-control input_text" name="input_email" required placeholder="Ejemplo@gmail.com">
                        </div>
                    </div>
            </div> -->
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-9 col-lg-8">
                    <label for="input_passwpord" class="col-sm-2 col-form-label">Password:</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                        <input type="password" class="form-control input_text" id="password" name="password" required placeholder="*****">
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-3 justify-content-center">
                <div class="col-5 col-lg-5 ">
                    <button type="submit" class="btn btn-primary boton">Iniciar sesion</button>
                </div>
        </form>
                <div class="col-3 col-lg-2 ">
                    <form action="registro.php" method="post">
                        <button type="submit" class="btn boton_registrarse">Registrarse</button>
                    </form>
                </div>
            <div>
    </div>
    
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" ></script>
    <script src="../../js/autenticacion/login.js"></script>
</body>
</html>