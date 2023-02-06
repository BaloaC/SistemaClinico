import deleteModule from "../global/deleteModule.js";

function deleteConsulta(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("consultas", id, "Consulta eliminada exitosamente!");
    $('#consultas').DataTable().ajax.reload();
}

window.deleteConsulta = deleteConsulta;
window.confirmDelete = confirmDelete;