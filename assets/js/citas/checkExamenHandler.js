function checkExamenHandler(checkbox) {

    const examenOptions = checkbox.parentElement.parentElement.querySelectorAll("td");
    const examenPrice = parseFloat(examenOptions[2].lastChild.nodeValue.slice(1));
    const montoDisponibleContianer = document.getElementById("montoDisponible");
    const montoDisponible = parseFloat(montoDisponibleContianer.innerText.split("$")[1]) ?? 0;

    const cubiertoPorSeguroCheck = examenOptions[0].childNodes[0];
    const cubiertoPorPacienteCheck = examenOptions[1].childNodes[0];

    // Si no hay ninguna opción activa, regresamos el dinero al montoDisponible
    if (!cubiertoPorPacienteCheck.checked && !cubiertoPorSeguroCheck.checked) {
        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible + examenPrice}`;
    }

    // Si se marca alguna de las opciones se resta el monto total
    if (checkbox.checked && (!cubiertoPorPacienteCheck.checked || !cubiertoPorSeguroCheck.checked)) {
        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible - examenPrice}`;
    }


    // Para deshabilitar los examenes que superan el monto total
    const examenesPrecio = document.querySelectorAll(".examenPrice");

    examenesPrecio.forEach(examen => {

        let montoExamen = parseFloat(examen.textContent.slice(1));
        let montoDisponibleTotal = parseFloat(montoDisponibleContianer.innerText.split("$")[1]);
        let examenElements = examen.parentElement.querySelectorAll("td");
        let cubiertoPorSeguro = examenElements[0].firstChild;
        let cubiertoPorPaciente = examenElements[1].firstChild;

        // Si ninguna opción está activa manejamos los disabled para no afectar a las opciones que ya se han seleccionado anteriormente 
        if (!cubiertoPorSeguro.checked && !cubiertoPorPaciente.checked) {

            // Si el monto del examen no supera al montoTotal permitimos que se seleccione, caso contrario no
            if (montoExamen <= montoDisponibleTotal) {

                cubiertoPorPaciente.disabled = false;
                cubiertoPorSeguro.disabled = false;

            } else {

                cubiertoPorPaciente.checked = false;
                cubiertoPorSeguro.checked = false;
                cubiertoPorPaciente.disabled = true;
                cubiertoPorSeguro.disabled = true;
            }
        }
    });
}

window.checkExamenHandler = checkExamenHandler;