import deleteModule from "../global/deleteModule.js";

function deleteMedicamento(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("medicamento", id, "Medicamento eliminado exitosamente!");
    $('#medicamentos').DataTable().ajax.reload();
}

window.deleteMedicamento = deleteMedicamento;
window.confirmDelete = confirmDelete;