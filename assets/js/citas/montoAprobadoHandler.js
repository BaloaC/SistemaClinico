function montoAprobadoHandler(input) {

    const montoDisponible = document.getElementById("montoDisponible");

    montoDisponible.innerText = `Saldo a favor: $${input.value !== "" ? input.value : 0}`

    const examenesPrecio = document.querySelectorAll(".examenPrice");

    examenesPrecio.forEach(examen => {
        
        let montoExamen = parseFloat(examen.textContent.slice(1));
        let montoDisponibleTotal = parseFloat(montoDisponible.innerText.split("$")[1]);
        let examenElements = examen.parentElement.querySelectorAll("td");
        let cubiertoPorSeguro = examenElements[0].firstChild;
        let cubiertoPorPaciente = examenElements[1].firstChild;

        // Si el monto del examen no supera al montoTotal permitimos que se seleccione, caso contrario no
        if(montoExamen <= montoDisponibleTotal){

            cubiertoPorPaciente.disabled = false;
            cubiertoPorSeguro.disabled = false;
            
        } else {

            cubiertoPorPaciente.checked = false;
            cubiertoPorSeguro.checked = false;
            cubiertoPorPaciente.disabled = true;
            cubiertoPorSeguro.disabled = true;
        }
    });


}

window.montoAprobadoHandler = montoAprobadoHandler;