import deleteModule from "../global/deleteModule.js";

function deletePacienteTitular(id) {
    document.getElementById("btn-confirmDeletePacienteTitular").setAttribute("onclick",`confirmDeletePacienteTitular(${id})`)
}

async function confirmDeletePacienteTitular(id){
    await deleteModule("titular", id, "Titular eliminado exitosamente!", "#modalDeletePacienteTitular", "delAlertPacienteTitular");
    $('#pacientes').DataTable().ajax.reload();
}

window.deletePacienteTitular = deletePacienteTitular;
window.confirmDeletePacienteTitular = confirmDeletePacienteTitular;