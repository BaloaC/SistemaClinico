function deleteMedicoEspecialidadInput(input) {

    const especialidad = document.querySelectorAll(".medico-especialidad-id");
    
    const especialidadContainer = input.parentElement.parentElement;
    especialidadContainer.remove();

    // Si se elimina el segundo titular ocultarle el icono de eliminar
    if (especialidad.length === 2) {
        document.querySelectorAll(".medico-especialidad-id")[0].parentElement.parentElement.querySelector("div")[2].classList.add("d-none");
    }

}

window.deleteMedicoEspecialidadInput = deleteMedicoEspecialidadInput;