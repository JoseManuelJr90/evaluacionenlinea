document.addEventListener('DOMContentLoaded', function(){ 

    
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
        history.replaceState(null,null,"../../html/alumno/inscribirMateria.php")
        }, 5000);
        
      
    }

    
    /**
     * Funcion que muestra el estado de carga al realizar una accion
     * utilizando sweet alert
     * 
     * Despues de mostrar el estado de carga, se envia el submit
     * 
     */
    function mostrarConfirmacion(form_submit) {

        Swal.fire({
            title: 'Confirmacion',
            text: `Deseas inscribir la materia: "${form_submit.elements.nombre_materia.value}" con "${form_submit.elements.nombre_maestro.value}"`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#4A648A',
            
          }).then((result) => {
            if (result.isConfirmed) {
              
              form_submit.submit();
            }
          })
       
        
    }

    // Obtencion de parametros url
    let url = new URLSearchParams(location.search);
    let parametro = url.get('mensaje');

    //  Diferentes opciones de alerta de acuerdo al parametro recibido
    if(parametro == 'error') alerta('danger', 'bi-exclamation-triangle-fill' , 'Ha ocurrido un error', 'Contacta con el desarrollador');
    if(parametro == 1) alerta('success','bi-check-lg','Terminado','Tu participacion se ha registrado correctamente')
    if(parametro == 2) alerta('warning', 'bi-alarm-fill' , 'Tiempo agotado', 'La prueba fue registrada');
    if(parametro == 3) alerta('success','bi-check-lg','Solicitud completada','Tu solicitud fue enviada, espera a que sea aceptada o rechazada');
    
    // buscar materia

    const resultados = document.querySelector('.mostrar_busqueda');
    const alumno = document.querySelector('#id_alumno');
    const cuenta_alumno = document.querySelector('#numero_cuenta');

    // Cuando se ingresan caracteres en el search bar, se hace una peticion fetch, con la cual se hace una consulta
    // a la base de datos buscando coincidencias de materias con la cadena ingresada.
    barra_buscar.onkeyup = (event) => {
        if(event.target.value==""){
            document.querySelector("#output").innerHTML = "";
        } 
        else{   
            fetch(`../../php/Materias/materias.php?alumno_id=${alumno.value}&nombre_materia=${event.target.value}%`)
            .then(res => {
                if(!res.ok) {
                    throw new Error('Error en la respuesta'); 
                }
                return res.json();              
            })
            .then(datos => {
                let html = ""
                // Si se encuentran coincidencias en la base, se muestran los datos obtenidos
                // De acuerdo a la columna estado obtenida, se mostraran los distintos estados de la solicitud
                // Si no se tiene ni un estado, se añade un boton para poder enviar la solicitud
                if(datos.data.length > 0){
                    for (let i = 0; i< datos.data.length; i++) {
                        html += `<tr><td class="ms-3">${datos.data[i].maestro} ${datos.data[i].paterno_maestro} ${datos.data[i].materno_maestro}</td>`+
                                `<td class="mt-2">${datos.data[i].materia}</td> ` +
                                `<td class="ms-3">` 
                                if(datos.data[i].estado === "pendiente" || datos.data[i].estado == "inscrito"){
                                  html+= `<span class="text-secondary">${datos.data[i].estado}</span> `
                                    
                                }else if(datos.data[i].estado === "rechazado"){
                                    html+= `<span class="text-danger">Rechazado</span> `
                                    
                                }
                                else{
                                    html+= `<form id="formRegistro${i}"class="formRegistro" action="../../php/Materias/materias.php" method="post"> `+
                                    `<button class="btn btn_inscribirse" value="${i}">`+
                                        `Inscribirse `+
                                    `</button>`+
                                    `<input type="hidden" class="id_btn" name="id_btn" value="${i}">`+
                                    `<input type="hidden" name="id_alumno" value="${alumno.value}">`+
                                    `<input type="hidden" name="cuenta_alumno" value="${cuenta_alumno.value}">`+
                                    `<input type="hidden" name="id_materia" value="${datos.data[i].id_materia}">`+
                                    `<input type="hidden" name="id_maestro" value="${datos.data[i].id_maestro}">`+
                                    `<input type="hidden" name="nombre_maestro" value="${datos.data[i].maestro} ${datos.data[i].paterno_maestro}">`+
                                    `<input type="hidden" name="nombre_materia" value="${datos.data[i].materia}">`+
                                    `</form>`
                                    
                                }
                                
                        html += `</td>`+
                                `</tr>`    
                    }
                }else{
                    html=`<tr><td colspan="3"> No hay resultados</td></tr>`
                }
                document.querySelector("#output").innerHTML = html;
                

            }).then(()=>{
                

                if(document.querySelectorAll(`.btn_inscribirse`)){
                    confirmarRegistro = document.querySelectorAll(".btn_inscribirse");
                 
                    for(let j=0; j<confirmarRegistro.length; j++){
                        confirmarRegistro[j].onclick = (e) =>{                         
                            e.preventDefault();
                            mostrarConfirmacion(document.forms[`formRegistro${confirmarRegistro[j].value}`])                                              
                        }              
                    }
                }          
            })
            .catch(error=>{
                console.log('Error al mostrar los datos' + error);
            })            
        }       
    }

});