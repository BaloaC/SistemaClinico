function deleteExamenInput(input) {
    const examenContainer = input.parentElement.parentElement;
    examenContainer.remove();
}

window.deleteExamenInput = deleteExamenInput;