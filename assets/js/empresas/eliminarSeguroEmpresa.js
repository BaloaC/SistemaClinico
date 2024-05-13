import deleteModule from "../global/deleteModule.js";
import { empresasPagination, listadoEmpresasPagination, pagination, ssrEmpresaRequest } from "./empresasPagination.js";

function deleteSeguroEmpresa(id) {
    document.getElementById("btn-confirmDeleteSeguro").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {

    await deleteModule("seguroempresa", id, "Relación con el seguro eliminada correctamente!", "#modalDeleteSeguro", "delAlertSeguro");

    const listadoEmpresas = await ssrEmpresaRequest(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    empresasPagination(listadoEmpresas);
    listadoEmpresasPagination.registros = listadoEmpresas;
}

window.deleteSeguroEmpresa = deleteSeguroEmpresa;
window.confirmDelete = confirmDelete;