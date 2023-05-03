import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { medicosPagination } from "./medicosPagination.js";

function deleteHorario(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar día del horario"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteHorario(${id})`)
}

async function confirmDeleteHorario(id) {
    await deleteModule("horarios", id, "Día del horario eliminado correctamente!", "#modalDeleteRelacion", "delAlertRelacion");
    const listadoMedicos = await getAll("medicos/consulta");
    medicosPagination(listadoMedicos);
}

window.deleteHorario = deleteHorario;
window.confirmDeleteHorario = confirmDeleteHorario;