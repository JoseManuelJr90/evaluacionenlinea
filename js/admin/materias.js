$(document).ready(function() {
   
    // MANEJO DE DATATABLES
    tabla=$('#tabla_materias').dataTable({
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
        language: {
            url: '../../includes/Spanish_Mexico.json'
        },
	    // buttons: [
		//             'copyHtml5',
		//             'excelHtml5',
		//             'csvHtml5',
		//             'pdf'
		//         ],
        "ajax":{
            url: '../../php/admin/editarMateria.php?listar=listar',
            type : "get",
            dataType : "json",
            error: function(e){
                console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"responsive": true,
		"bInfo":true,
		"iDisplayLength": 10,//Por cada 10 registros hace una paginación
	    "order": [[ 0, "asc" ]],//Ordenar (columna,orden)
	    "language": {
            "sProcessing":     "Procesando...",
            "sLengthMenu":     "Mostrar _MENU_ registros",
            "sZeroRecords":    "No se encontraron resultados",
            "sEmptyTable":     "Ningún dato disponible en esta tabla",
            "sInfo":           "Mostrando un total de _TOTAL_ registros",
            "sInfoEmpty":      "Mostrando un total de 0 registros",
            "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix":    "",
            "sSearch":         "Buscar:",
            "sUrl":            "",
            "sInfoThousands":  ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst":    "Primero",
                "sLast":     "Último",
                "sNext":     "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
		}
	}).DataTable();
} );



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
    history.replaceState(null,null,"../../html/admin/materias.php")
    }, 2500);
    
  
}

 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 * AQUI SE HACE EL RELOAD DEL DATATABLE
 */

function mostrarConfirmacion(tipo) {
    let timerInterval
    let titulo = "";
    if(tipo == 2)  titulo = "Eliminando materia";
    else  titulo = "Registrando materia";
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
        if(tipo == 2) $("#tabla_materias").DataTable().ajax.reload(); 
        else location.href = `../../html/admin/materias.php?mensaje=3`;
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
if(parametro == 1) alerta('danger', 'bi-exclamation-triangle-fill' , 'Cuenta registrada', 'El numero de cuenta ya esta registrada');
if(parametro == 0) alerta('danger', 'bi-exclamation-triangle-fill' , 'Email registrado', 'El Email ya esta registrado');
if(parametro == 2) mostrarConfirmacion()
if(parametro == 3) alerta('success','bi-check-lg','Solicitu completada','Se ha registrado al profesor');
if(parametro == 4) alerta('success','bi-check-lg','Solicitu completada','Se ha eliminado al profesor');
if(parametro == 5) alerta('success','bi-check-lg','Solicitu completada','Se ha registrado la materia');


/**
 * Funcion que crea un modal para eliminar la materia, al confirmar se hace una peticion fetch
 * @param {*} accion 
 * @param {*} id 
 * @param {*} nombre 
 */

function mostrarModal(accion, id,nombre){
    console.log(id);
    let modal_contenido = document.createElement("div");
    let titulo_modal = "Eliminar materia";
    let cuerpo_modal = `Eliminaras la materia: "${nombre}". Profesores y alumnos ya no podran continuar trabajando con esta materia. ¿Deseas eliminarla?`;
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
    let modal = new bootstrap.Modal(modal_contenido.querySelector(".modal"))
    modal.show();

    if(document.querySelectorAll(".btn_modal")){
        [...document.querySelectorAll(".btn_modal")].map(btn => {
            btn.onclick = (e) => {
                e.preventDefault();
                fetch(`../../php/admin/editarMateria.php?eliminar=${id}`)
                .then(res => {
                    if(!res.ok) throw new Error("Error al enviar los datos");
                    
                })
                .then(()=>{
                    modal.hide();
                    mostrarConfirmacion(2);
                })
                .catch((e) => {
                    console.log("Error al borrar banner" + e);
                })
            }
        })

    }
   
}

/**
 * Funcion que crea un modal con los inputs nombre y id para agregar la nueva materia
 */

function agregarMateria(){
            var modalParcial = ""
            modalParcial += `<div class="modal fade" id="modal_crear" tabindex="0">`+
                                        `<div class="modal-dialog modal-dialog-centered modal-md">`+
                                            `<div class="modal-content cuadro_modal">`+
                                                `<div class="modal-header">`+
                                                    `<h5 class="modal-title" id="modal_borrarLabel">Nueva Materia</h5>`+
                                                    `<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>`+
                                                `</div>`+
                                                `<div class="modal-body">`+
                                                    `<form action="../../php/admin/editarMateria.php" method="post" id="form_agregar">`+
                                                        `<input type="hidden" name="agregar" value="agregar">`+
                                                        `<div class="col-12 ">`+
                                                            `<div class="text-center mensaje text-danger" >`+
                                                          
                                                            `</div>`+
                                                        `</div>`+  
                                                        
                                                        `<div class="col-12 me-2">`+
                                                            `<label for="input_nombre_materia" class=" col-form-label ">Nombre de la materia: </label>`+
                                                            `<div class="input-group">`+
                                                                `<div class="input-group-text"><i class="bi bi-pencil-square"></i></div>`+
                                                                `<input type="text" required class="form-control input_modal input_nombre_materia" name="nombre_materia">`+ 
                                                            `</div>`+
                                                        `</div>`+  
                                                        `<div class="col-12 me-2">`+
                                                            `<label for="input_id_materia" class=" col-form-label ">Id de la materia: </label>`+
                                                            `<div class="input-group">`+
                                                                `<div class="input-group-text"><i class="bi bi-pencil-square"></i></div>`+
                                                                `<input type="text" required class="form-control input_modal input_id_materia" name="id_materia">`+ 
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

        crear_modal.innerHTML = modalParcial
        let modalP = new bootstrap.Modal(crear_modal.querySelector(".modal"));
        modalP.show();

        let btn_crear = document.querySelector(".btn_crear");
        // Al hacer click en la confirmacion verifica que todos los campos sean llenados, en caso de no
        //muestra la alerta js definida en los required ya que se esta manejando el evento onclick y no submit
        //y se aumenta la variable nulos, la cual no permitira enviar la peticion fetch para continuar
        btn_crear.onclick = (e =>{
            let nulos = 0;
            e.preventDefault();
            let mensaje = document.querySelector(".mensaje")
            let nombre = document.querySelector(".input_nombre_materia").value;
            let id = document.querySelector(".input_id_materia").value;
            [...document.querySelectorAll(".input_modal")].map(i => {
                if(i.value==""){
                    i.reportValidity();
                    nulos ++ ; 
                }
            });
            console.log(nombre, id);
            // Si los dos campos fueron llenados, se envia una peticion fetch para verificar que el nombre de 
            //la materia y el id no esten guardados ya en la base
            if(nulos == 0){
                fetch(`../../php/admin/editarMateria.php?comparar=1&nombre=${nombre}&id=${id}`)
                .then((res)=>{
                    if(!res.ok) throw new Error("Error al obtener la materias");
                    return res.json();
                })
                .then((datos)=>{
                    if(datos.data[0].valor == "ambos") mensaje.innerHTML = "Este nombre y ID ya estan registrados"
                    if(datos.data[0].valor == "nombre") mensaje.innerHTML = "Este nombre ya esta registrado"
                    if(datos.data[0].valor == "id") mensaje.innerHTML = "Este ID ya esta registrado"
                    // Si no estan guardados en la base, se hace el submit
                    if(datos.data[0].valor == "no") document.forms["form_agregar"].submit();
                    
                })
                .catch(error=>{
                    console.log('Error al mostrar los datos' + error);
                }) 
                
            }
            
            
        })

   

}

let msj_modal = document.querySelector("#msj_modal")
let modal_no = document.querySelector("#msj_modal")
let crear_modal = document.querySelector("#crear_modal")