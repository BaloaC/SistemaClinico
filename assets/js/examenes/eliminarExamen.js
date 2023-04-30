import deleteModule from "../global/deleteModule.js";
import getAll from "../global/getAll.js";
import { examenesPagination } from "./examenesPagination.js";
import { mostrarExamenes } from "./mostrarExamenes.js";

function deleteExamen(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick", `confirmDelete(${id})`)
}

async function confirmDelete(id) {
    await deleteModule("examenes", id, "Exámen eliminado exitosamente!");
    const listadoExamenes = await getAll("examenes/consulta");
    examenesPagination(listadoExamenes);

}

window.deleteExamen = deleteExamen;
window.confirmDelete = confirmDelete;