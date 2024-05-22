function montoAprobadoHandler(input) {

    const montoDisponible = document.getElementById("montoDisponible");

    montoDisponible.innerText = `Saldo a favor: $${input.value !== "" ? input.value : 0}`

    const examenesPrecio = document.querySelectorAll(".examenPrice");

    examenesPrecio.forEach(examen => {
        
        let montoExamen = parseFloat(examen.textContent.slice(1));
        let montoDisponibleTotal = parseFloat(montoDisponible.innerText.split("$")[1]);
        let examenElements = examen.parentElement.querySelectorAll("td");
        let cubiertoPorSeguro = examenElements[1].firstChild;
        cubiertoPorSeguro.classList.remove("cubiertoPor3");

        // Si el monto del examen no supera al montoTotal permitimos que se seleccione, caso contrario no
        if(montoExamen <= montoDisponibleTotal){

            cubiertoPorSeguro.checked = false;
            cubiertoPorSeguro.disabled = false;
            
        } else {

            // Si no queda saldo desactivar, pero en caso de que quede, permitir seleccionarlo para que pueda cubrirlo el seguro y paciente
            if(montoDisponibleTotal <= 0){
                cubiertoPorSeguro.checked = false;
                cubiertoPorSeguro.disabled = true;
            } else {
                cubiertoPorSeguro.checked = false;
                cubiertoPorSeguro.disabled = false;
            }
        }
    });


}

window.montoAprobadoHandler = montoAprobadoHandler;