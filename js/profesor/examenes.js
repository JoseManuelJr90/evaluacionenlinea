



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
    '<button type="button" class="btn-close pb-2" data-bs-dismiss="alert" aria-label="Close"></button>' +
    `<i class="bi ${icono} d-inline pe-2"></i>`+
    `<h5 class="alert-heading d-inline">${encabezado}</h5>`+ 
    `<p>${mensaje}</p>` +
    '</div>'
    const bsAlerta = new bootstrap.Alert(msjAlerta);
    //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
    setTimeout(() => {
    bsAlerta.close();
    history.replaceState(null,null,"../../html/profesor/examenes.php")
    }, 5000);
    
  
}
// Obtencion de parametros mediante la url
let url = new URLSearchParams(location.search);
let parametro = url.get('mensaje');
//  Diferentes opciones de alerta de acuerdo al parametro recibido
if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
if(parametro == 1) alerta('success','bi-check-lg','Solicitu completada','Se ha modificado el parcial exitosamente')
if(parametro == 2) alerta('warning', 'bi-alarm-fill' , 'Tiempo agotado', 'La prueba fue registrada');
if(parametro == 3) alerta('success','bi-check-lg','Solicitud completada','Has creado un nuevo parcial, edita para agregar las preguntas.');
if(parametro == 4) mostrarConfirmacion(1)
if(parametro == 5) alerta('danger', 'bi-exclamation-triangle-fill' , 'No has seleccionado una materia', 'selecciona una materia');


/**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 */
function mostrarConfirmacion(tipo , tipo_parcial) {
    let timerInterval
    let titulo = "";
    if(tipo==2) {
        if(tipo_parcial == "publicar") titulo = "Publicando";
        if(tipo_parcial == "ocultar") titulo = "Ocultando";
        if(tipo_parcial == "borrar") titulo = "Borrando";
    }
        
    if(tipo==1) titulo = "Creando";
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
        if(tipo==2) location.href = "../../html/profesor/examenes.php?mensaje=1";
        if(tipo==1) location.href = "../../html/profesor/examenes.php?mensaje=3";
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Listo!')
        }
        })
}

/**
 * Funcion que muestra modal para borrar, publicar u ocultar un parcial, al confirmar se hace una peticion fetch
 * @param {*} tipo_parcial 
 * @param {*} nombre_parcial 
 * @param {*} id_parcial 
 * @param {*} id_profesor 
 */

const mostrarModal = function modalShow(tipo_parcial,nombre_parcial,id_parcial, id_profesor ){
        console.log(nombre_parcial, id_parcial, id_profesor);
        let modal_contenido = document.createElement("div")
        let body_modal="";
        let btn_tipo="";
        let titulo_modal = "";

        if(tipo_parcial =="borrar"){
            titulo_modal = `Borrar parcial`;
            body_modal = `Borrar el parcial: <strong>${nombre_parcial}?</strong>`;
            btn_tipo = `<button type="button" class="btn btn-danger btn_modal">Borrar</button>`;
            
        }
        if(tipo_parcial  == "publicar"){
            titulo_modal = `Publicar parcial`;
            body_modal = `Publicar el parcial: <strong>${nombre_parcial}?</strong>`+
                        `<p>El parcial podra ser accedido por todos los alumnos inscritos a la materia</p>`;
            btn_tipo = `<button type="button" class="btn btn-primary btn_modal">Publicar</button>`;
        }
        if(tipo_parcial  == "ocultar"){
            titulo_modal = `Ocultar parcial`;
            body_modal = `Ocultar el parcial: <strong>${nombre_parcial}?</strong>`+
            `<p>El parcial dejara de estar disponible para los demas</p>`;
            btn_tipo = `<button type="button" class="btn btn-primary btn_modal">Ocultar</button>`;
           
        }

        modal_contenido.innerHTML = `<div class="modal fade" tabindex="-1">`+
                                            `<div class="modal-dialog modal-dialog-centered">`+
                                                `<div class="modal-content cuadro_modal">`+
                                                    `<div class="modal-header">`+
                                                        `<h5 class="modal-title" id="modal_borrarLabel">${titulo_modal}</h5>`+
                                                        `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                                    `</div>`+
                                                    `<div class="modal-body">`+
                                                        `${body_modal}`+
                                                    `</div>`+
                                                    `<div class="modal-footer">`+
                                                        `<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>`+
                                                        `${btn_tipo}`+
                                                    `</div>`+
                                                `</div>`+
                                            `</div>`+
                                        `</div>`;


    msj_modal.append(modal_contenido);

    let modal = new bootstrap.Modal(modal_contenido.querySelector('.modal'));
    modal.show();

    if(document.querySelectorAll(".btn_modal")){
        confirmar_modal = document.querySelectorAll(".btn_modal");
        for(i=0; i<confirmar_modal.length; i++){
            confirmar_modal[i].onclick=(e)=>{
                e.preventDefault();
                fetch(`../../php/profesor/examenes.php?parcial=${id_parcial}&id_profesor=${id_profesor}&tipo_parcial=${tipo_parcial}`)
                .then(res => {
                    if(!res.ok){
                        throw new Error("Error al enviar los datos de borrado");
                        
                    } 
                    return res            
                })
                .then(()=>{
                    
                    mostrarConfirmacion(2, tipo_parcial);
                })
                .catch(error=>{
                    console.log('Error al mostrar los datos' + error);
                }) 
            }
        }


    }


}


/**
 * Funcion que activa un modal cuando no se selecciona una materia en el select del modalP que se crea en la funcion
 * crearParcial.
 * Cuando se da click en el boton cerrar, se vuelve a activar la funcion crearParcial
 * @param {*} modalP 
 * @param {*} id_profesor 
 */
function modalNoMateria(modalP,id_profesor){
    modalP.hide();
    var modal_no_materia = ""
    modal_no_materia +=   `<div class="modal fade" tabindex="-1">`+
                        `<div class="modal-dialog modal-dialog-centered">`+
                            `<div class="modal-content cuadro_modal">`+
                                `<div class="modal-header">`+
                                    `<h5 class="modal-title" id="modal_borrarLabel">Selecciona una materia</h5>`+
                                    `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                `</div>`+
                                `<div class="modal-body">`+
                                    `No has seleccionado una materia`+
                                `</div>`+
                                `<div class="modal-footer">`+
                                `<button type="button" class="btn btn-secondary btn_continuar" data-bs-dismiss="modal">Cerrar</button>`+
                                `</div>`+
                            `</div>`+
                        `</div>`+
                    `</div>`;

    modal_no.innerHTML = modal_no_materia;

    var modalm = new bootstrap.Modal(modal_no.querySelector('.modal'));
    modalm.show();
    // Cuando se da click en el boton cerrar, se vuelve a activar la funcion crearParcial
    var btn_continuar = document.querySelector(".btn_continuar")
        btn_continuar.onclick = (e =>{
            e.preventDefault();
            crearParcial(id_profesor)
        })
    }

/**
 * Funcion que hace una peticion fetch para obtener las materias asignadas al profesor y mostrarlas en las opciones,
 * se crea un modal con los inputs de los datos del nuevo parcial, al confirmar se hace submit
 * @param {*} id_profesor 
 */   
const crearParcial = function nuevoParcial(id_profesor){
    console.log(id_profesor)
    fetch(`../../php/profesor/crearEditarExamen.php?obtener=obtener&id_profesor=${id_profesor}`)
    .then((res)=>{
        if(!res.ok) throw new Error("Error al obtener la materias")
        return res.json();
    })
    .then((datos)=>{
        var modalParcial = ""
        if(datos.data.length > 0){
            modalParcial += `<div class="modal fade" id="modal_crear" tabindex="0">`+
                                `<div class="modal-dialog modal-dialog-centered modal-xl">`+
                                    `<div class="modal-content cuadro_modal">`+
                                        `<div class="modal-header">`+
                                            `<h5 class="modal-title" id="modal_borrarLabel">Nuevo Parcial</h5>`+
                                            `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                        `</div>`+
                                        `<div class="modal-body">`+
                                            `<form action="../../php/profesor/crearEditarExamen.php" method="post" id="form_crear">`+
                                                `<input type="hidden" name="crear" value="crear">`+
                                                `<input type="hidden" name="id_maestro" value="${datos.data[0].id_maestro}">`+
                                                `<div class="d-flex row justify-content-center pb-3">`+
                                                    `<div class="col-10 col-lg-2 me-3 mb-3 "  >`+
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
                                                    `<div class="col-10 col-lg-4 me-2 mb-3">`+
                                                    `<label for="input_nombre_parcial" class=" col-form-label ">Nombre parcial: </label>`+
                                                        `<div class="input-group">`+
                                                        `<div class="input-group-text"><i class="bi bi-pencil-square"></i></div>`+
                                                            `<input type="text" required class="form-control input_nombre_parcial" name="nombre_parcial">`+ 
                                                            `</div>`+
                                                        `</div>`+
                                                    `<div class="col-5 col-lg-2 me-2">`+
                                                    `<label for="input_numero_parcial" class=" col-form-label ">Numero parcial: </label>`+
                                                        `<div class="input-group">`+
                                                        `<div class="input-group-text ">#</div>`+
                                                            `<input type="text" required class="form-control input_numero_parcial" style="max-width: 150px" pattern="^[0-9]*$" maxlength="2" name="numero_parcial"> `+
                                                            `</div>`+
                                                        `</div>`+
                                                    `<div class="col-5 col-lg-3 ">`+
                                                    `<label for="input_duracion_parcial" class=" col-form-label ">Duracion parcial: </label>`+
                                                        `<div class="input-group">`+
                                                        `<div class="input-group-text "><i class="bi bi-stopwatch"></i></div>`+
                                                            `<input type="text" required class="form-control input_duracion_parcial" style="max-width: 70px" pattern="^[0-9]*$" maxlength="3" name="duracion_parcial"> `+
                                                            `<div class="input-group-text ">minutos</div>`+
                                                            ` </div>`+
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

        }else{
            modalParcial= `<div class="modal fade" tabindex="-1">`+
                                        `<div class="modal-dialog modal-dialog-centered">`+
                                            `<div class="modal-content cuadro_modal">`+
                                                `<div class="modal-header">`+
                                                    `<h5 class="modal-title" id="modal_borrarLabel">No tienes materias asignadas</h5>`+
                                                    `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                                `</div>`+
                                                `<div class="modal-body">`+
                                                    `Contacta al administrador para que te asignen materias`+
                                                `</div>`+
                                                `<div class="modal-footer">`+
                                                `<button type="button" class="btn btn-secondary btn_continuar" data-bs-dismiss="modal">Cerrar</button>`+
                                                `</div>`+
                                            `</div>`+
                                        `</div>`+
                                    `</div>`;
        }

        return modalParcial;
    
    }).then(modalParcial => {

        crear_modal.innerHTML = modalParcial
        let modalP = new bootstrap.Modal(crear_modal.querySelector(".modal"));
        modalP.show();

        let btn_crear = document.querySelector(".btn_crear");
        btn_crear.onclick = (e =>{
            let nulos = 0;
            e.preventDefault();
            // Validamos que todos ni un input este vacio, de lo contrario se muestra la alerta
            // Js del required ya que estamos manejando onclick y no submit
            // y se aumenta la variable nulos, la cual no permitira que se haga el submit si no se han llenado
            //todos los campos
            [...document.querySelectorAll("INPUT")].map(i => {
                if(i.value=="" || !i.checkValidity()){
                    i.reportValidity();
                    nulos ++ ;
                }
            });
            // Si se dejo el valor del select por default, se muestra el modal de la funcion modalNoMateria y
            //no se permite continuar
            if(document.querySelector(".input_materia").value == "Selecciona la materia"){ 
                modalNoMateria(modalP,id_profesor);
            }else if(nulos == 0){
                document.forms["form_crear"].submit();
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

        
        
        




