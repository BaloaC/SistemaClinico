import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function confirmValidateImport() {

    const clave = document.getElementById("claveUserImport");

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

            const $alert = document.getElementById("importConfirmAlert");

            if (json.code === true) {


                const loadingMessage = document.getElementById("loadingMessage");
                const sqlFile = document.getElementById("sqlFile");
                const form = new FormData();
                form.append("archivosql", sqlFile.files[0]);

                const options = {
                    method: "POST",
                    body: form,
                    headers: {
                        "Authorization": "Bearer " + Cookies.get("tokken")
                    }
                }

                $(loadingMessage).fadeIn("slow");

                fetch(`./importarBd`, options)
                    .then(response => response.json())
                    .then(json => {

                        $(loadingMessage).fadeOut("slow");

                        if (json.code === true) {

                            $alert.classList.remove("alert-danger");
                            $alert.classList.add("alert-success");
                            $alert.classList.remove("d-none");
                            $alert.textContent = "Se ha realizado la importación de la base de datos correctamente!";


                            setTimeout(() => {
                                $("#modalConfirmImport").modal("hide");
                                $alert.classList.add("d-none");
                            }, 500);

                            document.getElementById("info-validarImport").reset();

                        } else {

                            $alert.classList.remove("d-none");
                            $alert.classList.add("alert-danger");
                            let message = json.message || json.result.message;
                            $alert.textContent = message;

                            scrollTo("modalUploadBody");

                            setTimeout(() => {
                                $alert.classList.add("d-none");
                            }, 3000)
                        }
                    });

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

window.confirmValidateImport = confirmValidateImport;