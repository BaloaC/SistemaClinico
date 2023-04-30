import getAll from "../global/getAll.js";
import { proveedoresPagination } from "./proveedoresPagination.js";

async function filtrarProveedores() {
    const filtro = document.getElementById("inputSearch");
    const listadoProveedores = await getAll("proveedores/consulta");
    const filtrado = listadoProveedores.filter(provedor => provedor.nombre.match(new RegExp(filtro.value, 'i')));
    proveedoresPagination(filtrado);
}

window.filtrarProveedores = filtrarProveedores;