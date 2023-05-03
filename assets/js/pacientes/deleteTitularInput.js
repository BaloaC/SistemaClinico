function deleteTitularInput(input){

    const titularContainer = input.parentElement.parentElement;
    titularContainer.remove();
}

window.deleteTitularInput = deleteTitularInput;