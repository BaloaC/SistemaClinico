import deleteModule from "../global/deleteModule.js";
import { mostrarProveedores } from "./mostrarProveedores.js";

function deleteProveedor(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("proveedores", id, "Proveedor eliminado exitosamente!");
    mostrarProveedores();
}

window.deleteProveedor = deleteProveedor;
window.confirmDelete = confirmDelete;