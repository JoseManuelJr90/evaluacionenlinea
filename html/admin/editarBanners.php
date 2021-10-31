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
        include_once "../../php/clases/Imagenes.php";

        // Instancias
        $dbEvaluacion = new DBProyectoEvaluacion();
        $db = $dbEvaluacion->connect();

        //Variables
        $nav_diseño="show";
        $active_banner="activa";
        
        if(isset($_GET["editar"])) $editar=true;


        $objBanners = new Imagenes($db);
        $imagenesBanner = $objBanners->obtenerImagenes("banner");
    ?>

    <!-- CSS -->
    <script src="../../js/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../css/navbar.css">
    <link rel="stylesheet" href="../../css/admin/editarBanner.css">


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
        <!-- Si mediante GET se obtiene editar, Se pasa a la seccion de edicion, sino, se muestran solo datos -->
        
        <?php if(!isset($editar)) {?>
            
            <!-- Seccion de datos -->
            <div class="container-fluid container_banner ">
                <!-- DIV ALERTAS -->
                <div class="container-fluid" id="msj_alerta"></div>
                <!-- CONTENIDO -->
                <h1 class="mt-3 text-center">Edición de banners</h1>
                <hr>
                <h3 class="mt-3 text-center">Los banners son las imágenes que aparecen en la sección de inicio. Puedes agregar, quitar o modificar las imágenes así como el texto que se muestra sobre ellas.</h3>
                <h4 class="mt-4 text-center">Da click en el botón para editar los elementos.</h4>
                <!-- BOTON EDITAR -->
                <div class="d-flex justify-content-end mb-2"  >
                    <a class="btn btn-success" title="Editar" href="../../html/admin/editarBanners.php?editar=1"> <i class="bi bi-pencil-fill"></i> Editar elementos </a>
                </div>
                 <!--MUESTRA DEL BANNER ORIGINAL  -->
                <?php
                    foreach($imagenesBanner as $banner){
                ?>
                        <div class="editar_banner container-fluid " >
                            <div class="row align-items-center ">
                                <div class="col-8 col-md-4 pt-3">
                                    <img src="<?= SITE_PATH. $banner["ruta"] ?>" alt="Imagen banner" class="imagen_banner d-block w-100">
                                    <h5 class="text-center text-light "> </h5>
                                </div>
                                <div class="col-12 col-md-8 ">
                                    <h3 class=" "><?= $banner["titulo"] ?></h3> 
                                    <h5 class=" mb-4"><?= $banner["descripcion"]?></h5> 
                                </div>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
            <!-- Seccion de editar -->
        <?php }else { ?>
            <div class="container-fluid container_banner">
                <!-- DIVS DE ALERTAS Y MODALES -->
                <div class="container-fluid" id="msj_modal"></div>
                <div class="container-fluid" id="crear_modal"></div>
                <h1 class="mt-3 text-center">Editar banner</h1>
                <hr>
                <!-- BOTON REGRESAR -->
                <div class="d-flex justify-content-end mb-2"  >
                    <a class="btn btn-secondary" title="Regresar" href="../../html/admin/editarBanners.php"> <i class="me-2 bi bi-arrow-left-square"></i> Regresar </a>
                </div> 
                <!-- ELEMENTOS DE EDICION -->
                <div class="editar_banner color_fondo container-fluid py-3" >
                    <form class="form" action="../../php/admin/editarDiseno.php" id="form_editar_banner"method="post" enctype="multipart/form-data" autocomplete="off">
                        <input type="hidden" name="banner" value="editarBanner">
                    <?php
                        //Variable count se usa para dar un diferente id a cada imagen para los label
                        $count=0;
                        foreach($imagenesBanner as $banner){
                    ?>
                            <input type="hidden" name="id_imagen[]" value="<?= $banner["id_imagen"]?>">
                            <input type="hidden" name="tipo" value="<?= $banner["tipo"]?>">
                            <div class="editar_banner container-fluid " >
                                <div class="row align-items-center ">
                                    <!-- IMAGEN E INPUT DE IMAGEN-->
                                    <div class="col-8 mx-auto col-lg-4 pt-3" >
                                        <img src="<?= SITE_PATH. $banner["ruta"] ?>" alt="Imagen banner" class="w-100 imagen_banner d-block" id="archivoBanner_img<?=$count?>">
                                        <label for="archivo_banner<?=$count?>" class="btn label_input<?= $count?>"><span class="label_texto">Selecciona una imagen  (max.2 MB)</span><i class="ms-2 bi bi-caret-down-square"></i></label>
                                        <span class="tool_tip"  data-bs-placement="right" title="Error: archivo mayor a 2 MB"></span>
                                        <input type="file" style="display:none" accept="image/*" class="input_archivo_banner form-control text-center" id="archivo_banner<?=$count ?>"name="archivo_banner[]"  title="Selecciona una imagen" onchange="imagenSeleccion(this,'<?=$count?>')">
                                        <input type="hidden" name="imagen_default[]"  value="<?= $banner["ruta"] ?>">
                                    </div> 
                                    <div class="col-12 col-lg-8 mt-2 ">
                                        <!-- INPUT TITULO  -->
                                        <div class="input-group d-block  d-sm-inline-flex">
                                            <div class="input-group-text col-2 col-sm-2">Titulo: </div>
                                            <div class="col-12 col-md-10">
                                                <input type="text"   class=" form-control fs-5 input_titulo text-center input_texto " name="titulo[]" value="<?= $banner["titulo"] ?>">  
                                            </div>
                                        </div>
                                        <!-- INPUT DESCRIPCION -->
                                        <div class="input-group d-block d-sm-inline-flex">
                                            <div class="input-group-text col-2 col-sm-2">Descripción:</div>
                                            <div class="col-12 col-md-10">
                                                <input type="text"   class="form-control fs-5 input_desc  text-center input_texto " name="descripcion[]" value="<?= $banner["descripcion"] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- BOTON ELIMINAR -->
                                    <div class="col-1 ms-auto me-end mt-2">
                                        <a class="btn btn-outline-danger" onclick="modalEliminar('<?= $banner['id_imagen']?>')" title="Eliminar banner"><i class="bi bi-trash-fill"></i></a>
                                    </div>
                                </div>
                            </div>
                            <hr>
                    <?php
                        $count++;
                        } //Fin foreach
                    ?>
                        <!-- Div en el cual se agregaran los nuevos banners -->
                        <div class="agregar_banner container-fluid"></div>
                        <!-- BOTON AGREGAR BANNER -->
                        <div class="btn_agregar mt-3">
                            <!-- Se pasa count a la funcion agregarBanner ya que este indica la cantidad de imagenes cargadas desde la base -->
                            <a id="btn_agregar_banner" onclick="agregarBanner(<?=$count ?>)"><i class="bi bi-plus"></i>
                                Agregar banner
                            </a>           
                        </div>
                        <!-- SUBMIT -->
                        <div class="d-flex justify-content-end my-2">
                            <h5>Si no deseas el texto de alguno de los titulos deja los campos en blanco.</h5>
                            <button type="submit" class="ms-3 btn btn-primary" title="Guardar cambios" id="enviar_banner"> Guardar </button>
                        </div>
                    </form>
                </div>   
        <?php } ?>  
    </div>
    
 
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/iro@5.js"></script>
    <script src="../../js/admin/editarBanner.js"></script>
   
        
    
</body>
</html>