<div class="col-12 col-md-2 div_nav p-0 ">
        <nav class="navbar nav_profesor navbar-expand-md flex-md-column flex-row align-items-start py-2 sticky-top mb-5"  id="sidebar">
            <a class="text-center nav_perfil p-3">
                <div class="fs-1 d-none d-md-block">
                    <i class="bi bi-person-circle"></i>
                </div>
                <div class="navbar-brand mx-0 nav_perfil_texto" ><?php echo $_SESSION["nombre_profesor"] ?></div>
               
            </a>
            
            <button type="button" class="navbar-toggler custom_toggler  order-1" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" onclick="this.blur();"aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
           
          
            <div class="collapse <?= $nav_inicio?> navbar-collapse order-last w-100" id="nav">
       
                <ul class="navbar-nav flex-column ul_nav  justify-content-center" >
                    <li class="nav-item mb-3 mb-3">
                        <a class="nav-link <?= $active_inicio ?>   drop_button ps-4" aria-current="page" href="inicio.php" onclick="this.blur()">
                            <i class="bi bi-house-door-fill me-2" ></i> Inicio
                        </a>

                    </li>

                    
                    <li class="nav-item mb-2">
                        <button class="btn accordion-button drop_button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#materias-collapse" aria-expanded="false" >
                            <i class="bi bi-file-earmark-text me-2"></i> Materias 
                        </button>
                        <div class="collapse <?= $nav_materias?>" id="materias-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal  pb-2 ">
                                <li class="mt-2 "><a class=" dropdown_item <?= $active_examenes?>  nav_opcion_profesor ps-4" href="examenes.php">Examenes</a></li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item mb-2">
                        <button class="btn accordion-button drop_button collapsed mb-2" type="button" data-bs-toggle="collapse" data-bs-target="#alumnos-collapse" aria-expanded="false" >
                            <i class="bi bi-file-earmark-text me-2"></i>
                                Alumnos
                                <?php if($numeroSolicitudes>0){ ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?= $numeroSolicitudes?>
                                    <span class="visually-hidden">Solicitudes</span>
                                </span> 
                                <?php } ?>
                        </button>
                        <div class="collapse <?= $nav_alumnos?>" id="alumnos-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal  pb-2 ">
                                <li><a class="nav-link <?= $active_solicitudes ?> dropdown_item nav_opcion_profesor ps-4 mb-2" href="solicitudes.php">
                                        Solicitudes <?php if($numeroSolicitudes > 0 ) { ?> 
                                        <span class='badge bg-secondary'><?= $numeroSolicitudes ?> </span>
                                        <?php } ?>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown_item <?= $active_lista ?> nav_opcion_profesor ps-4" href="listaAlumnos.php">Lista de alumnos</a>

                                </li>
                            </ul>
                        </div>
                    </li>
                    <li class="nav-item  mb-3">
                        <a class="nav-link   drop_button ps-3  " href="../../php/autenticacion/logout.php">
                            <i class="bi bi-box-arrow-left me-2"></i>  Salir
                        </a>
                    </li>
                </ul>
            </div>      
        </nav>   
</div>