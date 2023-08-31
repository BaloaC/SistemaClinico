function deleteExamenSeguroInput(input) {

    // const examenSeguro = document.querySelectorAll(".examen");
    
    const deleteExamenSeguroInput = input.parentElement.parentElement;
    deleteExamenSeguroInput.remove();

    // // Si se elimina el segundo titular ocultarle el icono de eliminar
    // if (titulares.length === 2) {
    //     document.querySelectorAll(".titular")[0].parentElement.parentElement.querySelector("div").classList.add("d-none");
    // }

}

window.deleteExamenSeguroInput = deleteExamenSeguroInput;