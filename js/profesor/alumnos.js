

/**
 * Funcion para cambiar la url y quitar los parametros
 */
function alerta(){
  
    setTimeout(() => {
    history.replaceState(null,null,"../../html/profesor/listaAlumnos.php")
    }, 1000);
    
  
}



 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 */
function mostrarConfirmacion(tipo ,materia) {
    let timerInterval
    let titulo = "";
    if(tipo==2)  titulo = "Actualizando datos"    
    if(tipo==1) titulo = "Dando de baja";
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
        if(tipo==1) location.href = `../../html/profesor/listaAlumnos.php?accion=editar&mensaje=1&materia=${materia}`;
        if (result.dismiss === Swal.DismissReason.timer) {
            console.log('Listo!')
        }
        })
}



// Obtencion de parametros por url
let url = new URLSearchParams(location.search);
let parametro = url.get('mensaje');

if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
if(parametro == 1) alerta('success','bi-check-lg','Solicitu completada','Lista Actualizada');

/**
 * Funcion que muestra modal para dar de baja un alumno de la lista del profesor, al confirmar se hace una peticion fetch
 * @param {*} accion 
 * @param {*} id_alumno 
 * @param {*} id_materia 
 * @param {*} id_profesor 
 * @param {*} materia 
 */

const mostrarModal = function modalShow(accion, id_alumno, id_materia, id_profesor,materia){
    console.log(id_alumno, id_materia, id_profesor, materia);
    let modal_contenido = document.createElement("div");
    let titulo_modal = "";
    let cuerpo_modal = "";
    let boton_modal = "";
    if(accion == "eliminar"){   
        titulo_modal = `Dar de baja Alumno`;
        cuerpo_modal = `Dar de baja permanente al alumno?`;
        boton_modal = `<button type="button" class="btn btn-danger btn_modal">Dar de baja</button>`;
    }


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
                fetch(`../../php/profesor/alumnos.php?id_alumno=${id_alumno}&id_profesor=${id_profesor}&id_materia=${id_materia}&baja=baja`)
                .then(res => {
                    if(!res.ok) throw new Error("Error al enviar los datos");
                    
                })
                .then(() => {
                    mostrarConfirmacion(1,materia);
                })
                .catch((e) => {
                    console.log("Error al borrar alumno" + e);
                })
            }
        })
    }


}

let msj_modal = document.querySelector("#msj_modal");