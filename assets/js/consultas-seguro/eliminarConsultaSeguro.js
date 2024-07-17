import deleteModule from "../global/deleteModule.js";

function deleteFSeguro(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/seguro", id, "Recibo seguro eliminada exitosamente!");
    $('#fSeguros').DataTable().ajax.reload();
}

window.deleteFSeguro = deleteFSeguro;
window.confirmDelete = confirmDelete;