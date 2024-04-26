function deleteInput(input, inputRefName, parentModal = "#modalReg"){


    const inputList = document.querySelectorAll(inputRefName); 
    

    const inputContainer = input.parentElement.parentElement;
    inputContainer.remove();

    if (inputList.length === 2) {
        document.querySelectorAll(inputRefName)[0].parentElement.parentElement.querySelector("div:nth-child(2)")[0].classList.add("d-none");
    }
}

window.deleteInput = deleteInput;