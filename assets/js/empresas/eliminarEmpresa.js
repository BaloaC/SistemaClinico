import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { empresasPagination, listadoEmpresasPagination } from "./empresasPagination.js";

async function deleteEmpresa(id) {
    await deleteModule("empresas", id, "Empresa eliminada exitosamente!");
    const listadoEmpresas = await getAll("empresas/consulta");
    empresasPagination(listadoEmpresas);
    listadoEmpresasPagination.registros = listadoEmpresas;
}

window.deleteEmpresa = deleteEmpresa;