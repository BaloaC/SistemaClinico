function deleteInsumoInput(input){

    const insumoContainer = input.parentElement.parentElement;
    insumoContainer.remove();
}

window.deleteInsumoInput = deleteInsumoInput;