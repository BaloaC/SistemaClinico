import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { empresasPagination } from "./empresasPagination.js";

function deleteSeguroEmpresa(id) {
    document.getElementById("btn-confirmDeleteSeguro").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("seguroempresa", id, "Relación con el seguro eliminada correctamente!", "#modalDeleteSeguro", "delAlertSeguro");
    const listadoEmpresas = await getAll("empresas/consulta");
    empresasPagination(listadoEmpresas);
}

window.deleteSeguroEmpresa = deleteSeguroEmpresa;
window.confirmDelete = confirmDelete;