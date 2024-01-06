import deleteModule from "../global/deleteModule.js";
import { listadoMedicosPagination, medicosPagination } from "./medicosPagination.js";
import getAll from "../global/getAll.js";


async function deleteMedico(id) {
    await deleteModule("medicos", id, "Médico eliminado exitosamente!");
    const listadoMedico = await getAll("medicos/consulta");
    medicosPagination(listadoMedico);
    listadoMedicosPagination.registros = listadoMedico;
}

window.deleteMedico = deleteMedico;