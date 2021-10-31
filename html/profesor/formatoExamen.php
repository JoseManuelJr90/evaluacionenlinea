<?php include_once "../../php/general.php"; 
      include_once '../../includes/verificar_sesion_profesor.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
        <?php
            // Includes
            include_once "../../includes/headGeneral.php";
            include_once "../../includes/verificar_solicitudes.php";
            include_once "../../php/clases/profesor/Examenes.php";
            include_once "../../php/clases/profesor/ParcialesProfesor.php";
            include_once "../../php/clases/profesor/MateriasProfesor.php";


            //Instancias
           
            $objExamenes = new Examenes($db);
            $objDatosParcial = new ParcialesProfesor($db);
            $objDatosParcial = new ParcialesProfesor($db);
            $objMateriasProfesor = new MateriasProfesor($db);

            // Consultas
            $preguntas = $objExamenes->obtenerPreguntasyRespuestas($_GET["parcial"]);
            $parcial = $objDatosParcial->obtenerDatosParciales($_GET["parcial"]);   
        
?>  
    <script src="../../js/sweetalert2.all.min.js"></script>
    <!-- CSS -->
    <link rel="stylesheet" href="../../css/profesor/formatoExamen.css">
    <link rel="stylesheet" href="../../css/navbar.css">
    <title>Sistema de Evaluación en Linea</title>
</head>


<body >
    <!-- HEADER -->
    <header>
        <?php  include_once "../../includes/header.php";?>
    </header>
    <!-- CUERPO -->
    <div class="d-md-flex">
        <!-- NAVBAR -->    
        <?php include_once "../../includes/navbarProfesor.php" ;?>
        <!-- CONTENIDO -->
        <div class="col-12 col-md-10 ">
            <!-- DIVS DE MODALES Y ALERTAS -->
            <div class="container-fluid" id="msj_modal"></div>
            <div class="container-fluid" id="msj_alerta"></div>
            <div class="container-fluid" id="modal_pregunta"></div>
            <!-- CONTENIDO -->
            <main class="container-fluid examen my-3s pt-3 examen" >
                <h3 class="text-center "><h3>
                <!-- FORMULARIO -->
                <form action="../../php/profesor/crearEditarExamen.php" method="post" id="form_examen">  
                    <input type="hidden" name="id_maestro" value="<?= $parcial[0]["id_maestro"] ?>">
                    <input type="hidden" name="id_parcial" value="<?= $parcial[0]["id_parcial"] ?>">
                    <input type="hidden" name="editar" value="editar">
                    <!-- BOTON REGRESAR -->
                    <div class="mb-3 btn_registrar">
                        <a class="btn enviar_examen fs-5 text-secondary"href="../../html/profesor/examenes.php"><i class="bi bi-arrow-left-square me-2"></i>Regresar</a>
                    </div>
                    <!-- INPUTS DATOS PARCIAL -->
                    <div class="d-flex row justify-content-center pb-3">
                        <div class="col-2 col-lg-2 me-3 mb-3 " >
                            <label for="input_nombre" class="col-4 col-form-label ">Materia: </label>
                            <div class="input-group col-4">
                                <span class="input_nombre"> <?= $parcial[0]["nombre_materia"] ?></span>
                            </div>
                        </div>
                        <div class="col-10 col-lg-3 me-2 mb-3">
                            <label for="input_nombre_parcial" class=" col-form-label ">Nombre parcial: </label>
                            <div class="input-group">
                                <div class="input-group-text"><i class="bi bi-pencil-square"></i></div>
                                <input type="text" class="form-control input_nombre_parcial" name="nombre_parcial" value="<?= $parcial[0]["nombre_parcial"] ?>"> 
                            </div>
                        </div>
                        <div class="col-5 col-lg-2 me-2">
                            <label for="input_numero_parcial" class="  col-form-label ">Numero parcial: </label>
                            <div class="input-group">
                                <div class="input-group-text ">#</div>
                                <input type="text" class="form-control input_numero_parcial" style="max-width: 150px" pattern="^[0-9]*$" maxlength="2" name="numero_parcial" value="<?= $parcial[0]["numero_parcial"] ?>"> 
                            </div>
                        </div>
                        <div class="col-5 col-lg-3 ">
                            <label for="input_duracion_parcial" class="  col-form-label ">Duracion parcial: </label>
                            <div class="input-group">
                                <div class="input-group-text "><i class="bi bi-stopwatch"></i></div>
                                <input type="text" class="form-control input_duracion_parcial" style="max-width: 70px" pattern="^[0-9]*$" maxlength="3" name="duracion_parcial" value="<?= $parcial[0]["duracion_parcial"] ?>"> 
                                <div class="input-group-text ">minutos</div>
                            </div>
                        </div>
                    </div>
                    <!-- BOTON GUARDAR -->
                    <div class="mb-3 btn_registrar">
                        <button type="submit" class="btn btn-primary enviar_examen" id=""> Guardar </button>
                    </div>
                    <?php     
                    // CICLO PARA MOSTRAR PREGUNTAS Y RESPUESTAS GUARDADAS
                    foreach ($preguntas as $pregunta){ ?>    
                        <div class="container-fluid mb-3 div_preguntas" >
                            <input type="hidden" name="id_pregunta[]" value="<?= $pregunta["id_pregunta"] ?>">
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <label for="input_pregunta" class="col-6 col-md-6 col-form-label ">Pregunta: </label>
                                    <div class="input-group input_pregunta">
                                        <div class="input-group mb-1">
                                            <div class="input-group-text"><strong class="">#</strong></div>
                                            <input required class=" form-control numero_pregunta" pattern="^[0-9]*$" maxlength="2" type="text" name="numero_pregunta[]" value = "<?= $pregunta["numero_pregunta"]?>">
                                        </div>
                                        <div class="input-group-text"><i class="bi bi-pencil-square"></i></div>
                                        <input required class="form-control" type="text" name="pregunta[]" value = "<?= $pregunta["pregunta"]?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <span class="col-form-label col-6 col-md-6 ">Respuestas:</span>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <div class="input-group">
                                        <div class="input-group-text"><strong class="">a</strong></div>
                                        <input required class="form-control" type="text" name="respuesta_a[]" value = "<?=$pregunta["a"]?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <div class="input-group">
                                        <div class="input-group-text"><strong class="">b</strong></div>
                                        <input required class="form-control" type="text" name="respuesta_b[]" value = "<?=$pregunta["b"]?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <div class="input-group">
                                        <div class="input-group-text"><strong class="">c</strong></div>
                                        <input required class="form-control" type="text" name="respuesta_c[]" value = "<?=$pregunta["c"]?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <div class="input-group">
                                        <div class="input-group-text"><strong class="">d</strong></div>
                                        <input required class="form-control" type="text" name="respuesta_d[]" value = "<?=$pregunta["d"]?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-1 d-flex justify-content-center">
                                <div class="col-11 col-lg-10 ">
                                    <div class="input-group">
                                        <div class="input-group-text"><strong class="">e</strong></div>
                                        <input required class="form-control" type="text" name="respuesta_e[]" value = "<?=$pregunta["e"]?>">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-1 d-flex">
                                <div class="div_respuesta_correcta">
                                    <div class="input-group mb-1">
                                        <label for="input_correcta" class="col-6 col-md-6 col-form-label ">Respuesta correcta:</label>
                                        <div class="input-group input_correcta">
                                            <div class="input-group-text"><i class="bi bi-check-lg"></i></div>
                                            <select required class="form-select" name="respuesta_correcta[]">
                                                <option selected><?= $pregunta["respuesta_correcta"] ?></option>
                                                <option value="a">a</option>
                                                <option value="b">b</option>
                                                <option value="c">c</option>
                                                <option value="d">d</option>
                                                <option value="e">e</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <a class="btn btn-danger btn_eliminar" title="Eliminar pregunta" onclick="mostrarModal('<?= $pregunta['numero_pregunta'] ?>','<?=$pregunta['id_parcial']?>','<?= $pregunta['id_pregunta'] ?>')"><i class="bi bi-trash-fill"></i></a>
                            </div> 
                        </div>
                    <?php
                    }
                    if($preguntas){ ?>
                        <div class="mb-1 btn_registrar">
                            <button type="submit" class="btn btn-primary " id="enviar_examen"> Guardar </button>
                        </div>
                    <?php 
                    } ?>
                </form>
                <!-- BOTON AGREGAR PREGUNTA -->
                <div class="btn_agregar">
                    <button type="submit" id="btn_agregar_pregunta" onclick="agregarPregunta('<?= $parcial[0]['id_parcial'] ?>')"><i class="bi bi-plus"></i>
                        Agregar pregunta
                    </button>           
                </div>   
            </main>
        </div>
    </div>
    <!-- JS -->
    <script src="../../js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="../../js/profesor/formatoExamen.js"></script>

</body>
</html>