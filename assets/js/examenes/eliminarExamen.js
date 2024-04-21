import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { examenesPagination, listadoExamenesPagination } from "./examenesPagination.js";

function deleteExamen(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("examenes", id, "Exámen eliminado exitosamente!");
    const listadoExamenes = await getAll("examenes/consulta");
    examenesPagination(listadoExamenes);
    listadoExamenesPagination.registros = listadoExamenes;
}

window.deleteExamen = deleteExamen;
window.confirmDelete = confirmDelete;