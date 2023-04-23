import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { mostrarProveedores } from "./mostrarProveedores.js";
import { proveedoresPagination } from "./proveedoresPagination.js";

function deleteProveedor(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("proveedores", id, "Proveedor eliminado exitosamente!");
    const listadoProveedores = await getAll("proveedores/consulta");
    const registros = listadoProveedores;
    proveedoresPagination(registros);

}

window.deleteProveedor = deleteProveedor;
window.confirmDelete = confirmDelete;