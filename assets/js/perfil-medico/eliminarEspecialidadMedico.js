import deleteModule from "../global/deleteModule.js";

function deleteEspecialidad(id) {
    document.getElementById("modalDeleteLabelRelacion").textContent = "Eliminar especialidad del médico"
    document.getElementById("btn-confirmDeleteRelacion").setAttribute("onclick", `confirmDeleteEspecialidad(${id})`)
}

async function confirmDeleteEspecialidad(id) {
    await deleteModule("medicos/especialidad", id, "Especialidad eliminada correctamente!", "#modalDeleteRelacion", "delAlertRelacion");
    const urlParams = new URLSearchParams(window.location.search);
    const medico_id = urlParams.get('medico');
    await mostrarPerfilMedico(medico_id);
}

window.deleteEspecialidad = deleteEspecialidad;
window.confirmDeleteEspecialidad = confirmDeleteEspecialidad;