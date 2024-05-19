function montoAprobadoHandler(input) {

    // TODO: Añadir lógica de que cuando se actualice el input, desactivar examenes
    document.getElementById("montoDisponible").innerText = `Saldo a favor: $${input.value !== "" ? input.value : 0}`
}

window.montoAprobadoHandler = montoAprobadoHandler;