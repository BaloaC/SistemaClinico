import Cookies from "../../libs/jscookie/js.cookie.min.js";

async function marcarComoPagado(estatus_fac) {

    if(estatus_fac == 0) return;

    const options = {
        method: "PUT",
        body: {
            "estatus_fac": 3
        },
        headers: {
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    }
    
    fetch(`medico/${estatus_fac}`, options)
    .then(response => response.json())
    .then(json => json.code === true ? $('#fMedicos').DataTable().ajax.reload() : null);
}

window.marcarComoPagado = marcarComoPagado;