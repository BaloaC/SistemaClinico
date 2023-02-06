import deleteModule from "../global/deleteModule.js";

function deletePaciente(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("pacientes", id, "Paciente eliminado exitosamente!");
    $('#pacientes').DataTable().ajax.reload();
}

window.deletePaciente = deletePaciente;
window.confirmDelete = confirmDelete;