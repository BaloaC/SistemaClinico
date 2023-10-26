import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addIndicacionInput() {

    const inputIndicaciones = document.querySelectorAll(".indicaciones");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputIndicaciones.length === 1) {
        document.querySelectorAll(".indicaciones")[0].parentElement.parentElement.querySelector("div:nth-child(2)").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-12 col-md-5">
                <label for="indicacion" class="p-0">Indicación</label>
                <input type="text" name="indicacion" class="form-control indicaciones">
            </div>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this,'.indicaciones')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addIndicacion").insertAdjacentHTML("beforebegin", template);
}

window.addIndicacionInput = addIndicacionInput;