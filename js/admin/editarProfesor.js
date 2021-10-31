
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
 
     const bsAlerta = new bootstrap.Alert(msjAlerta);
 
    //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
     setTimeout(() => {
     bsAlerta.close();
     history.replaceState(null,null,`../../html/admin/editarProfesor.php?num=${cuenta}`)
     }, 1500);
     
   
 }

 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 */
function mostrarConfirmacion(tipo) {
    let timerInterval
    let titulo = "";
    if(tipo == 2)  titulo = "Removiendo materia";
    else  titulo = "Asignando Materia";
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
        if(tipo == 2) location.href = location.href;
        else location.href = `../../html/admin/editarProfesor.php?num=${cuenta}&mensaje=6`;
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Listo!')
        }
        })
}

// Obtencion de parametros mediante la url
let url = new URLSearchParams(location.search);
let parametro = url.get('mensaje');
let cuenta = url.get('num');
//  Diferentes opciones de alerta de acuerdo al parametro recibido
if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
if(parametro == 1) alerta('danger', 'bi-exclamation-triangle-fill' , 'Cuenta registrada', 'El numero de cuenta ya esta registrada');
if(parametro == 0) alerta('danger', 'bi-exclamation-triangle-fill' , 'Email registrado', 'El Email ya esta registrado');
if(parametro == 2) mostrarConfirmacion()
if(parametro == 3) alerta('success','bi-check-lg','Solicitu completada','Se ha registrado al profesor');
if(parametro == 4) alerta('success','bi-check-lg','Solicitu completada','Se ha eliminado al profesor');
if(parametro == 5) mostrarConfirmacion();
if(parametro == 6) alerta('success','bi-check-lg','Solicitu completada','Se ha asignado la materia');




/**
 * Funcion que crea un modal para guardar los cambios realizados, al confirmar se hace una peticion fetch
 * @param {*} accion 
 * @param {*} id_materia 
 * @param {*} nombre 
 * @param {*} id_profesor 
 */
function mostrarModal(accion, id_materia, nombre, id_profesor){
    console.log(id_materia, nombre, id_profesor);
    let modal_contenido = document.createElement("div");
    let titulo_modal = "Remover materia";
    let cuerpo_modal = `El profesor no seguira impartiendo la materia "${nombre}". ¿Deseas continuar?`;
    boton_modal = `<button type="button" class="btn btn-danger btn_modal">Continuar</button>`;

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

    if(document.querySelectorAll(".btn_modal")){
        [...document.querySelectorAll(".btn_modal")].map(btn => {
            btn.onclick = (e) => {
                e.preventDefault();
                fetch(`../../php/admin/editarProfesor.php?remover=${id_materia}&profesor=${id_profesor}`)
                .then(res => {
                    if(!res.ok) throw new Error("Error al enviar los datos");
                })
                .then(()=>{      
                    mostrarConfirmacion(2);
                })
                .catch((e) => {
                    console.log("Error al borrar materia" + e);
                })
            }
        })
    }
}

/**
 * Function para vincular una materia al profesor, mediante su id se busca cuales son las materias que NO tiene
 * asignadas y se muestran en un modal, al seleccionar una materia y confirmar se hace un submit al form
 * @param {*} id_profesor 
 * @param {*} numero_cuenta 
 */

function asignarMateria(id_profesor, numero_cuenta){
    fetch(`../../php/admin/editarProfesor.php?asignar=1&profesor=${id_profesor}`)
    .then((res)=>{
        if(!res.ok) throw new Error("Error al obtener la materias")
        return res.json();
    })
    .then((datos)=>{
        if(datos.data.length > 0){
            var modalParcial = ""
            modalParcial += `<div class="modal fade" id="modal_crear" tabindex="0">`+
                                `<div class="modal-dialog modal-dialog-centered modal-md">`+
                                    `<div class="modal-content cuadro_modal">`+
                                        `<div class="modal-header">`+
                                            `<h5 class="modal-title" id="modal_borrarLabel">Nuevo Parcial</h5>`+
                                            `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                        `</div>`+
                                        `<div class="modal-body">`+
                                            `<form action="../../php/admin/editarProfesor.php" method="post" id="form_agregar">`+
                                                `<input type="hidden" name="agregar" value="agregar">`+
                                                `<input type="hidden" name="id_profesor" value="${id_profesor}">`+
                                                `<input type="hidden" name="numero_cuenta" value="${numero_cuenta}">`+
                                                `<div class="d-flex row justify-content-center pb-3">`+
                                                    `<div class="col-10 col-lg-10 me-3 mb-3 "  >`+
                                                        `<label for="input_materia" class="col-form-label ">Materia: </label>`+
                                                            `<div class="input-group select_materia ">`+
                                                                `<select required class="form-select input_materia" name="datos_materia">`+
                                                                    `<option selected>Selecciona la materia</option>`
                                                                    for(i=0; i<datos.data.length; i++){ 
                                                                        modalParcial +=   `<option value=${datos.data[i].id_materia}|${datos.data[i].nombre_materia}>${datos.data[i].nombre_materia}</option>`  
                                                                    }
                            modalParcial +=                     `</select>`+
                                                            `</div> `+      
                                                    `</div>`+
                                                `</div>`+    
                                                `<div class="modal-footer">`+
                                                    `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                                    `<button type="submit" class="btn btn-primary btn_crear">Guardar</button>`+
                                                `</div>`+
                                            `</form>`+
                                        `</div>`+
                                    `</div>`+
                                `</div>`+
                            `</div>`;
            return modalParcial;
        }else{
            document.querySelector(".btn_asignar").innerHTML = "No hay materias por asignar"
        }    
    })
    .then(modalParcial => {

        crear_modal.innerHTML = modalParcial
        let modalP = new bootstrap.Modal(crear_modal.querySelector(".modal"));
        modalP.show();

        let btn_crear = document.querySelector(".btn_crear");
        btn_crear.onclick = (e =>{
            e.preventDefault();
            // Si en el select, no se selecciono una materia, se muesta el cuadro en rojo
            if(document.querySelector(".input_materia").value == "Selecciona la materia"){
               document.querySelector(".input_materia").style.borderColor = "red";
               document.querySelector(".input_materia").style.boxShadow = "0px 0px 10px red";
            // Si se selecciono una materia, se hace el submit
            }else {      
                document.forms["form_agregar"].submit();
            }
            
            
        })

    })
    .catch(error=>{
        console.log('Error al mostrar los datos' + error);
    }) 

}


let msj_modal = document.querySelector("#msj_modal")
let modal_no = document.querySelector("#msj_modal")
let crear_modal = document.querySelector("#crear_modal")