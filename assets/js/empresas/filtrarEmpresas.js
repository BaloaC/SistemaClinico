import getAll from "../global/getAll.js";
import { empresasPagination } from "./empresasPagination.js";

let listadoEmpresas;

async function obtenerListadoEmpresas() {
    listadoEmpresas = await getAll("empresas/consulta");
}

async function filtrarEmpresas() {

    const filtro = document.getElementById("inputSearch");
    // const listadoEmpresas = await getAll("empresas/consulta");
    const filtrado = listadoEmpresas.filter(empresa => empresa.nombre.match(new RegExp(filtro.value, 'i')));
    empresasPagination(filtrado);
}

await obtenerListadoEmpresas();

// Actualizar el listado cada 60 segundos
window.setInterval(obtenerListadoEmpresas, 60000);

window.filtrarEmpresas = filtrarEmpresas;