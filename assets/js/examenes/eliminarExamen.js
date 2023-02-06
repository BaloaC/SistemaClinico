import deleteModule from "../global/deleteModule.js";
import { mostrarExamenes } from "./mostrarExamenes.js";

function deleteExamen(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("examenes", id, "Exámen eliminado exitosamente!");
    mostrarExamenes();
}

window.deleteExamen = deleteExamen;
window.confirmDelete = confirmDelete;