
<?php 
// Variable que se obtiene de header.php
$imagenesBanner = $objImagenes -> obtenerImagenes("banner");
?>
<!-- Variable inicio md es obtenida de los inicios.php que tienen sidebar -->
<div class="col-12 <?= $inicio_md ?> ">           
    <section class="container-fluid ">
        <div class="carousel slide inner_carousel" id="mainSlider" data-bs-ride="carousel" data-bs-pause="false">
            <!-- Botones barra de cada slide -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <?php    
                $count = sizeof($imagenesBanner);
                for($i=1; $i < $count ; $i++){ ?>
                    <button type="button" data-bs-target="#mainSlider" data-bs-slide-to="<?php echo $i ?>" aria-label="Slide <?php echo $i+1?>"></button>
                    <?php
                } ?>
            </div>
            <!-- Imagenes del carousel -->
            <div class="carousel-inner carousel_slide" id="inner-car" >
                <!-- Se coloca una imagen default -->
                <div class="carousel-item active carousel_img pt-5" data-bs-interval="4500" style="background-image:url('<?=  SITE_PATH.$imagenesBanner[0]["ruta"] ?>')">
                    <div class=" text-center text-white pt-5">
                        <h1 class="pb-4 banner_titulo  banner_text"><?= $imagenesBanner[0]["titulo"] ?></h1>
                        <h3 class="banner_desc banner_text"><?= $imagenesBanner[0]["descripcion"]?> </h3>
                    </div> 
                </div>
                <?php 
                // Quitamos la imagen colocada del arreglo
                array_shift($imagenesBanner);
                // Colocamos las imagenes restantes
                foreach ($imagenesBanner as $imagen){ ?>
                    <div class="carousel-item carousel_img" data-bs-interval="4500" style="background-image:url('<?=  SITE_PATH.$imagen["ruta"] ?>')">
                        <div class=" text-center text-white pt-5">
                            <h1 class="pb-4 banner_titulo  banner_text"><?= $imagen['titulo']?></h1>
                            <h3 class="banner_desc banner_text"> <?= $imagen['descripcion'] ?></h3>
                        </div>
                    </div>
                 <?php 
                } ?>
            </div>
            <!-- Botones laterales del carousel -->
            <button class="carousel-control-prev " type="button" data-bs-target="#mainSlider" data-bs-slide="prev" >
                <i class="bi bi-chevron-left" style="font-size:70px; color:white"></i>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#mainSlider" data-bs-slide="next">
                <i class="bi bi-chevron-right" style="font-size:70px; color:white"></i>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <section class="acerca_de">
        <div class="container-md p-5 seccion_descripcion position-relative mt-3">
            <h3 class="titulo text-end me-5">
                SISTEMA DE EVALUACION EN LINEA
            </h3>
            <hr>
            <div class="row justify-content-md-center">
                <div class="col-lg">
                    <img src="../../img/slide01.jpg" alt="" class=" w-100">
                </div>
                <div class="col-lg mt-lg-0 mt-3">
                    <ul class="lista fs-md-1" >
                        <li>Sistema para realizar evaluaciones de opcion multiple</li>
                        <li>Evaluaciones con opcion de temporizador</li>
                        <li>Control de tiempo de acceso para cada prueba</li>
                        <li>Consula tus evaluaciones y calificaciones</li>
                        <li>Tiene elementos dinamicos, como las imagenes, secciones, materias y preguntas</li>
                        <li>Realizado con PHP, JAVASCRIPT, BOOTSTRAP 5, MYSQL</li>
                    </ul>
                </div>

            </div>

        </div>



    </section>
</div>
    