
// Cambiamos la url actual por la misma url, de esta manera al hacer atras desde inicio no se carga el error de
//envio de formulario
if (window.history.replaceState) { // verificamos disponibilidad
    window.history.replaceState(null, null, window.location.href);
}

document.addEventListener('DOMContentLoaded', function(){ 

    // Obtencion de parametros url
    let url = new URLSearchParams(location.search);
    let param = url.get('mensaje');

    
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

    function alerta(opcion, icono, encabezado, mensaje){

        let msjAlerta = document.querySelector("#msj_alerta");

        msjAlerta.innerHTML = `<div class="alert alert-${opcion} alert-dismissible text-center container_msj " role="alert" >`+ 
        '<button type="button" class="btn-close pb-2 " data-bs-dismiss="alert" aria-label="Close"></button>' +
        `<i class="bi ${icono} d-inline pe-2 fs-4"></i>`+
        `<p class="alert-heading d-inline fs-6">${encabezado}</p>`+ 
        `<p>${mensaje}</p>` +
        '</div>'

        const bsAlerta = new bootstrap.Alert(msjAlerta);

        setTimeout(()=>{
            bsAlerta.close();
            history.replaceState(null,null,"../../html/autenticacion/login.php");
        },4000);

    }
    //  Diferentes opciones de alerta de acuerdo al parametro recibido
    if(param==1) alerta("danger", "bi-exclamation-triangle-fill", "Error al autenticar", "La contraseña es incorrecta");
    if(param==0) alerta("danger", "bi-exclamation-triangle-fill", "Error al autenticar", "El numero de cuenta no esta registrado");
    if(param=="error") alerta("danger", "bi-exclamation-triangle-fill", "Error", "Hubo un error en el sistema, contacta con el desarrollador");


   

});