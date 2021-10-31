
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
    '</div>'
     //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
    const bsAlerta = new bootstrap.Alert(msjAlerta);
    setTimeout(() => {
    bsAlerta.close();
    history.replaceState(null,null,"../../html/admin/editarEncabezado.php")
    }, 3000);
    
}


 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 */
function mostrarConfirmacion() {
    let timerInterval
    let titulo = "Actualizando Encabezado";
    Swal.fire({
        title: titulo,
        html: 'Completando solicitud',
        timer: 600,
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
        location.href = `../../html/admin/editarEncabezado.php?mensaje=5`;
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Listo!')
        }
        })
}
// Obtencion de parametros mediante la url
let url = new URLSearchParams(location.search);
let parametro = url.get('mensaje');
//  Diferentes opciones de alerta de acuerdo al parametro recibido
if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
if(parametro == 5) alerta('success','bi-check-lg','Solicitu completada','Se han actualizado los cambios');
if(parametro == 2) alerta('warning', 'bi-alarm-fill' , 'Tiempo agotado', 'La prueba fue registrada');
if(parametro == 3) mostrarConfirmacion()


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
        let modal = new bootstrap.Modal(modal_contenido.querySelector(".modal"))
        modal.show();
        // Submit
        document.querySelector(".btn_modal").onclick = (e) =>{
            e.preventDefault();
            document.forms["form_editar_encabezado"].submit();
        }
}



/****************************SUBMIT ************************ */
let btn_editarEncabezado = document.querySelector("#enviar_encabezado");
let archivo_encabezado = document.querySelector("#archivo_encabezado");
// Al hacer click en guardar se verifica si se agrego una imagen en el input file,
//si se agrego, se verifica el tamaño, en caso de ser correcto se pasa a la confirmacion del envio,
//Si no se agrego una nueva imagen, no se verifica el tamaño y se muesta la confirmacion del envio
btn_editarEncabezado.onclick =  (e) =>{
    e.preventDefault();
    if(archivo_encabezado.files.length > 0){
        if(archivo_encabezado.files[0].size <= 2000* 1024){
            mostrarModal();
        }
     }else{
        mostrarModal();
     }
    console.log();(seleccionColorFondo.hexString)
}

/******************MANEJO DE IMAGEN ********************* */

//  function archivoEncabezadoUrl(){
//     document.getElementById('archivoEncabezado').click();
// }
let label_texto = document.querySelectorAll(".label_texto");
let nombre_archivo = document.querySelector(".nombre_archivo");
// Creacion del tooltip de bootstrap
let tool_tip = document.querySelector(".tool_tip");
let tool_tip_manejo = new bootstrap.Tooltip(tool_tip);
// Funcion que se usa al seleccionar una imagen
function imagenSeleccion(inputData){
    //Se muestran los datos de la imagen, nombre y tamaño    
    label_texto.innerHTML = inputData.files[0].name +" ("+ (inputData.files[0].size/1024/1024).toFixed(2) + " MB)";
    // Si la imagen es muy grande se muestra el tooltip y se deshabilita el boton de guardar
    if(inputData.files[0].size > 2000* 1024){
        tool_tip_manejo.show();
        btn_editarEncabezado.classList.add("disabled");
    // Si el tamaño es valido, se habilita el boton, se oculta el tooltip y se muestra la imagen
    }else{
        btn_editarEncabezado.classList.remove("disabled");
        tool_tip_manejo.hide();
        document.getElementById('archivoEncabezado_img').src = window.URL.createObjectURL(inputData.files[0])
    }
}

/************MANEJO DE COLORES ********************************************/

let nuevo_color_fondo = document.querySelector(".color_fondo");
let nuevo_color_texto= document.querySelectorAll(".input_texto");
let input_color_fondo = document.querySelector(".input_color_fondo");
let input_color_texto = document.querySelector(".input_color_texto");

// Seleccion  del div en donde se mostrara la barra de colores manejada por iro@5, con el tamaño y color por default
const seleccionColorFondo = new iro.ColorPicker("#seleccion_color_fondo", {
    width:120, 
    color: "#fff"
});

const seleccionColorTexto = new iro.ColorPicker("#seleccion_color_texto", {
    width:120, 
    color: "#fff"
});

// Evento que se dispara al mover la barra de colores, se cambia el color de los divs y se le asigna el valor nuevo
seleccionColorFondo.on("color:change", (color)=>{
    nuevo_color_fondo.style.backgroundColor = color.hexString;
    [...nuevo_color_texto].map((texto)=>{
        texto.style.backgroundColor = color.hexString;
    })
    input_color_fondo.value = color.hexString;
    
    
});

seleccionColorTexto.on("color:change", (color)=>{
    [...nuevo_color_texto].map((texto)=>{
        texto.style.color = color.hexString;
    })
    input_color_texto.value = color.hexString;
    console.log(input_color_texto.value);
   
});
 
let input_titulo = document.querySelector(".input_titulo");
input_titulo.onfocus = () => {
    input_titulo.value = "";
}
let input_desc = document.querySelector(".input_desc");
input_desc.onfocus = () => {
    input_desc.value = "";
}



   