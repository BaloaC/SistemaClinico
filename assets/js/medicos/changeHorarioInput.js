function changeHorarioInput(input){

    let inputChecked = input.checked;
    const inputsTime = input.parentElement.parentElement.parentElement.querySelectorAll("input[type='time']");

    if(inputChecked){
        inputsTime.forEach(el => {
            el.disabled = false;
        });
    } else{
        inputsTime.forEach(el => {
            el.disabled = true;
        });
    }
}

window.changeHorarioInput = changeHorarioInput;