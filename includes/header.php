<!--HEADER con imagenes y colores obtenidos desde la base de datos -->
<?php
    /**
     * Diferentes rutas de Acceso a la clase Imagenes el cual contiene 
     * las funciones para obtener las imagenes del header
     */
    if(isset($index)) include_once ("php/clases/Imagenes.php");
    else if(isset($adminlogin)) include_once("../../../php/clases/Imagenes.php");
    else  include_once("../../php/clases/Imagenes.php");

    // Instancias y consultas para obtener las imagenes del header
    $objImagenes = new Imagenes($db);
    $imagenHeader = $objImagenes -> obtenerImagenes("header");

?>
<div class="encabezado container-fluid d-flex justify-content-start" style="color:<?= $imagenHeader[0]["color_texto"]?>; background-color: <?= $imagenHeader[0]["color_fondo"] ?>">
    <div class="row align-items-center">
        <div class="col-sm py-3">
            <a href="inicio.php">
                <img src="<?= SITE_PATH. $imagenHeader[0]["ruta"] ?>" alt="Imagen header" class="logo d-block mx-auto">  
            </a>
        </div>
    </div>
    <div class="row align-items-center ms-2 mt-3 ">
        <div class="col-sm">
            <h3 class=""><?= $imagenHeader[0]["titulo"] ?></h3> 
            <h5 class="mb-4"><?= $imagenHeader[0]["descripcion"] ?></h5> 
        </div>
    </div>
</div>