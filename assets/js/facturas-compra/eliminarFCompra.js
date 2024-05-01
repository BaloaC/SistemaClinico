import deleteModule from "../global/deleteModule.js";

function deleteFCompra(id) {
    document.getElementById("btn-confirmDelete").removeAttribute("onclick");
    document.getElementById("btn-confirmDelete").setAttribute("onclick",`confirmDelete(${id})`);
}

async function confirmDelete(id){

    const $alert = document.getElementById("delAlert");

    try {
        
        const motivo_cancelacion = document.getElementById("motivo_cancelacion");
        
        if(!motivo_cancelacion.value || motivo_cancelacion.value.length <= 0) throw { message: "El motivo ingresado no es válido" };

        await deleteModule("factura/compra", id, "Factura compra eliminada exitosamente!","#modalDelete", "delAlert",{motivo_cancelacion: motivo_cancelacion.value});
        motivo_cancelacion.value = "";
        $('#fCompra').DataTable().ajax.reload();

    } catch (error) {

        $alert.classList.remove("d-none");
        $alert.classList.add("alert-danger");
        $alert.textContent = error.message || error.result.message;
    }

    
}

window.deleteFCompra = deleteFCompra;
window.confirmDelete = confirmDelete;