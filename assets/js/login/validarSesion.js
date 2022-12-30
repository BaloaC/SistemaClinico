import Cookies from "../js.cookie.min.js";

const path = location.pathname.split('/');

function checkRol(rol){

    switch(rol){
        case "1": return ['/home/', '/', '/test']; 
        case "2": return ['/home/'];
    }
}

async function validateSession() {

    try {

        const dataUser = {
            usuario_id: Cookies.get("usuario_id"),
            usuario: Cookies.get("usuario"),
            tokken: Cookies.get("tokken"),
            rol: Cookies.get("rol")
        }

        let response = await fetch(`/${path[1]}/usuarios/consulta/${dataUser.usuario_id}`),
            json = await response.json();

        if (!json.code) throw { message: "No se ha podido validar la sesión correctamente" };

        if (json.data.tokken !== dataUser.tokken) throw { message: "No se ha podido validar la sesión correctamente" };

        const routes = checkRol(dataUser.rol);

        if(!routes.find(route => route !== path[2])) throw { message: "No es posible acceder a la página solicitada" }

        // alert('Sesion validada correctamente');

    } catch (error) {

        alert(error.message);
        location = `/${path[1]}/login`;
    }
}

function logOut(){

    Cookies.remove("usuario_id");
    Cookies.remove("usuario");
    Cookies.remove("tokken");

    location = `/${path[1]}`;
}


document.addEventListener("DOMContentLoaded", e => {

    validateSession();
})

document.addEventListener("click", e => {

    if(e.target.matches("#btn-logout")){

        e.preventDefault();
        logOut();
    }

})