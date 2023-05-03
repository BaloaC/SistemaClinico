import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { medicosPagination } from "./medicosPagination.js";

function deleteEspecialidad(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar especialidad del médico"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteEspecialidad(${id})`)
}

async function confirmDeleteEspecialidad(id) {
    await deleteModule("medicos/especialidad", id, "Día del horario eliminado correctamente!", "#modalDeleteRelacion", "delAlertRelacion");
    const listadoMedicos = await getAll("medicos/consulta");
    medicosPagination(listadoMedicos);
}

window.deleteEspecialidad = deleteEspecialidad;
window.confirmDeleteEspecialidad = confirmDeleteEspecialidad;