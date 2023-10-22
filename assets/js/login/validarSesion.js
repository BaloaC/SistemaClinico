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

        alert(error.message)
        location = `/${path[1]}/login`;
    }
}

function logOut() {

    Cookies.remove("usuario_id");
    Cookies.remove("usuario");
    Cookies.remove("tokken");

    location = `/${path[1]}/login`;
}


document.addEventListener("DOMContentLoaded", e => {

    if(location.pathname !== `/${path[1]}/login` && location.pathname !== `/${path[1]}/usuarios/registrar` && location.pathname !==  `/${path[1]}/login/recuperarusuario`){
        validateSession();
    }
})

document.addEventListener("click", e => {

    if (e.target.matches("#btn-logout")) {

        e.preventDefault();
        logOut();
    }

})