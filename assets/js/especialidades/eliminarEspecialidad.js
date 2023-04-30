import deleteModule from "../global/deleteModule.js";

function deleteEspecialidad(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("especialidades", id, "Especialidad eliminada exitosamente!");
    $('#especialidades').DataTable().ajax.reload();
}

window.deleteEspecialidad = deleteEspecialidad;
window.confirmDelete = confirmDelete;