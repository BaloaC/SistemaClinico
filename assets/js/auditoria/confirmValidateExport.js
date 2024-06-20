import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function confirmValidateExport() {
    
    const clave = document.getElementById("claveUserExport");

    const options = {
        method: "POST",
        body: JSON.stringify({
            "nombre": Cookies.get("usuario"),
            "clave": clave.value
        }),
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }

    fetch(`./validarUsuario`, options)
        .then(response => response.json())
        .then(json => {

            const $alert = document.getElementById("exportConfirmAlert");

            if (json.code === true) {

                $alert.classList.remove("alert-danger");
                $alert.classList.add("alert-success");
                $alert.classList.remove("d-none");
                $alert.textContent = "Se ha realizado la exportación de la base de datos correctamente!";


                setTimeout(() => {
                    $("#modalConfirmExport").modal("hide");
                    $alert.classList.add("d-none");
                }, 500);

                document.getElementById("info-validarExport").reset();
                location.href = "./exportarBd";

            } else {

                $alert.classList.remove("d-none");
                $alert.classList.add("alert-danger");
                $alert.textContent = "Clave inválida verifique e intente nuevamente";

                setTimeout(() => {
                    $alert.classList.add("d-none");
                }, 3000)
            }
        });
}

window.confirmValidateExport = confirmValidateExport;