

document.addEventListener('DOMContentLoaded', function(){ 
    
    let navbar = document.querySelector(".header_inner");
    
    if(navbar){
        
        //Mediante el evento scroll, podemos pocicionar el navbar fixed para que siempre este visible en la parte superior
        //agregandole clases que mediante css cambian el estilo del navbar 
        window.addEventListener('scroll', function() {
            console.log(window.pageYOffset)
            let scrollPosition = window.pageYOffset;
            if (scrollPosition >= 220) {
                navbar.classList.add("navbar_scroll");
            } else {
                navbar.classList.remove("navbar_scroll");
              
            }
        });
    }


}, false);