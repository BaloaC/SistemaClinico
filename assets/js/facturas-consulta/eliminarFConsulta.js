import deleteModule from "../global/deleteModule.js";

function deleteFConsulta(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/consulta", id, "Factura consulta eliminada exitosamente!");
    $('#fConsulta').DataTable().ajax.reload();
}

window.deleteFConsulta = deleteFConsulta;
window.confirmDelete = confirmDelete;