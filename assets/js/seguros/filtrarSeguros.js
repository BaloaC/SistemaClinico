import getAll from "../global/getAll.js";
import { segurosPagination } from "./segurosPagination.js";

let listadoSeguros;

async function obtenerListadoSeguros() {
    listadoSeguros = await getAll("seguros/consulta");
}

async function filtrarSeguros() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoSeguros.filter(seguro => seguro.nombre.match(new RegExp(filtro.value, 'i')));
    segurosPagination(filtrado);
}

await obtenerListadoSeguros();

// Actualizar el listado cada 60 segundos
window.setInterval(obtenerListadoSeguros, 60000);

window.filtrarSeguros = filtrarSeguros;