import deleteModule from "../global/deleteModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

function deleteAntecedente(id) {
    document.getElementById("btn-confirmDeleteAntecedente").setAttribute("onclick",`confirmDeleteAntecedente(${id})`)
}

async function confirmDeleteAntecedente(id){
    const idPaciente = location.pathname.split("/")[4];
    await deleteModule("antecedentes", id, "Antecedente eliminado exitosamente!");
    mostrarHistorialMedico(idPaciente, true);
}

window.deleteAntecedente = deleteAntecedente;
window.confirmDeleteAntecedente = confirmDeleteAntecedente;