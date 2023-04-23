import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { empresasPagination } from "./empresasPagination.js";
import { mostrarEmpresas } from "./mostrarEmpresas.js";

async function deleteEmpresa(id) {
    await deleteModule("empresas", id, "Empresa eliminada exitosamente!");
    const listadoEmpresas = await getAll("empresas/consulta");
    empresasPagination(listadoEmpresas);
}

window.deleteEmpresa = deleteEmpresa;