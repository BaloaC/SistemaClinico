import getAll from "../global/getAll.js";
import { proveedoresPagination } from "./proveedoresPagination.js";

let listadoProveedores;

async function obtenerListadoProveedores() {
    listadoProveedores = await getAll("proveedores/consulta");
}

async function filtrarProveedores() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoProveedores.filter(provedor => provedor.nombre.match(new RegExp(filtro.value, 'i')));
    proveedoresPagination(filtrado);
}

await obtenerListadoProveedores();

// Actualizar el listado cada 60 segundos
window.setInterval(obtenerListadoProveedores, 60000);

window.filtrarProveedores = filtrarProveedores;