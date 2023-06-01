import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addRecipeInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
            <div class="col-12 col-md-5">
                <label for="medicamento">Medicamento</label>
                <select name="medicamento_id" id="s-medicamento${clicks}" class="form-control medicamento-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="uso" class="p-0">Uso</label>
                <input type="text" name="uso" class="form-control uso-medicamento">
            </div>
        </div>
    `;
    document.getElementById("addRecipe").insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-medicamento${clicks}`,
        selectValue: "medicamento_id",
        selectNames: ["nombre_medicamento"],
        module: "medicamento/consulta",
        parentModal: "#modalReg",
        placeholder: "Seleccione el medicamento"
    });
}

window.addRecipeInput = addRecipeInput;