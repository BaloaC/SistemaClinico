import deleteModule from "../global/deleteModule.js";

function deleteFMedico(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("factura/medico", id, "Factura medico eliminada exitosamente!");
    $('#fMedicos').DataTable().ajax.reload();
}

window.deleteFMedico = deleteFMedico;
window.confirmDelete = confirmDelete;