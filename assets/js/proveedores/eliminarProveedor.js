import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { listadoProveedoresPagination, pagination, proveedoresPagination, ssrProveedoresRequest } from "./proveedoresPagination.js";

function deleteProveedor(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("proveedores", id, "Proveedor eliminado exitosamente!");
    const listadoProveedores = await ssrProveedoresRequest(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    proveedoresPagination(listadoProveedores);
}

window.deleteProveedor = deleteProveedor;
window.confirmDelete = confirmDelete;