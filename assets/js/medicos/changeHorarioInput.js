function changeHorarioInput(input) {

    let inputChecked = input.checked;
    const inputsTime = input.parentElement.parentElement.parentElement.querySelectorAll("input[type='time']");

    inputsTime.forEach(el => {
        if (inputChecked) {
            el.disabled = false;
        } else {
            el.disabled = true;
        }
    });
}

window.changeHorarioInput = changeHorarioInput;