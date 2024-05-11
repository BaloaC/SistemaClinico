const select2Options = {
    selectValue: "examen_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione un exámen",
}

function deleteExamenSeguroInput(input) {
 
    const deleteExamenSeguroInput = input.parentElement.parentElement;
    deleteExamenSeguroInput.remove();
}

window.deleteExamenSeguroInput = deleteExamenSeguroInput;