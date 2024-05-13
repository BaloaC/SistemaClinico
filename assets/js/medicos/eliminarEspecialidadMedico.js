import deleteModule from "../global/deleteModule.js";
import { listadoMedicosPagination, medicosPagination, pagination, ssrMedicosPagination } from "./medicosPagination.js";

function deleteEspecialidad(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar especialidad del médico"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteEspecialidad(${id})`)
}

async function confirmDeleteEspecialidad(id) {

    await deleteModule("medicos/especialidad", id, "Día del horario eliminado correctamente!", "#modalDeleteRelacion", "delAlertRelacion");

    const listadoMedicos = await ssrMedicosPagination(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    medicosPagination(listadoMedicos);
    listadoMedicosPagination.registros = listadoMedicos;
}

window.deleteEspecialidad = deleteEspecialidad;
window.confirmDeleteEspecialidad = confirmDeleteEspecialidad;