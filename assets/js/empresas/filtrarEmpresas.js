import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { empresasPagination, listadoEmpresasPagination } from "./empresasPagination.js";

async function filtrarEmpresas() {

    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoEmpresasPagination.registros.filter(empresa => filterPaginationHandle(filtro, empresa, ["nombre"]));
    empresasPagination(filtrado);
}

window.filtrarEmpresas = filtrarEmpresas;