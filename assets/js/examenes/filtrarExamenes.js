import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { buscarRegistrosObj, empresasPagination, listadoEmpresasPagination, ssrEmpresaRequest } from "./empresasPagination.js";

async function filtrarEmpresas() {

    const filtro = document.getElementById("inputSearch");

    const listadoEmpresa = await ssrEmpresaRequest(1, `=${filtro.value}`);
    buscarRegistrosObj.valor = `=${filtro.value}`;
    empresasPagination(listadoEmpresa, `=${filtro.value}`);
}

window.filtrarEmpresas = filtrarEmpresas;