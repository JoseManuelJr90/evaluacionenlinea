


    /**
     * Funcion que muestra modal para confirmar la eliminacion de una pregunta, al confirmar se hace una peticion fetch
     * @param {*} numero_pregunta 
     * @param {*} id_parcial 
     * @param {*} id_pregunta 
     */
    const mostrarModal = function modalShow(numero_pregunta,id_parcial, id_pregunta) {
        let modal_contenido = document.createElement("div");
        console.log(id_parcial, id_pregunta);
        modal_contenido.innerHTML = `<div class="modal fade" tabindex="-1">`+
                                        `<div class="modal-dialog modal-dialog-centered">`+
                                            `<div class="modal-content cuadro_modal">`+
                                                `<div class="modal-header">`+
                                                    `<h5 class="modal-title" id="modal_borrarLabel">Borrar Pregunta</h5>`+
                                                    `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                                `</div>`+
                                                `<div class="modal-body">`+
                                                    `Deseas borrar la pregunta <strong>${numero_pregunta}?</strong>`+
                                                `</div>`+
                                                `<div class="modal-footer">`+
                                                    `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                                    `<button type="button" class="btn btn-danger btn_borrar">Borrar</button>`+
                                                `</div>`+
                                            `</div>`+
                                        `</div>`+
                                    `</div>`;

        msj_modal.append(modal_contenido);

        let modal = new bootstrap.Modal(modal_contenido.querySelector(".modal"));
        modal.show();

        if(document.querySelectorAll(".btn_borrar")){
            confirmarBorrar = document.querySelectorAll(".btn_borrar");
            for(i=0; i < confirmarBorrar.length; i++){
                confirmarBorrar[i].onclick = (e) =>{
                    e.preventDefault();
                    fetch(`../../php/profesor/crearEditarExamen.php?parcial=${id_parcial}&pregunta=${id_pregunta}`)
                    .then(res=>{
                        if(!res.ok) {
                            throw new Error("Error al borrar la pregunta")
                        }
                        return res
                    })
                    .then(() => {
                        mostrarConfirmacion(2);
                    })
                    .catch(error =>{
                        console.log('Error al borar la pregunta' + error);
                    })
                }
            }

        }
    }

   
 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 */
    function mostrarConfirmacion(tipo) {
        let timerInterval
        Swal.fire({
            title: 'Actualizando',
            html: 'Completando solicitud',
            timer: 800,
            timerProgressBar: true,
            didOpen: () => {
            Swal.showLoading()
            const b = Swal.getHtmlContainer().querySelector('b')
            timerInterval = setInterval(() => {
                b.textContent = Swal.getTimerLeft()
            }, 100)
            },
            willClose: () => {
            clearInterval(timerInterval)
            }
            }).then((result) => {
            /* Read more about handling dismissals below */
            if(tipo == 1) alerta('success','bi-check-lg','Solicitu completada','Se han actualizado los datos')
            // Manejo del scroll
            // Si se elimino la pregunta, se guarda en el localStorage la posicion en la cual se encontraba esa prgunta,
            //al recargar la pagina, nos dirige a esa posicion.
            if(tipo == 2) {
                localStorage.setItem('scrollpos', window.scrollY);
                location.href = `../../html/profesor/formatoExamen.php?mensaje=2&parcial=${parcial}`;
            }
            // Si se agrego una pregunta, al recargar la pagina nos envia al final del documento
            if(tipo == 3){
                alerta('success','bi-check-lg','Solicitu completada','Se agrego la pregunta')
                window.scrollTo(0, document.body.scrollHeight)

            } 
            if (result.dismiss === Swal.DismissReason.timer) {
                console.log('Listo!')
            }
        })
        
    }

    
    /**
     * Funcion que nos permite crear distintos tipos de alertas utilizando diferentes opciones
     * 
     * @param {*} opcion, tipo de alerta
     * @param {*} icono , icono de la alerta
     * @param {*} encabezado alerta
     * @param {*} mensaje alerta
     * 
     * 
     */

    function alerta(opcion, icono ,encabezado, mensaje){
        
        console.log(opcion, icono);
        let msjAlerta = document.querySelector("#msj_alerta");
        
        msjAlerta.innerHTML = `<div class="alert alert-${opcion} alert-dismissible  " role="alert" >`+ 
        '<button type="button" class="btn-close pb-2" data-bs-dismiss="alert" aria-label="Close"></button>' +
        `<i class="bi ${icono} d-inline pe-2"></i>`+
        `<h5 class="alert-heading d-inline">${encabezado}</h5>`+ 
        `<p>${mensaje}</p>` +
        '</div>'

        const bsAlerta = new bootstrap.Alert(msjAlerta);

        //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
        setTimeout(() => {
        bsAlerta.close();
        history.replaceState(null,null,`../../html/profesor/formatoExamen.php?parcial=${parcial}`)
        }, 3000);
        
        
    }



    //Obtener URL 
    let url = new URLSearchParams(location.search);
    let parametro = url.get('mensaje');
    let parcial = url.get('parcial');
    
    //Mostrar mensaje
    let msj_modal = document.querySelector("#msj_modal");
    
    if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
    if(parametro == 1) mostrarConfirmacion(1);
    if(parametro == 3) mostrarConfirmacion(3);
    if(parametro == 2) alerta('success','bi-check-lg','Solicitu completada','Se borrado la pregunta')
    
    //Mover el scroll al actualizar pagina
    //Se obtiene el valor del localStorage, si el valor no es nulo, nos dirige a esa posicion y luego se actualiza a 0        
    var scrollpos = localStorage.getItem('scrollpos');
    if (scrollpos) window.scrollTo(0, scrollpos);
    localStorage.setItem('scrollpos', 0);

    //Agregar pregunta
    
    let modal_pregunta = document.querySelector("#modal_pregunta");
    /**
     * Funcion que crea un modal con los input para crear una pregunta, al confirmar se hace un submit
     * @param {*} id_parcial 
     */
    const agregarPregunta = function addPregunta(id_parcial){
        let modalPregunta = document.createElement("div");
        modalPregunta.innerHTML = `<div class="modal fade " tabindex="-1">`+
                                `<div class="modal-dialog modal-dialog-centered modal-xl ">`+
                                    `<div class="modal-content cuadro_modal_agregar">`+
                                        `<div class="modal-header">`+
                                            `<h5 class="modal-title" id="modal_preguntaLabel">Nueva pregunta</h5>`+
                                            `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                        `</div>`+
                                        `<div class="modal-body">`+
                                            `<form action="../../php/profesor/crearEditarExamen.php" method="post" id="form_pregunta">`+  
                                            `<input type="hidden" name="agregar" value="agregar">`+
                                            `<input type="hidden" name="id_parcial" value="${id_parcial}">`+
                                            `<div class="container-fluid mb-3 div_preguntas" >`+
                                            `<div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <label for="input_pregunta" class="col-6 col-md-6 col-form-label ">Pregunta: </label>`+
                                            `                   <div class="input-group input_pregunta">`+
                                            `                       <div class="input-group mb-1">`+
                                            `                           <div class="input-group-text"><strong class="">#</strong></div>`+
                                            `                           <input required class=" form-control numero_pregunta" pattern="^[0-9]*$" maxlength="2" type="text" name="numero_pregunta">`+
                                            `                       </div>`+
                                            `                       <div class="input-group-text"><i class="bi bi-pencil-square"></i></div>`+
                                            `                       <input required class="form-control" type="text" name="pregunta">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <span class="col-form-label" col-6 col-md-6 ">Respuestas:</span>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <div class="input-group">`+
                                            `                       <div class="input-group-text"><strong class="">a</strong></div>`+
                                            `                       <input required class="form-control" type="text" name="respuesta_a">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <div class="input-group">`+
                                            `                       <div class="input-group-text"><strong class="">b</strong></div>`+
                                            `                       <input required class="form-control" type="text" name="respuesta_b">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <div class="input-group">`+
                                            `                       <div class="input-group-text"><strong class="">c</strong></div>`+
                                            `                       <input required class="form-control" type="text" name="respuesta_c">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <div class="input-group">`+
                                            `                       <div class="input-group-text"><strong class="">d</strong></div>`+
                                            `                       <input required class="form-control" type="text" name="respuesta_d">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                                            `           <div class="row mb-3 d-flex justify-content-center">`+
                                            `               <div class="col-11 col-lg-11 ">`+
                                            `                   <div class="input-group">`+
                                            `                       <div class="input-group-text"><strong class="">e</strong></div>`+
                                            `                       <input required class="form-control" type="text" name="respuesta_e">`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+
                            
                                            `           <div class="row mb-3 d-flex">`+
                                            `               <div class="div_respuesta_correcta_agregar">`+
                                            `                   <div class="input-group mb-3">`+
                                            `                       <label for="input_correcta" class=" col-form-label ">Respuesta correcta:</label>`+
                                            `                       <div class="input-group input_correcta_agregar">`+
                                            `                           <div class="input-group-text"><i class="bi bi-check-lg"></i></div>`+
                                            `                           <select required class="form-select" name="respuesta_correcta">`+
                                            `                               <option selected>a</option>`+
                                            `                               <option value="b">b</option>`+
                                            `                               <option value="c">c</option>`+
                                            `                               <option value="d">d</option>`+
                                            `                               <option value="e">e</option>`+
                                            `                           </select>`+
                                            `                       </div>`+
                                            `                   </div>`+
                                            `               </div>`+
                                            `           </div>`+                                              
                                            `       </div>`+   
                                            
                                            `<div class="modal-footer">`+
                                                `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                                `<button type="submit" class="btn btn-primary btn_guardar">Guardar</button>`+
                                            `</div>`+
                                            `</form>`+
                                        `</div>`+
                                    `</div>`+
                                `</div>`+
                            `</div>`; 
                            
        modal_pregunta.append(modalPregunta);
        let modal = new bootstrap.Modal(modalPregunta.querySelector(".modal"));
        modal.show();

        let btn_guardar = document.querySelector(".btn_guardar");
        btn_guardar.onsubmit = (e) =>{
            e.preventDefault();
            
            document.forms["form_pregunta"].submit();
        }





    }
            
             