function pacientePoseeCedula(input, inputCedula) {

    const cedulaInput = document.getElementById(inputCedula);
    
    if (input.value == 1) {
        cedulaInput.disabled = false;
    } else {
        cedulaInput.disabled = true;
    }
}

window.pacientePoseeCedula = pacientePoseeCedula;
