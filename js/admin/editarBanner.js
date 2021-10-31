

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
        
    let msjAlerta = document.querySelector("#msj_alerta");
     msjAlerta.innerHTML = `<div class="alert alert-${opcion} alert-dismissible  " role="alert" >`+ 
     `<i class="bi ${icono} d-inline pe-2"></i>`+
     `<h5 class="alert-heading d-inline">${encabezado}</h5>`+ 
     `<p>${mensaje}</p>` +
     '</div>';
 
     const bsAlerta = new bootstrap.Alert(msjAlerta);
 
     //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
     setTimeout(() => {
     bsAlerta.close();
     history.replaceState(null,null,"../../html/admin/editarBanners.php");
     }, 3000);
     
   
 }
 
 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 * @param {*} tipo 
 */
 function mostrarConfirmacion(tipo) {
     let timerInterval;
     let titulo = "";
     if(tipo == 2)  titulo = "Eliminando Banner";
     else  titulo = "Actualizando Banners";
     Swal.fire({
         title: titulo,
         html: 'Completando solicitud',
         timer: 600,
         timerProgressBar: true,
         didOpen: () => {
         Swal.showLoading();
         const b = Swal.getHtmlContainer().querySelector('b');
         timerInterval = setInterval(() => {
             b.textContent = Swal.getTimerLeft();
         }, 100);
         },
         willClose: () => {
         clearInterval(timerInterval);
         }
         }).then((result) => {
         /* Read more about handling dismissals below */
         if(tipo == 2) location.href = `../../html/admin/editarBanners.php?editar=1`;
         else location.href = `../../html/admin/editarBanners.php?mensaje=5`;
         if (result.dismiss === Swal.DismissReason.timer) {
             console.log('Listo!');
         }
         });
 }
 // Obtencion de parametros mediante la url
 let url = new URLSearchParams(location.search);
 let parametro = url.get('mensaje');
 //  Diferentes opciones de alerta de acuerdo al parametro recibido
 if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
 if(parametro == 5) alerta('success','bi-check-lg','Solicitu completada','Se han actualizado los cambios');
 if(parametro == 2) alerta('warning', 'bi-alarm-fill' , 'Tiempo agotado', 'La prueba fue registrada');
 if(parametro == 3) mostrarConfirmacion();
 
 
 let msj_modal = document.querySelector("#msj_modal");

/**
 * Funcion que crea un modal para guardar los cambios realizados, al confirmar se hace submit
 */
function mostrarModal (){
    let modal_contenido = document.createElement("div");
    let titulo_modal = "Guardar cambios";
    let cuerpo_modal = "¿Deseas guardar los cambios?";
    boton_modal = `<button type="button" class="btn btn-primary btn_modal">Guardar</button>`;

    modal_contenido.innerHTML = `<div class="modal fade" tabindex="-1">`+
                            `<div class="modal-dialog modal-dialog-centered">`+
                                `<div class="modal-content cuadro_modal">`+
                                    `<div class="modal-header">`+
                                        `<h5 class="modal-title" id="modal_borrarLabel">${titulo_modal}</h5>`+
                                        `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                    `</div>`+
                                    `<div class="modal-body">`+
                                        `${cuerpo_modal}`+
                                    `</div>`+
                                    `<div class="modal-footer">`+
                                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                        `${boton_modal}`+
                                    `</div>`+
                                `</div>`+
                            `</div>`+
                        `</div>`;

    msj_modal.append(modal_contenido);

    let modal = new bootstrap.Modal(modal_contenido.querySelector(".modal"));
    modal.show();
    // Se crea un evento click al confirmar el modal y se hace un submit
    document.querySelector(".btn_modal").onclick = (e) =>{
        e.preventDefault();
        document.forms["form_editar_banner"].submit();
    };
}

/**
 * Funcion que crea un modal de confirmacion para eliminar un banner, al confirmar se hace una peticion fetch
 * @param {*} id_imagen 
 */

function modalEliminar(id_imagen){
    let modal_contenido = document.createElement("div");
    let titulo_modal = "Eliminar banner";
    let cuerpo_modal = "Este banner ya esta guardado. ¿Deseas eliminarlo totalmente?";
    boton_modal = `<button type="button" class="btn btn-danger btn_modal">Eliminar</button>`;

    modal_contenido.innerHTML = `<div class="modal fade" tabindex="-1">`+
                            `<div class="modal-dialog modal-dialog-centered">`+
                                `<div class="modal-content cuadro_modal">`+
                                    `<div class="modal-header">`+
                                        `<h5 class="modal-title" id="modal_borrarLabel">${titulo_modal}</h5>`+
                                        `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                    `</div>`+
                                    `<div class="modal-body">`+
                                        `${cuerpo_modal}`+
                                    `</div>`+
                                    `<div class="modal-footer">`+
                                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                        `${boton_modal}`+
                                    `</div>`+
                                `</div>`+
                            `</div>`+
                        `</div>`;

    msj_modal.append(modal_contenido);

    let modal = new bootstrap.Modal(modal_contenido.querySelector(".modal"));
    modal.show();

    btn_eliminar_banner = document.querySelector(".btn_modal");
    btn_eliminar_banner.onclick = (e)=>{
        e.preventDefault();
        fetch(`../../php/admin/editarDiseno.php?eliminar=${id_imagen}`)
        .then(res => {
            if(!res.ok) throw new Error("Error al enviar los datos");
        })
        .then(()=>{
            mostrarConfirmacion(2);
        })
        .catch((e) => {
            console.log("Error al borrar banner" + e);
        });
    };
}






/****************************SUBMIT ************************ */
let btn_editarBanner = document.querySelector("#enviar_banner ");

// evento que se dispara cuando se presiona el boton guardar
if(btn_editarBanner){
    btn_editarBanner.onclick =  (e) =>{
        e.preventDefault();
        let invalido = 0;
        // Seleccionamos todas las imagenes que se han cargado en los input file
        let archivo_banner = [...document.querySelectorAll(".input_archivo_banner")];
        // Mediante un ciclo checamos si cumplen con el tamaño establecido, si alguno no cumple, no se muestra
        //el modal de confirmacion, por lo tanto no se pueden guardar los cambios
        for (let i = 0; i < archivo_banner.length; i++) {
            if(archivo_banner[i].files.length > 0){
                if(archivo_banner[i].files[0].size > 2000 * 1024){
                    console.log("Peso excede limite");
                    invalido ++;
                }
            }
        }
        if( invalido == 0){
            mostrarModal();
        }
      
    }
}


/**********************MANEJO DE IMAGENES************ */


let tool_tip = document.querySelectorAll(".tool_tip");
// Creamos un tool tipo para cada input file de imagen
let tool_tip_manejo = [...tool_tip].map((tt)=>{
return new bootstrap.Tooltip(tt);
});

function imagenSeleccion(inputData, numero_imagen){

    let label_texto = document.querySelectorAll(".label_texto"); 
    // Al cargar una imagen, se muesta el nombre y el tamaño
    label_texto[numero_imagen].innerHTML = inputData.files[0].name +" ("+ (inputData.files[0].size/1024/1024).toFixed(2) + " MB)";
    // Si el tamaño es mayor al establecido, se muesta el tooltip y se deshabilita el boton de guardado
    if(inputData.files[0].size > 2000* 1024){
        tool_tip_manejo[numero_imagen].show();
       btn_editarBanner.classList.add("disabled");
    // Si el tamaño es valido, se activa el boton de guardado y se guarda el tooltip en caso de que haya sido mostrado
    // y se muesta la imagen
    }else{
        btn_editarBanner.classList.remove("disabled");
        tool_tip_manejo[numero_imagen].hide();
        document.getElementById(`archivoBanner_img${numero_imagen}`).src = window.URL.createObjectURL(inputData.files[0]);
       
    }
}

/*****************************Agregar otro banner**************** */
let agregar_banner = document.querySelector(".agregar_banner");
// Funcion que se activa cuando se presiona el boton agregar banner
function agregarBanner(){
    // se obtiene el numero de banners que estan siendo mostrados, esta variable permite crear los label y id de acuerdo al numero
    //de banners totales
    let numero_de_banners = [...document.querySelectorAll(".imagen_banner")].length;
    // Creacion del div con los inputs del banner
    let nuevo_banner = document.createElement("div");
    nuevo_banner.classList.add(`nuevo_banner_${numero_de_banners}`);

    nuevo_banner.innerHTML =  `<div class="editar_banner container-fluid " >
                                    <div class="row align-items-center ">
                                        <div class="col-8 mx-auto col-lg-4 pt-3" >
                                            <img src="" alt="Imagen banner" class="w-100 imagen_banner d-block" id="archivoBanner_img${numero_de_banners}">
                                            <label for="archivo_banner${numero_de_banners}" class="btn label_input${numero_de_banners}"><span class="label_texto">Selecciona una imagen  (max.2 MB)</span><i class="ms-2 bi bi-caret-down-square"></i></label>
                                            <span class="tool_tip"  data-bs-placement="right" title="Error: archivo mayor a 2 MB"></span>
                                            <input type="file" style="display:none" accept="image/*" class="input_archivo_banner form-control text-center" id="archivo_banner${numero_de_banners}"name="archivo_banner_nuevo[]" required title="Selecciona una imagen" onchange="imagenSeleccion(this,'${numero_de_banners}')">   
                                        </div>
                                        <div class="col-12 col-lg-8 mt-2 ">
                                            <div class="input-group">
                                                <div class="input-group-text ">Titulo: </div>
                                                <input type="text"   class="form-control fs-5  text-center input_texto " name="titulo_nuevo[]" value="">
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-text ">Descripción:</div>
                                                <input type="text"   class="form-control fs-5  text-center input_texto " name="descripcion_nuevo[]" value="">
                                            </div>
                                        </div>
                                        <div class="col-1 ms-auto me-end mt-2">
                                            <a class="btn btn-outline-danger" onclick="eliminarDiv('${numero_de_banners}')" title="Eliminar banner"><i class="bi bi-trash-fill"></i></a>
                                        </div>
                                    </div>
                                    
                                </div>
                                <hr>`;

    agregar_banner.append(nuevo_banner);
    // Si se crearon nuevos banners, se vuelven a crear los tooltips con los nuevos banners
    tool_tip = document.querySelectorAll(".tool_tip");
    tool_tip_manejo = [...tool_tip].map((tt)=>{
        return new bootstrap.Tooltip(tt);
        
    });
}

/**
 * Funcion para eliminar los divs creados al agregar nuevos banners, como estos no estan guardados en la base, solo
 * se remueven del DOM
 * @param {*} div 
 */
function eliminarDiv(div){
    // La variable div contiene el numero del div creado
    // Si existia un tooltip para ese banner, se esconde
    if(tool_tip_manejo[div]) {tool_tip_manejo[div].hide();  btn_editarBanner.classList.remove("disabled");}
    eliminar = document.querySelector(`.nuevo_banner_${div}`);
    eliminar.remove();
}

// Funciones para limpiar el texto de los inputs al hacerles click
let input_titulo = document.querySelectorAll(".input_titulo");
[...input_titulo].map(i => {
    i.onclick= () => {
    i.value = "";
        
    }
});

let input_desc = document.querySelectorAll(".input_desc");
[...input_desc].map(i => {
    i.onclick= () => {
    i.value = "";
        
    }
});
