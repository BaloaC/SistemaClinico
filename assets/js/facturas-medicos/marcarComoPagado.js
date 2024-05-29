import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function marcarComoPagado(estatus_fac, confirmUpdate) {

    const options = {
        method: "PUT",
        body: {
            "estatus_fac": 3
        },
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }

    if (confirmUpdate === true) {
        fetch(`medico/${estatus_fac}`, options)
            .then(response => response.json())
            .then(json => {

                const $alert = document.getElementById("actAlert");

                if (json.code === true) {

                    $alert.classList.remove("alert-danger");
                    $alert.classList.add("alert-success");
                    $alert.classList.remove("d-none");
                    $alert.textContent = "Recibo de pago actualizado correctamente!";


                    setTimeout(() => {
                        $("#modalAct").modal("hide");
                        $alert.classList.add("d-none");
                    }, 500);


                    $('#fMedicos').DataTable().ajax.reload();
                    
                } else {

                    $alert.classList.remove("d-none");
                    $alert.classList.add("alert-danger");
                    let message = json.message || json.result.message;
                    $alert.textContent = message;

                    scrollTo("modalActBody");

                    setTimeout(() => {
                        $alert.classList.add("d-none");
                    }, 3000)
                }
            });
    } else {
        document.getElementById("btn-actualizarInfo1").setAttribute("onclick", `marcarComoPagado('${estatus_fac}', true)`)
    }
}

window.marcarComoPagado = marcarComoPagado;