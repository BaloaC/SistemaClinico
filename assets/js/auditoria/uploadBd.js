import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function uploadBd() {

    const loadingMessage = document.getElementById("loadingMessage");
    const sqlFile = document.getElementById("sqlFile");
    const file = sqlFile.files[0];
    const allowedExtensions = ['sql'];
    const fileName = file.name;
    const extension = fileName.slice(fileName.lastIndexOf('.') + 1).toLowerCase();
    const form = new FormData();
    form.append("archivosql", sqlFile.files[0]);

    const options = {
        method: "POST",
        body: form,
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }

    const showTokenFailedMessage = async (message) => {

        const $alert = document.getElementById("uploadAlert");
        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = message;

        setTimeout(() => {
            $alert.classList.add("d-none");
            // $("#modalUpload").modal("hide");
        }, 3000)
    }

    if (!allowedExtensions.includes(extension)) {
        await showTokenFailedMessage("Solo se permiten archivos con la extensión .sql");
        return;
    } 
    
    if (Cookies.get("authT") === undefined){
        await showTokenFailedMessage("No se ha podido validar la sesión intente nuevamente"); 
        return;
    } 

    if (Cookies.get("authT")) {
        const authToken = Cookies.get("authT");
        const partsToken = authToken.split("||");

        if (parseInt(partsToken[2]) !== 0){
            await showTokenFailedMessage("No se ha podido validar la sesión intente nuevamente");
            return;
        }
    }

    $(loadingMessage).fadeIn("slow");

    fetch(`./importarBd`, options)
        .then(response => response.json())
        .then(json => {

            $(loadingMessage).fadeOut("slow");

            const $alert = document.getElementById("uploadAlert");

            if (json.code === true) {

                $alert.classList.remove("alert-danger");
                $alert.classList.add("alert-success");
                $alert.classList.remove("d-none");
                $alert.textContent = "Se ha realizado la importación de la base de datos correctamente!";


                setTimeout(() => {
                    $("#modalUpload").modal("hide");
                    $alert.classList.add("d-none");
                }, 500);


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
}

window.uploadBd = uploadBd;