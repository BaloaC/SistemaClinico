import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { empresasPagination, ssrEmpresaRequest } from "./empresasPagination.js";

function deleteExamen(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("empresas", id, "Empresa eliminada exitosamente!");
    const listadoEmpresas = await ssrEmpresaRequest(1);
    empresasPagination(listadoEmpresas);
}

window.deleteExamen = deleteExamen;
window.confirmDelete = confirmDelete;