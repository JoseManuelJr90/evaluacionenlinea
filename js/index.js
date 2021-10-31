document.addEventListener('DOMContentLoaded', function(){ 

    
    function cerrarSesion(){
        window.location = "php/autenticacion/logoutIndex.php";
    }
    let banner_btn = document.querySelector(".banner_btn");

    banner_btn.onclick = (e)=>{
        console.log("Click");
        cerrarSesion();
    }

})