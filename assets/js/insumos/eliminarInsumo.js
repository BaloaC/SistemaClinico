import deleteModule from "../global/deleteModule.js";

function deleteInsumo(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("insumos", id, "Insumo eliminada exitosamente!");
    $('#insumos').DataTable().ajax.reload();
}

window.deleteInsumo = deleteInsumo;
window.confirmDelete = confirmDelete;