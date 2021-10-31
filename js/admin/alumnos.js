$(document).ready(function() {
   
    // MANEJO DE DATATABLES
    tabla=$('#tabla_alumnos').dataTable({
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
            url: '../../php/admin/editarAlumno.php?listar=listar',
            type : "get",
            dataType : "json",
            error: function(e){
                console.log(e.responseText);	
            }
        },
		"bDestroy": true,
		"responsive": true, // Responsivo
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
     
     `<i class="bi ${icono} d-inline pe-2"></i>`+
     `<h5 class="alert-heading d-inline">${encabezado}</h5>`+ 
     `<p>${mensaje}</p>` +
     '</div>'
     const bsAlerta = new bootstrap.Alert(msjAlerta);
    //  Tiempo para que desaparesca la alerta y quitamos los parametros de la url
     setTimeout(() => {
     bsAlerta.close();
     history.replaceState(null,null,"../../html/admin/alumnos.php")
     }, 1500);
     
   
 }
 
/**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 * 
 * AQUI SE HACE EL RELOAD DEL DATATABLE
 * @param {*} tipo 
 */
 function mostrarConfirmacion(tipo) {
     let timerInterval
     let titulo = "";
     if(tipo == 2)  titulo = "Eliminando al alumno";
     else  titulo = "Registrando al alumno";
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
         if(tipo == 2) $("#tabla_alumnos").DataTable().ajax.reload(); 
         else location.href = `../../html/admin/alumnos.php?mensaje=3`;
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
 if(parametro == 3) alerta('success','bi-check-lg','Solicitu completada','Se ha registrado al alumno');
 if(parametro == 4) alerta('success','bi-check-lg','Solicitu completada','Se ha eliminado al alumno');
 if(parametro == 5) alerta('success','bi-check-lg','Solicitu completada','Se han completado los cambios');
 
 
/**
 * Funcion que crea un modal para confirmar una accion como submit o delete mediante fetch
 * 
 * @param {*} accion 
 * @param {*} id 
 * @param {*} nombre 
 */

function mostrarModal(accion, id,nombre){
    console.log(id);
    
    let modal_contenido = document.createElement("div");
    // Opciones de los elementos del modal
    let titulo_modal = "Eliminar alumno";
    let cuerpo_modal = `Eliminaras al alumno "${nombre}", asi como los registros con sus profesores y materias. ¿Deseas eliminarlo?`;
    let boton_modal = `<button type="button" class="btn btn-danger btn_modal">Eliminar</button>`;
    // Creacion del modal
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
    //Verifica que exista el boton de confirmacion del modal
    if(document.querySelectorAll(".btn_modal")){
        //Para cada uno de los botones creados, se crea un evento click
        [...document.querySelectorAll(".btn_modal")].map(btn => {
            btn.onclick = (e) => {
                e.preventDefault();
                fetch(`../../php/admin/editarAlumno.php?eliminar=${id}`)
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