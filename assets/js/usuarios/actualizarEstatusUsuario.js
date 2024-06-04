import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function actualizarEstatusUsuario(usuario_id, estatus_usu, confirmUpdate) {

    const options = {
        method: "PUT",
        body: JSON.stringify({ "estatus_usu": estatus_usu == "1" ? 2 : 1 }),
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }


    if (confirmUpdate === true) {
        fetch(`usuarios/${usuario_id}`, options)
            .then(response => response.json())
            .then(json => {

                const $alert = document.getElementById("actEstatusAlert");

                if (json.code === true) {

                    $alert.classList.remove("alert-danger");
                    $alert.classList.add("alert-success");
                    $alert.classList.remove("d-none");
                    $alert.textContent = "El estatus del usuario se ha actualizado correctamente!";


                    setTimeout(() => {
                        $("#modalActEstatus").modal("hide");
                        $alert.classList.add("d-none");
                    }, 500);


                    $('#usuariosTable').DataTable().ajax.reload();
                    
                } else {

                    $alert.classList.remove("d-none");
                    $alert.classList.add("alert-danger");
                    let message = json.message || json.result.message;
                    $alert.textContent = message;

                    setTimeout(() => {
                        $alert.classList.add("d-none");
                    }, 3000)
                }
            });
    } else {
        document.getElementById("btn-actualizarInfo1").setAttribute("onclick", `actualizarEstatusUsuario(${usuario_id},'${estatus_usu}', true)`)
    }
}

window.actualizarEstatusUsuario = actualizarEstatusUsuario;