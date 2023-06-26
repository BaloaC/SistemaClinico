function deleteTitularInput(input) {

    const titulares = document.querySelectorAll(".titular");
    
    const titularContainer = input.parentElement.parentElement;
    titularContainer.remove();

    // Si se elimina el segundo titular ocultarle el icono de eliminar
    if (titulares.length === 2) {
        document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div").classList.add("d-none");
    }

}

window.deleteTitularInput = deleteTitularInput;