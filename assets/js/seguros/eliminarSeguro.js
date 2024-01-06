import deleteModule from "../global/deleteModule.js";

async function deleteSeguro(id) {

    await deleteModule("seguros", id, "Seguro eliminado exitosamente!");

    const urlActual = window.location.href;
    const posicion = urlActual.indexOf("/factura/consultaSeguro");
    const nuevaUrl = urlActual.substring(0, posicion) + "/seguros";

    window.location.href = nuevaUrl;
}

window.deleteSeguro = deleteSeguro;