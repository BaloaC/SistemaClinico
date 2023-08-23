import deleteModule from "../global/deleteModule.js";

function deletePacienteSeguro(id) {
    document.getElementById("btn-confirmDeletePacienteSeguro").setAttribute("onclick",`confirmDeletePacienteSeguro(${id})`)
}

async function confirmDeletePacienteSeguro(id){
    await deleteModule("paciente/seguro", id, "Seguro eliminado exitosamente!", "#modalDeletePacienteSeguro", "delAlertPacienteSeguro");
    $('#pacientes').DataTable().ajax.reload();
}

window.deletePacienteSeguro = deletePacienteSeguro;
window.confirmDeletePacienteSeguro = confirmDeletePacienteSeguro;