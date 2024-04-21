import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { empresasPagination, ssrEmpresaRequest } from "./empresasPagination.js";

async function deleteEmpresa(id) {
    await deleteModule("empresas", id, "Empresa eliminada exitosamente!");
    const listadoEmpresas = await ssrEmpresaRequest(1);
    empresasPagination(listadoEmpresas);
}

window.deleteEmpresa = deleteEmpresa;