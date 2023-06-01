function deleteInput(input){

    const inputContainer = input.parentElement.parentElement;
    inputContainer.remove();
}

window.deleteInput = deleteInput;