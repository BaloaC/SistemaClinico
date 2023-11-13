import Cookies from "../../libs/jscookie/js.cookie.min.js";

const path = location.pathname.split('/');

function checkRol(rol) {

    switch (rol) {
        case "1": return ['/home/', '/', '/test'];
        case "2": return ['/home/'];
    }
}

function validateObj(obj) {

    for (let prop in obj) {
        if (obj.hasOwnProperty(prop) && obj[prop] === "" || obj[prop] === undefined) {
            return false
        }
    }
    return true;
}

async function validateSession() {

    try {

        const failedSession = Cookies.get("failedSession");

        // Si la sesión ha fallado mostramos la alerta de mensaje en el login
        if(failedSession === "1"){
            const alert = document.querySelector(".alert");
            alert.textContent = "La sesión no se pudo validar correctamente";
            alert.classList.add("alert-danger");
            alert.classList.remove("d-none");
            return;
        }
        

        const dataUser = {
            usuario_id: Cookies.get("usuario_id"),
            usuario: Cookies.get("usuario"),
            tokken: Cookies.get("tokken"),
            rol: Cookies.get("rol")
        }

        if (validateObj(dataUser) === false) throw { message: "No se ha podido validar la sesión correctamente" };

        console.log(dataUser);
        let response = await fetch(`/${path[1]}/usuarios/${dataUser.usuario_id}`),
            json = await response.json();

        if (!json.code) throw { message: "No se ha podido validar la sesión correctamente" };

        if (json.data.tokken !== dataUser.tokken) throw { message: "No se ha podido validar la sesión correctamente" };

    } catch (error) {

        // Si la ruta no es el login redirigrlo hacia allá
        if(location.pathname !== `/${path[1]}/login`){
            Cookies.set("failedSession", "1");
            location = `/${path[1]}/login`;
        }
    }
}

function logOut() {

    Cookies.remove("usuario_id");
    Cookies.remove("usuario");
    Cookies.remove("tokken");

    location = `/${path[1]}/login`;
}


window.addEventListener("pageshow", () => {

    if(location.pathname !== `/${path[1]}/usuarios/registrar` && location.pathname !==  `/${path[1]}/login/recuperarusuario`){
        validateSession();
    }

    // Si hay sesión activa y regresa al login, redirigimos al usuario para el home
    if((location.pathname === `/${path[1]}/` || location.pathname === `/${path[1]}/login`) && Cookies.get("failedSession") === "0" && Cookies.get("usuario_id")){
        location = `/${path[1]}/home`;
    } 
})

document.addEventListener("click", e => {

    if (e.target.matches("#btn-logout")) {

        e.preventDefault();
        logOut();
    }

})