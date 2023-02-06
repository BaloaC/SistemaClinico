import deleteModule from "../global/deleteModule.js";

function deleteFSeguro(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/seguro", id, "Factura seguro eliminada exitosamente!");
    $('#fSeguro').DataTable().ajax.reload();
}

window.deleteFSeguro = deleteFSeguro;
window.confirmDelete = confirmDelete;