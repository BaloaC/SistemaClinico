import deleteModule from "../global/deleteModule.js";

function deleteFSeguro(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/seguro", id, "Recibo seguro eliminado exitosamente!");
    $('#fSeguros').DataTable().ajax.reload();
}

window.deleteFSeguro = deleteFSeguro;
window.confirmDelete = confirmDelete;