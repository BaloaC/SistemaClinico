function checkExamenHandler(checkbox) {

    const examenOptions = checkbox.parentElement.parentElement.querySelectorAll("td");
    const examenPrice = parseFloat(examenOptions[2].lastChild.nodeValue.slice(1));
    const montoDisponibleContianer = document.getElementById("montoDisponible");
    const montoDisponible = parseFloat(montoDisponibleContianer.innerText.split("$")[1]) ?? 0;
    const mensajeDeAlerta = document.querySelector(`.examen_id_mensaje_${checkbox.dataset.id}`);

    const cubiertoPorSeguroCheck = examenOptions[0].childNodes[0];
    const cubiertoPorPacienteCheck = examenOptions[1].childNodes[0];

    // Si no hay ninguna opción activa, regresamos el dinero al montoDisponible
    if (!cubiertoPorPacienteCheck.checked && !cubiertoPorSeguroCheck.checked) {

        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible + examenPrice}`;
        checkbox.classList.remove("cubiertoPor3");
        $(mensajeDeAlerta).fadeOut("slow");
    }

    // Si se marca alguna de las opciones se resta el monto total
    if (checkbox.checked && (!cubiertoPorPacienteCheck.checked || !cubiertoPorSeguroCheck.checked)) {
        
        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible - examenPrice}`;

        // Si al seleccionar el examen este queda en saldo negativo implica que será cubierto por el seguro y paciente
        if(montoDisponible - examenPrice < 0){
            
            checkbox.classList.add("cubiertoPor3");
            mensajeDeAlerta.childNodes[0].innerText = `El examen será registrado como cubierto por ambos, $${montoDisponible} que corresponden al seguro y $${Math.abs(montoDisponible - examenPrice)} del paciente`;
            $(mensajeDeAlerta).fadeIn("slow");
        }
    }


    // Para deshabilitar los examenes que superan el monto total
    const examenesPrecio = document.querySelectorAll(".examenPrice");

    examenesPrecio.forEach(examen => {

        let montoExamen = parseFloat(examen.textContent.slice(1));
        let montoDisponibleTotal = parseFloat(montoDisponibleContianer.innerText.split("$")[1]);
        let examenElements = examen.parentElement.querySelectorAll("td");
        let cubiertoPorSeguro = examenElements[1].firstChild;

        // Si ninguna opción está activa manejamos los disabled para no afectar a las opciones que ya se han seleccionado anteriormente 
        if (!cubiertoPorSeguro.checked) {

            // Si el monto del examen no supera al montoTotal permitimos que se seleccione, caso contrario no
            if (montoExamen <= montoDisponibleTotal) {

                cubiertoPorSeguro.disabled = false;

            } else {

                // Si no queda saldo desactivar, pero en caso de que quede, permitir seleccionarlo para que pueda cubrirlo el seguro y paciente
                if(montoDisponibleTotal <= 0){
                    cubiertoPorSeguro.checked = false;
                    cubiertoPorSeguro.disabled = true;
                } else {
                    cubiertoPorSeguro.disabled = false;
                }
            }
        }
    });
}

window.checkExamenHandler = checkExamenHandler;