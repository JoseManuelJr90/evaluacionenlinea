


document.addEventListener('DOMContentLoaded', function(){ 


    
     
 /**
 * Funcion que muestra el estado de carga al realizar una accion
 * utilizando sweet alert
 * 
 * UNA VEZ QUE SE MUESTRA LA ALERTA SE ENVIA el FORM
 * */
    function mostrarAviso(form, tipo) {

        if(tipo==1){
            Swal.fire({
                icon: 'success',
                title: 'Confirmado',
                showConfirmButton: false,
                timer: 1500   
            }).then(()=>{
                form.submit();
            })
        }
        if(tipo == 2){
            Swal.fire({
                icon: 'warning',
                title: 'Tiempo agotado',
                showConfirmButton: false,
                timer: 1500     
            }).then(()=>{
                form.submit();
            })
        }
    }





    // Temporizador de examen
    //Se hace una peticion XMLHttp a timer.php, el cual hace el calculo del tiempo con la variable de session inicio
    //cada que se accede a el se le resta 1 segundo, la convierte en formato mm:ss y nos regresa el valor para imprimirlo
    function timer(){
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET","../../php/timer.php",false);
        xmlhttp.send(null);
        console.log(xmlhttp.responseText);
        var tiempoTexto = document.getElementById("timer_examen");
        // Cuando queda menos de un minuto, el tiempo se pone rojo
        if(xmlhttp.responseText <= '00:00:55'){
           tiempoTexto.style.color = 'red';
         }
        //  Cuando nos retorna la cadea fin, se llama a la funcion de stop
        if(xmlhttp.responseText == "Fin"){
            stopTimer();
        }
        // Se imprime en pantalla la respuesta
        tiempoTexto.innerHTML = xmlhttp.responseText;
    }
    
    // Funcion de stop del timer
    function stopTimer(){
        clearInterval(x);        
        // Si se llego a esta funcion, quiere decir que el tiempo se agoto, por lo tanto se crea un input hidden
        //Que sera enviado en el form con el valor de 1, de esta manera se sabra que fue por tiempo.
        let tiempo_agotado = document.createElement("input");
        tiempo_agotado.setAttribute("type", "hidden");
        tiempo_agotado.setAttribute("name", "tiempo_agotado");
        tiempo_agotado.setAttribute("value", "1");
        form.appendChild(tiempo_agotado);
        mostrarAviso(form,2)
    }
    // Llamamos a la funcion timer para que se ejecute cada segundo el XMLHttp request
    var x = setInterval(timer, 1000);

    let form = document.forms["form_examen"];
    let btn_enviar = document.querySelector("#enviar_examen");
    // Evento que muesta la alerta y luego envia el form cuando se da click en el boton de enviar
    btn_enviar.onclick = (e) =>{
        e.preventDefault();
        mostrarAviso(form, 1);

    }


     /**
      * Manejo del navbar
      */
    let navbar = document.querySelector(".nav_statica");
    let opciones = document.querySelectorAll(".nav_scroll");
    let tiempo = document.querySelector(".tiempo_texto");

    //Mediante el evento scroll, podemos pocicionar el navbar debajo de la pagina cuando se navega hacia abajo
    //para que siempre este visible el tiempo    
    window.addEventListener('scroll', function() {
        console.log(window.pageYOffset)
        let scrollPosition = window.pageYOffset;
        // Cuando se navega hacia abajo, se agregan las clases que mantienen el navbar al final de la pagina
        if (scrollPosition >= 200) {
            navbar.classList.add("navbar_scroll");
            tiempo.classList.add("nav_border_scroll");
            opciones.forEach(opcion => {
                opcion.classList.add("nav_texto_scroll");
                
            });
          
        // Si se esta en la posicion 0, se quitan las clases para que el nav se mantenga normal
        } else {
            navbar.classList.remove("navbar_scroll");
            tiempo.classList.remove("nav_border_scroll");
            opciones.forEach(opcion => {
                opcion.classList.remove("nav_texto_scroll");
                
            });
          
        }
    });

}, false);