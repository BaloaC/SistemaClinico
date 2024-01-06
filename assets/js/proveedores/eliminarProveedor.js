import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { listadoProveedoresPagination, proveedoresPagination } from "./proveedoresPagination.js";

function deleteProveedor(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("proveedores", id, "Proveedor eliminado exitosamente!");
    const listadoProveedores = await getAll("proveedores/consulta");
    proveedoresPagination(listadoProveedores);
    listadoProveedoresPagination.registros = listadoProveedores;

}

window.deleteProveedor = deleteProveedor;
window.confirmDelete = confirmDelete;