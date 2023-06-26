function deleteInput(input, inputRefName){

    const inputList = document.querySelectorAll(inputRefName); 

    const inputContainer = input.parentElement.parentElement;
    inputContainer.remove();

    if (inputList.length === 2) {
        document.querySelectorAll(inputRefName)[0].parentElement.parentElement.querySelector("div").classList.add("d-none");
    }
}

window.deleteInput = deleteInput;