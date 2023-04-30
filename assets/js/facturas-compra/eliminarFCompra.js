import deleteModule from "../global/deleteModule.js";

function deleteFCompra(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/compra", id, "Factura compra eliminada exitosamente!");
    $('#fCompra').DataTable().ajax.reload();
}

window.deleteFCompra = deleteFCompra;
window.confirmDelete = confirmDelete;