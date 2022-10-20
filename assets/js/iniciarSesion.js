


import Cookies from "./js.cookie.min.js";

console.log(Cookies);
Cookies.set("fooo", "bar");

document.addEventListener("submit", e => {

    if (e.target.matches('.session-form')) {

        e.preventDefault();

        async function logIn() {

            const $form = document.querySelector('.session-form'),
                credentials = new FormData($form);

            try {

                const options = {
                    method: "POST",
                    headers: { "Content-type": "application/json;charset=utf-8" },
                    body: credentials
                }

                let response = await fetch("http://127.0.0.1/proyectoFEO/login", options),
                    json = await response.json();

                if (!response.ok) throw { status: response.status, statusText: response.statusText };

                if (!json.session) throw false;

                Cookies.set("user", json.data.user);
                Cookies.set("token", json.data.token);
                return true; //Redirect


            } catch (error) {

                //Failed Session
            }
        }

        logIn();

    }
})



async function sessionValidate() {

    const user = Cookies.get("user"),
        token = Cookies.get("token");

    try {

        let response = await fetch("something", { method: "get" }),
            json = await response.json();

        if (!response.ok) throw { status: response.status, statusText: response.statusText };

        // if(token !== json.token) throw { message: "Error al validar la sesión, por favor inicie sesión nuevamente"}; 

        if (token !== json.token) throw false;

        return true;

    } catch (error) {

        Cookies.remove("user");
        Cookies.remove("token");
        return false;
    }
}