import { filterPaginationHandle } from "../global/filterPaginationHandle.js";
import { listadoProveedoresPagination, proveedoresPagination } from "./proveedoresPagination.js";

async function filtrarProveedores() {
    const filtro = document.getElementById("inputSearch");
    const filtrado = listadoProveedoresPagination.registros.filter(proveedor => filterPaginationHandle(filtro, proveedor, ["nombre"]));
    
    proveedoresPagination(filtrado);
}

window.filtrarProveedores = filtrarProveedores;