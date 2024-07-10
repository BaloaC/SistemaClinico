import deleteModule from "../global/deleteModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

function deleteSeguroRelacion(id) {
    document.getElementById("btn-confirmDeleteSeguroRelacion").setAttribute("onclick",`confirmSeguroRelacion(${id})`)
}

async function confirmSeguroRelacion(id){
    const idPaciente = location.pathname.split("/")[4];
    await deleteModule("paciente/seguro", id, "Relación con el seguro eliminada exitosamente!", "#modalDeleteSeguroRelacion", "delAlertSeguroRelacion");
    mostrarHistorialMedico(idPaciente, false);
}

window.deleteSeguroRelacion = deleteSeguroRelacion;
window.confirmSeguroRelacion = confirmSeguroRelacion;