function checkExamenHandler(checkbox) {

    const examenOptions = checkbox.parentElement.parentElement.querySelectorAll("td");
    const examenPrice = parseFloat(examenOptions[2].lastChild.nodeValue.slice(1));
    const montoDisponibleContianer = document.getElementById("montoDisponible");
    const montoDisponible = parseFloat(montoDisponibleContianer.innerText.split("$")[1]) ?? 0;

    const cubiertoPorSeguroCheck = examenOptions[0].childNodes[0];
    const cubiertoPorPacienteCheck = examenOptions[1].childNodes[0];


    if(!cubiertoPorPacienteCheck.checked && !cubiertoPorSeguroCheck.checked){
        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible + examenPrice}`;
        return;
    }

    if(checkbox.checked && (!cubiertoPorPacienteCheck.checked || !cubiertoPorSeguroCheck.checked)){
        montoDisponibleContianer.innerText = `Saldo a favor: $${montoDisponible - examenPrice}`;
    } 
}

window.checkExamenHandler = checkExamenHandler;