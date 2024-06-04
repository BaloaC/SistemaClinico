import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function uploadBd() {

    const loadingMessage = document.getElementById("loadingMessage");
    const sqlFile = document.getElementById("sqlFile"); 
    const form = new FormData();
    form.append("archivosql",sqlFile.files[0]);

    const options = {
        method: "POST",
        body: form,
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }

    $(loadingMessage).fadeIn("slow");

    fetch(`importarBd`, options)
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