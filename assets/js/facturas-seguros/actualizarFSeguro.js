import addModule from "../global/addModule.js";
const path = location.pathname.split('/');
import Cookies from "../../libs/jscookie/js.cookie.min.js";
import getById from "../global/getById.js";

async function actualizarFSeguro(infoSeguro) {

    const alert = document.getElementById("actAlert");

    const options = {

        method: "POST",
        mode: "cors", //Opcional
        headers: {
            "Content-type": "application/json; charset=utf-8",
            "Authorization": "Bearer " + Cookies.get("tokken")
        }
    };

    let response = await fetch(`/${path[1]}/factura/seguro`, options)

    const id = infoSeguro.split("-");
    let listadoFacturas = await getById("factura/seguro", id[0]);

    // Filtramos las facturas por el año que se consulta
    listadoFacturas = listadoFacturas.filter(factura => factura.fecha_ocurrencia.slice(0, 4) === id[1]);

    let tablaSeguros = $('#fSeguros').DataTable();

    // Para actualizar la tabla
    tablaSeguros.clear().rows.add(listadoFacturas).draw();

    alert.classList.remove("d-none");

    setTimeout(() => {
        $("#modalAct").modal("hide");
        alert.classList.add("d-none");
    }, 500);
    
}

window.actualizarFSeguro = actualizarFSeguro;