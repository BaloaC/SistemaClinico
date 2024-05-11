import deleteModule from "../global/deleteModule.js";
import { empresasPagination, pagination, ssrEmpresaRequest } from "./empresasPagination.js";

async function deleteEmpresa(id) {
    await deleteModule("empresas", id, "Empresa eliminada exitosamente!");
    const listadoEmpresas = await ssrEmpresaRequest(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    empresasPagination(listadoEmpresas);
}

window.deleteEmpresa = deleteEmpresa;