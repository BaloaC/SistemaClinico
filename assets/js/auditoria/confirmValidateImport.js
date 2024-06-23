import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function confirmValidateImport() {

    const $alert = document.getElementById("importConfirmAlert");
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

    const showAlertMessageFailed = async (message) => {

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = message;

        setTimeout(() => {
            $alert.classList.add("d-none");
        }, 3000)
    }

    if (Cookies.get("rol") !== "1") {

        await showAlertMessageFailed("Su usuario no tiene acceso a esta funcionalidad del sistema, por favor contacte al administrador para que este pueda realizarla.");
        return;
    }

    if (Cookies.get("authT")) {

        const tokenAuth = Cookies.get("authT");
        const partsToken = tokenAuth.split("||");
        const authDate = new Date(atob(partsToken[0]).replaceAll("\"", ""));
        const currentDate = new Date();
        const diferenciaMinutos = (currentDate - authDate) / 1000 / 60;

        if ((diferenciaMinutos < 30 && parseInt(partsToken[2]) >= 3)) {

            await showAlertMessageFailed("Máximo de intentos alcanzados, por favor espere un momento y vuelva a intentar.");
            return;
        }
    }



    fetch(`./validarUsuario`, options)
        .then(response => response.json())
        .then(json => {

            if (json.code === true) {


                Cookies.set("authT", `${btoa(JSON.stringify(new Date()))}||${Cookies.get("usuario_id")}||0`);

                $alert.classList.remove("d-none");
                $alert.classList.remove("alert-danger");
                $alert.classList.add("alert-success");
                $alert.textContent = "Sesión validada correctamente!";

                document.getElementById("info-validarImport").reset();


                $("#modalConfirmImport").modal("hide");
                $("#modalUpload").modal("show");

                setTimeout(() => {
                    $alert.classList.add("d-none");
                }, 1000);

            } else {

                if (Cookies.get("authT")) {
                    const tokenAuth = Cookies.get("authT");
                    const partsToken = tokenAuth.split("||");
                    const authDate = new Date(atob(partsToken[0]).replaceAll("\"", ""));
                    const currentDate = new Date();
                    const diferenciaMinutos = (currentDate - authDate) / 1000 / 60;
                    let intentos = parseInt(partsToken[2]) + 1;


                    if (diferenciaMinutos > 30) {
                        Cookies.set("authT", `${btoa(JSON.stringify(new Date()))}||${Cookies.get("usuario_id")}||1`);
                    } else {
                        Cookies.set("authT", `${partsToken[0]}||${Cookies.get("usuario_id")}||${intentos}`);
                    }
                } else {
                    Cookies.set("authT", `${btoa(JSON.stringify(new Date()))}||${Cookies.get("usuario_id")}||1`);
                }


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