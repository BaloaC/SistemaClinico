import { buscarRegistrosObj, segurosPagination, ssrSegurosRequest } from "./segurosPagination.js";

async function filtrarSeguros() {
    const filtro = document.getElementById("inputSearch");
    const listadoSeguros = await ssrSegurosRequest(1, `=${filtro.value}`);
    buscarRegistrosObj.valor = `=${filtro.value}`;
    segurosPagination(listadoSeguros, `=${filtro.value}`);
}

window.filtrarSeguros = filtrarSeguros;