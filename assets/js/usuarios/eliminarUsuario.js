import deleteModule from "../global/deleteModule.js";

function deleteUsuario(id) {
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`)
}

async function confirmDelete(id){
    await deleteModule("usuarios", id, "Usuario eliminado exitosamente!");
    $('#usuariosTable').DataTable().ajax.reload();
}

window.deleteUsuario = deleteUsuario;
window.confirmDelete = confirmDelete;