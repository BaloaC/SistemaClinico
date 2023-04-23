import { mostrarSeguros } from "./mostrarSeguros.js";
import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { segurosPagination } from "./segurosPagination.js";

async function deleteSeguro(id) {
    await deleteModule("seguros", id, "Seguro eliminado exitosamente!");
    const listadoSeguros = await getAll("seguros/consulta");
    segurosPagination(listadoSeguros);
}

window.deleteSeguro = deleteSeguro;