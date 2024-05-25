import deleteModule from "../global/deleteModule.js";
import { listadoMedicosPagination, medicosPagination, pagination, ssrMedicosPagination } from "./medicosPagination.js";

function deleteHorario(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar día del horario"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteHorario(${id})`)
}

async function confirmDeleteHorario(id) {

    await deleteModule("horarios", id, "Día del horario eliminado correctamente!", "#modalDeleteRelacion", "delAlertRelacion");

    const listadoMedicos = await ssrMedicosPagination(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    medicosPagination(listadoMedicos);
    listadoMedicosPagination.registros = listadoMedicos;
}

window.deleteHorario = deleteHorario;
window.confirmDeleteHorario = confirmDeleteHorario;