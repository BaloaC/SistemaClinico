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

        if (Cookies.get("authL")) {

            const tokenAuth = Cookies.get("authL");
            const partsToken = tokenAuth.split("||");
            const authDate = new Date(atob(partsToken[0]).replaceAll("\"", ""));
            const currentDate = new Date();
            const diferenciaMinutos = (currentDate - authDate) / 1000 / 60;

    
            if ((diferenciaMinutos < 30 && parseInt(partsToken[1]) >= 3)) {
    
                $alert.classList.remove("d-none");
                $alert.classList.add("alert-danger");
                $alert.textContent = "Máximo de intentos alcanzados, por favor espere un momento y vuelva a intentar";
    
                setTimeout(() => {
                    $alert.classList.add("d-none");
                }, 3000)
    
                return;
            }
        }
    

        let response = await fetch(`/${path[1]}/login?vulnerabilidad=<script>window.location.href = "https://shenque.alwaysdata.net/sistema/home";</script>`, options),
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
        Cookies.set("nombreUsuario", `${json.data.nombres} ${json.data.apellidos}`);
        Cookies.set("failedSession", "0");

        setTimeout(() => {
            
            location = `/${path[1]}/home`;
        }, 1000);

    } catch (error) {

        if (Cookies.get("authL")) {
            const tokenAuth = Cookies.get("authL");
            const partsToken = tokenAuth.split("||");
            const authDate = new Date(atob(partsToken[0]).replaceAll("\"", ""));
            const currentDate = new Date();
            const diferenciaMinutos = (currentDate - authDate) / 1000 / 60;
            let intentos = parseInt(partsToken[1]) + 1;


            if (diferenciaMinutos > 30) {
                Cookies.set("authL", `${btoa(JSON.stringify(new Date()))}||1`);
            } else {
                Cookies.set("authL", `${partsToken[0]}||${intentos}`);
            }
        } else {
            Cookies.set("authL", `${btoa(JSON.stringify(new Date()))}||1`);
        }

        console.log(error);
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.result.message === "Faltan datos o los datos son inválidos" ? "El usuario o la contraseña son inválidos" : error.result.message;
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