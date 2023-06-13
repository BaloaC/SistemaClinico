import deleteModule from "../global/deleteModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

function deleteAntecedente(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    const idPaciente = location.pathname.split("/")[4];
    await deleteModule("antecedentes", id, "Antecedente eliminado exitosamente!");
    mostrarHistorialMedico(idPaciente);
}

window.deleteAntecedente = deleteAntecedente;
window.confirmDelete = confirmDelete;