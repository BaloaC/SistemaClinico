import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { listadoSegurosPagination, segurosPagination } from "./segurosPagination.js";

async function filtrarSeguros() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoSegurosPagination.registros.filter(seguro => filterPaginationHandle(filtro, seguro, ["nombre"]));
    segurosPagination(filtrado);
}

window.filtrarSeguros = filtrarSeguros;