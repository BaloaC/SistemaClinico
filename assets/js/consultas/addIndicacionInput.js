import validateInputs from "../global/validateInputs.js";

let clicks = 0;
function addIndicacionInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-end newInput">
            <div class="col-12 col-md-5">
                <label for="indicacion">Indicación</label>
                <input type="text" name="indicacion" data-validate="true" data-type="address" class="form-control indicaciones">
                <small class="form-text">Solo se permiten los siguientes simbolos "@#+_,-"</small>
            </div>
            <div class="col-3 col-md-1 pt-4-5 align-self-start">
                <button type="button" class="btn" onclick="deleteInput(this,'.indicaciones')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addIndicacion").insertAdjacentHTML("beforebegin", template);
    
    validateInputs();
}

window.addIndicacionInput = addIndicacionInput;