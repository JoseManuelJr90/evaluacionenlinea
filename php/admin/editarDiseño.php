<?php 
include_once "../general.php";
include "../clases/DbProyectoEvaluacion.php";
include "../../php/clases/Imagenes.php";

$dbEvaluacion = new DBProyectoEvaluacion;
$db = $dbEvaluacion->connect();

$objImagenes = new Imagenes($db);

if(isset($_POST["encabezado"])){
    $tipo = $_POST["tipo"];
    $id_imagen = $_POST["id_imagen"];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"]; 
    $imagenDefault = $_POST["imagen_default"];
    $color_fondo = $_POST["color_fondo"];
    $color_texto = $_POST["color_texto"];

    if($_FILES["archivo_encabezado"]["error"] > 0 && $_FILES["archivo_encabezado"]["error"] != 4){
        echo "Error al cargar archivo";
        header("Location: ../../html/admin/editarEncabezado.php?error=1");
    }


    $typesPermitidos = ["image/jpg", "image/png", "image/jpeg", "image/svg+xml", "image/gif"];
    $tamaño_kb = 2000;

    if($_FILES["archivo_encabezado"]["name"]){
    

        if(in_array($_FILES["archivo_encabezado"]["type"], $typesPermitidos) && $_FILES["archivo_encabezado"]["size"] <= $tamaño_kb * 1024){

            $ruta = "img/".$_FILES["archivo_encabezado"]["name"];
            $archivo = "../../img/".$_FILES["archivo_encabezado"]["name"];
            $ruta = limpiarDato($ruta);
            $moverArchivo = @move_uploaded_file($_FILES["archivo_encabezado"]["tmp_name"], $archivo);
            if($moverArchivo){
                $db->beginTransaction();
                $guardarArchivoEnBase = $objImagenes -> editarImagen($id_imagen, $ruta, $titulo, $descripcion, $color_fondo, $color_texto);
                if($guardarArchivoEnBase === "error"){
                    header("Location: ../../html/admin/editarEncabezado.php?error=3");
                }

                $db->commit();

                header("Location: ../../html/admin/editarEncabezado.php?mensaje=3");
            }
            


        } else {
            echo "Tamaño o tipo del archivo no son validos";
            header("Location: ../../html/admin/editarEncabezado.php?error=2");
        }
    }else {

        $db->beginTransaction();
        $editarArchivoEnBase = $objImagenes -> editarImagen($id_imagen, $imagenDefault, $titulo, $descripcion, $color_fondo, $color_texto);
        if($editarArchivoEnBase === "error"){
            header("Location: ../../html/admin/editarEncabezado.php?error=3");
        }

        $db->commit();

        header("Location: ../../html/admin/editarEncabezado.php?mensaje=3");

    }
}



if(isset($_POST["banner"])){



    /**************BANNERS EXISTENTES MODIFICADOS************** */
    $id_imagen = $_POST["id_imagen"];
    $titulo = limpiarDato($_POST["titulo"]);
    $descripcion = limpiarDato($_POST["descripcion"]); 
    $imagen_default = limpiarDato($_POST["imagen_default"]);
    
    $imagen_nueva = $_FILES["archivo_banner"];

    /**************BANNERS NUEVOS ************* */

    if(isset($_POST["titulo_nuevo"]))$titulo_nuevo = $_POST["titulo_nuevo"];
    if(isset($_POST["descripcion_nuevo"]))$descripcion_nuevo = $_POST["descripcion_nuevo"];
    if(isset($_FILES["archivo_banner_nuevo"]))$archivo_imagen_nuevo = $_FILES["archivo_banner_nuevo"];
    

    $typesPermitidos = ["image/jpg", "image/png", "image/jpeg", "image/svg+xml", "image/gif"];
    $tamaño_kb = 2000;
    ?>

    <!-- <pre>
        <?= print_r ($archivo_imagen_nuevo) ?>
    </pre> -->

    <?php

    if(isset($_FILES["archivo_banner_nuevo"])){
        
        for ($i=0; $i < count($archivo_imagen_nuevo["name"]) ; $i++) { 

            if($archivo_imagen_nuevo["error"][$i] > 0 && $archivo_imagen_nuevo["error"][$i]!=4){
                echo "Error al cargar archivo";
                header("Location: ../../html/admin/editarBanners.php?error=1");
                exit();
            }else if(in_array($archivo_imagen_nuevo["type"][$i], $typesPermitidos) && $archivo_imagen_nuevo["size"][$i] <= $tamaño_kb * 1024){
                $ruta_nuevo= "img/".$archivo_imagen_nuevo["name"][$i];
                $archivo_nuevo = "../../img/".$archivo_imagen_nuevo["name"][$i];
                $ruta_nuevo = limpiarDato($ruta_nuevo);
                $mover_archivo_nuevo = @move_uploaded_file($archivo_imagen_nuevo["tmp_name"][$i], $archivo_nuevo);
                if($mover_archivo_nuevo){
                    $db->beginTransaction();
                    $guardarNuevoBanner = $objImagenes -> guardarImagen( $ruta_nuevo, $titulo_nuevo[$i], $descripcion_nuevo[$i], "banner");
                    if($guardarNuevoBanner === "error"){
                        header("Location: ../../html/admin/editarBanners.php?error=3");
                    }

                    $db->commit();
                    
                   
                }else{
                    echo "Error al guardar la imagen en la carpeta";
                    header("Location: ../../html/admin/editarBanners.php?error=3");
                    exit();
                }

            }else{
                echo "Tamaño o tipo del archivo no son validos";
                header("Location: ../../html/admin/editarBanners.php?error=2");
                exit();

            }

            
        }
    }


    for ($i=0; $i < count($imagen_nueva["name"]) ; $i++) { 
        if($imagen_nueva["error"][$i] > 0 && $imagen_nueva["error"][$i]!=4){
            echo "Error al cargar archivo";
            header("Location: ../../html/admin/editarBanners.php?errorA=1");
            exit();
        }  

        if($imagen_nueva["name"][$i] != NULL ){
            if(in_array($imagen_nueva["type"][$i], $typesPermitidos) && $imagen_nueva["size"][$i] <= $tamaño_kb * 1024){
                $ruta = "img/".$imagen_nueva["name"][$i];
                $archivo = "../../img/".$imagen_nueva["name"][$i];
                $ruta = limpiarDato($ruta);
                $moverArchivo = @move_uploaded_file($imagen_nueva["tmp_name"][$i], $archivo);
                if($moverArchivo){
                    $db->beginTransaction();
                    $guardarArchivoEnBase = $objImagenes -> editarImagen($id_imagen[$i], $ruta, $titulo[$i], $descripcion[$i], $color_fondo = NULL, $color_texto = NULL);
                    if($guardarArchivoEnBase === "error"){
                        header("Location: ../../html/admin/editarBanners.php?errorA=3");
                    }

                    $db->commit();

                    header("Location: ../../html/admin/editarBanners.php?mensaje=3");
                }else{
                    echo "Error al guardar la imagen en la carpeta";
                    header("Location: ../../html/admin/editarBanners.php?error=3");
                    exit();
                }

            }else{
                echo "Tamaño o tipo del archivo no son validos";
                header("Location: ../../html/admin/editarBanners.php?errorA=2");
                exit();

            }
             
        }else{
            $db->beginTransaction();
            $editarArchivoEnBase = $objImagenes -> editarImagen($id_imagen[$i], $imagen_default[$i], $titulo[$i], $descripcion[$i], $color_fondo=NULL, $color_texto=NULL);
            if($editarArchivoEnBase === "error"){
                header("Location: ../../html/admin/editarBanners.php?error=3");
            }
    
            $db->commit();
    
            header("Location: ../../html/admin/editarBanners.php?mensaje=3");
            
        }

      
        

    }

    ?>


    <?php

}

if(isset($_GET["eliminar"])){
    $id_imagen = $_GET["eliminar"];

    $eliminar_banner = $objImagenes -> eliminarBanner($id_imagen);
    if($eliminar_banner === "error"){
        header("Location: ../../html/admin/editarBanners.php?error=5");
        exit();
    }


}



?>