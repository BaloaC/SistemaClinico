import deleteModule from "../global/deleteModule.js";
import { listadoMedicosPagination, medicosPagination, pagination, ssrMedicosPagination } from "./medicosPagination.js";
import getAll from "../global/getAll.js";


async function deleteMedico(id) {
    await deleteModule("medicos", id, "Médico eliminado exitosamente!");
    const listadoMedico = await ssrMedicosPagination(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    medicosPagination(listadoMedico);
}

window.deleteMedico = deleteMedico;