<?php include_once '../../../php/general.php'; 

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
        include_once "../../../includes/headGeneral.php";
        include_once "../../../php/clases/DbProyectoEvaluacion.php";
        // Instancias
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();
        $adminlogin = true;
        
    ?>
    <!-- CSS -->
    <link rel="stylesheet" href="../../../css/login.css">
 
    <title>Proyecto evaluacion en linea</title>

</head>
<body>
    <!-- HEADER -->
    <header>
        <?php 
            include_once "../../../includes/header.php";
        ?>
    </header>
    <!-- Contenido -->
    <div class="container form_login_admin">
        <h5 class="text-center pt-2">Iniciar sesión</h5>
        <hr>  
        <div class="container-fluid mb-3" id="msj_alerta" ></div> 
        <h6 class="text-center mb-4">Introduce tu informacion</h6>
        <!-- Formulario -->
        <form class="form form_registro" id="login" action="../../../php/autenticacion/validar_login.php" method="post">         
            <input type="hidden" name="usuario" value="profesor">
            <div class="row mb-3 d-flex justify-content-center">
                    <div class="col-9 col-lg-8 ">
                        <label for="input_nombre" class="col-6 col-md-6 col-form-label">Usuario:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person-fill"></i></span>
                            <input type="text" pattern="^[0-9]*$" minlength="10" maxlength="10" class="form-control input_text" name="numero_cuenta" required placeholder="10 digitos">
                        </div>
                    </div>
            </div>
            <div class="row mb-3 d-flex justify-content-center">
                <div class="col-9 col-lg-8">
                    <label for="input_passwpord" class="col-sm-2 col-form-label">Password:</label>
                    <div class="input-group">
                        <div class="input-group-text"><i class="bi bi-lock"></i></div>
                        <input type="password" class="form-control input_text" id="password" name="password" required placeholder="*****">
                    </div>
                </div>
            </div>
            <div class="row mt-5 mb-2 justify-content-center">
                <div class="d-flex justify-content-end" >
                    <button type="submit" class="btn btn-primary btn_sesion">Iniciar sesion</button>
                </div>
            <div>
        </form>
    </div>
    
    <!-- JS -->
     <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" ></script>
     <script src="../../../js/autenticacion/login.js"></script>
</body>
</html>