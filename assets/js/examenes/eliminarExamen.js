import deleteModule from "../global/deleteModule.js";
import { examenesPagination, listadoExamenesPagination, pagination, ssrExamanesRequest } from "./examenesPagination.js";

function deleteExamen(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("examenes", id, "Examen eliminado exitosamente!");
    const listadoExamenes = await ssrExamanesRequest(1);
    pagination.initializated = false;
    pagination.paginaActual = 1;
    examenesPagination(listadoExamenes);
    listadoExamenesPagination.registros = listadoExamenes;
}

window.deleteExamen = deleteExamen;
window.confirmDelete = confirmDelete;