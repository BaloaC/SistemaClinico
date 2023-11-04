import Cookies from "../../libs/jscookie/js.cookie.min.js";

const d = document,
    $alert = d.querySelector(".alert"),
    path = location.pathname.split('/');

const logIn = async (form) => {

    try {

        const credentials = new FormData(form);

        const options = {

            method: "POST",
            headers: { "Content-type": "application/json;charset=utf-8" },
            body: JSON.stringify({
                nombre: credentials.get("nombre"),
                clave: credentials.get("clave"),
            })
        }

        let response = await fetch(`/${path[1]}/login`, options),
            json = await response.json();



        if (!json.code) throw { result: json };

        $alert.classList.remove("alert-danger");
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-success");
        $alert.textContent = "Sesión iniciada correctamente!";

        Cookies.set("tokken", json.data.tokken);
        Cookies.set("usuario", credentials.get("nombre"));
        Cookies.set("usuario_id", json.data.usuario_id);
        Cookies.set("rol", json.data.rol);
        Cookies.set("failedSession", "0");

        setTimeout(() => {
            
            location = `/${path[1]}/home`;
        }, 1000);

    } catch (error) {
        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = "El usuario o la contraseña son inválidos";
    }

}

d.addEventListener("submit", e => {

    if (e.target.matches(".login-form")) {

        e.preventDefault();

        logIn(e.target);
    }
})

d.addEventListener("DOMContentLoaded", e => {

    // validateSession();
})