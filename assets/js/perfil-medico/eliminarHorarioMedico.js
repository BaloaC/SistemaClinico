import deleteModule from "../global/deleteModule.js";

function deleteHorario(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar día del horario"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteHorario(${id})`)
}

async function confirmDeleteHorario(id) {
    await deleteModule("horarios", id, "Día del horario eliminado correctamente!", "#modalDeleteRelacion", "delAlertRelacion");
    const urlParams = new URLSearchParams(window.location.search);
    const medico_id = urlParams.get('medico');
    await mostrarPerfilMedico(medico_id);
}

window.deleteHorario = deleteHorario;
window.confirmDeleteHorario = confirmDeleteHorario;