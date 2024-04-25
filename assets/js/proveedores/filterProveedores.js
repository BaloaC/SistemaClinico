import { buscarRegistrosObj, proveedoresPagination, ssrProveedoresRequest } from "./proveedoresPagination.js";

async function filtrarProveedores() {
    const filtro = document.getElementById("inputSearch");
    const listadoProveedores = await ssrProveedoresRequest(1, `=${filtro.value}`);
    buscarRegistrosObj.valor = `=${filtro.value}`;
    proveedoresPagination(listadoProveedores, `=${filtro.value}`)
}

window.filtrarProveedores = filtrarProveedores;