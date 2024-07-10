import deleteModule from "../global/deleteModule.js";
import mostrarHistorialMedico from "./mostrarHistorialMedico.js";

function deleteTitularRelacion(id) {
    document.getElementById("btn-confirmDeleteTitularRelacion").setAttribute("onclick",`confirmTitularRelacion(${id})`)
}

async function confirmTitularRelacion(id){
    const idPaciente = location.pathname.split("/")[4];
    await deleteModule("titular", id, "La relación con el titular ha sido eliminada exitosamente!", "#modalDeleteTitularRelacion", "delAlertTitularRelacion");
    mostrarHistorialMedico(idPaciente, false);
}

window.deleteTitularRelacion = deleteTitularRelacion;
window.confirmTitularRelacion = confirmTitularRelacion;