import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { examenesPagination, listadoExamenesPagination, pagination, ssrExamanesRequest } from "./examenesPagination.js";

function deleteEspecialidad(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar especialidad del médico"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteEspecialidad(${id})`)
}

async function confirmDeleteEspecialidad(id) {
    await deleteModule("examenes/especialidad/", id, "Especialidad del exámen eliminada correctamente!", "#modalDeleteRelacion", "delAlertRelacion");
    const listadoExamenes = await ssrExamanesRequest(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    examenesPagination(listadoExamenes);
    listadoExamenesPagination.registros = listadoExamenes;
}

window.deleteEspecialidad = deleteEspecialidad;
window.confirmDeleteEspecialidad = confirmDeleteEspecialidad;