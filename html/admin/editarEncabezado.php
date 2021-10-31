<?php include '../../php/general.php'; ?>
<?php include_once '../../includes/verificar_sesion_admin.php'; 

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php 
        include_once "../../includes/headGeneral.php";
        include_once "../../php/clases/DbProyectoEvaluacion.php";

        //Instancias
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();
         
        // Variables
        /**
         * Variables utilizadas en el sidebar(navbarAdmin.php) para mantener activa la seccion
         * al ingresar o actualizar
         */    
        $nav_diseño="show";
        $active_encabezado="activa";
        
        if(isset($_GET["editar"])) $editar=true;

        
    ?>
    <!-- CSS -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/admin/editarEncabezado.css">

    <title>Sistema de Evaluacion en Linea</title>
</head>
<body>

    <!-- Header -->
    <header>

        <?php include_once "../../includes/header.php"; ?>
    </header>
    <!-- CUERPO -->
    <div class="d-md-flex">
        <!-- NAVBAR -->
        
        <?php include_once "../../includes/navbarAdmin.php" ; ?>

         <!-- CONTENIDO -->
        <!-- Si mediante GET se obtiene editar, Se pasa a la seccion de edicion, sino, se muestran solo datos -->
        
        <?php if(!isset($editar)) {?>

            <!-- Seccion de datos -->
            <div class="container-fluid container_encabezado ">
                <div class="container-fluid" id="msj_alerta"></div>
                <h1 class="mt-3 text-center">Edición de encabezado</h1>
                <hr>
                <h3 class="mt-3 text-center">Aquí puedes editar el encabezado de la página, modificar el texto,la imagen y colores.</h3>
                <h4 class="mt-1 text-center">Da click en el botón para editar los elementos.</h4>


                <div class="d-flex justify-content-end mb-2"  >
                    <a class="btn btn-success" title="Editar" href="../../html/admin/editarEncabezado.php?editar=1"> <i class="bi bi-pencil-fill"></i> Editar elementos </a>
                </div> 
            
                <div class="editar_encabezado container-fluid d-flex justify-content-start" style="color:<?= $imagenHeader[0]["color_texto"]?>; background-color: <?= $imagenHeader[0]["color_fondo"] ?>" >
                    <div class="row align-items-center ">
                        <div class="col-sm pt-3">
                            
                                <img src="<?= SITE_PATH. $imagenHeader[0]["ruta"] ?>" alt="Imagen header" class="logo d-block mx-auto">
                                <h5 class="text-center text-light "> </h5>
                                
                            
                        </div>
                    </div>
                    <div class="row align-items-center ms-2 ">
                        <div class="col-sm">
                            
                            <h3 class=" "><?= $imagenHeader[0]["titulo"] ?></h3> 
                            <h5 class=" mb-4"><?= $imagenHeader[0]["descripcion"] ?></h5> 
                        </div>
                    </div>
                </div>
            </div>
            <!-- Seccion de editar -->
        <?php }else { ?>
            <div class="container-fluid container_encabezado">
                <!-- DIVS PARA ALERTAS Y MODALES -->
                <div class="container-fluid" id="msj_modal"></div>
                <div class="container-fluid" id="crear_modal"></div>
                <!-- TITULO -->
                <h1 class="mt-3 text-center">Editar encabezado</h1>
                <hr>
                <!-- BOTON REGRESAR -->
                <div class="d-flex justify-content-end mb-2"  >
                    <a class="btn btn-secondary" title="Regresar" href="../../html/admin/editarEncabezado.php"> <i class="me-2 bi bi-arrow-left-square"></i> Regresar </a>
                </div>
                 <!--CONTENIDO ELEMENTOS DE EDICION  -->
                <div class="editar_encabezado color_fondo container-fluid py-3" style=" background-color: <?= $imagenHeader[0]["color_fondo"] ?>" >
                    <form class="form" action="../../php/admin/editarDiseno.php" id="form_editar_encabezado"method="post" enctype="multipart/form-data" autocomplete="off">
                        <!-- HIDDENS -->
                        <input type="hidden" name="encabezado" value="editarEncabezado">
                        <input type="hidden" name="id_imagen" value="<?= $imagenHeader[0]["id_imagen"]?>">
                        <input type="hidden" name="tipo" value="<?= $imagenHeader[0]["tipo"]?>">
                        <input type="hidden" name="color_fondo" class="input_color_fondo" value="<?= $imagenHeader[0]["color_fondo"] ?>">
                        <input type="hidden" name="color_texto" class="input_color_texto "value="<?= $imagenHeader[0]["color_texto"] ?>">
                       <!-- IMAGEN -->
                        <div class="row mb-3 mt-3 d-flex justify-content-center">
                            <div class="col-12 col-lg-10 ">
                                <img id="archivoEncabezado_img" class="editar_logo_escuela d-block mx-auto mb-2" src="<?= SITE_PATH. $imagenHeader[0]["ruta"] ?>"  
                                onclick="archivoEncabezadoUrl()" >
                                <label for="archivo_encabezado" class="btn label_input"><span class="label_texto">Selecciona una imagen  (max.2 MB)</span><i class="ms-2 bi bi-caret-down-square"></i></label>
                                <span class="tool_tip"  data-bs-placement="right" title="Error: archivo mayor a 2 MB"></span>
                                <input type="file" style="display:none" accept="image/*" class="form-control text-center" name="archivo_encabezado" id="archivo_encabezado"  title="Selecciona una imagen" onchange="imagenSeleccion(this)">
                                <input type="hidden" name="imagen_default"  value="<?= $imagenHeader[0]["ruta"] ?>">
                            </div>
                        </div>
                    
                        <!-- TITULO 1 -->
                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-12 col-lg-10 ">
                                <div class="input-group">
                                    <div class="input-group-text col-1 " style="font-size:12px">Titulo 1</div>
                                    <input type="text" style="color:<?= $imagenHeader[0]["color_texto"]?> ; background-color: <?= $imagenHeader[0]["color_fondo"]?>"  class="form-control fs-3  text-center input_texto input_titulo col-10 fs-5" name="titulo" value="<?= $imagenHeader[0]["titulo"] ?>">
                                </div>
                                
                            </div>
                        </div>
                        <!-- SUBTITULO -->
                        <div class="row mb-3 d-flex justify-content-center">
                            <div class="col-12 col-lg-10 ">
                                <div class="input-group">
                                    <div class="input-group-text col-1 "style="font-size:12px">Titulo 2</div>
                                    <input type="text" style="color:<?= $imagenHeader[0]["color_texto"]?>; background-color: <?= $imagenHeader[0]["color_fondo"]?>" class="form-control fs-5  text-center input_texto input_desc col-10 fs-5 " name="descripcion" value="<?= $imagenHeader[0]["descripcion"] ?>">
                                </div>            
                            </div>
                        </div>
                        <!-- COLORES -->
                        <div class="row mb-3 ">
                            <!-- FONDO -->
                            <div class="col-4 col-md-3 mx-auto">
                                <label for="seleccion_color_fondo" class="btn mb-1 label_color">Color del fondo</label>
                                <div class="seleccion_color_fondo" id="seleccion_color_fondo"></div>
                            </div>
                            <!-- TEXTO -->
                            <div class="col-4 col-md-2  mx-auto">
                                <label for="seleccion_color_texto" class="btn mb-1 label_color">Color del texto</label>
                                <div class="seleccion_color_texto" id="seleccion_color_texto"></div>
                            </div>
                        </div>  
                    </div>
                    <!-- SUBMIT -->
                    <div class="d-flex justify-content-end my-2">
                        <h5>Si no deseas el texto de alguno de los titulos deja los campos en blanco.</h5>
                        <button type="submit" class="ms-3 btn btn-primary" title="Guardar cambios" id="enviar_encabezado"> Guardar </button>
                    </div>
                </form>
            </div>   
        <?php } ?>  
    </div>
    
 
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/iro@5.js"></script>
    <script src="../../js/admin/editarEncabezado.js"></script>
   
        
    
</body>
</html>