const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import cleanValdiation from "../global/cleanValidations.js";
import getById from "../global/getById.js";

async function generarTodosLosAcumulados(infoSeguro) {

    const alert = document.getElementById("actAlert");

    // Obtener la fecha actual en la zona horaria local
    const fechaActual = luxon.DateTime.local();

    // Formatear la fecha en el formato deseado
    const fechaFormateada = fechaActual.minus({ days: 1 }).toFormat('yyyy-MM-dd');


    const options = {

        method: "POST",
        mode: "cors", //Opcional
        headers: {
            "Content-type": "application/json; charset=utf-8",
            "Authorization": "Bearer " + Cookies.get("tokken")
        },
        body: JSON.stringify({
            fecha_actual: fechaFormateada
        })
    };

    await fetch(`/${path[1]}/facturas/all`, options)

    cleanValdiation("info-fmedico");
    $('#fMedicos').DataTable().ajax.reload();

    alert.classList.remove("d-none");

    setTimeout(() => {
        $("#modalAct").modal("hide");
        alert.classList.add("d-none");
    }, 500);


}

window.generarTodosLosAcumulados = generarTodosLosAcumulados;