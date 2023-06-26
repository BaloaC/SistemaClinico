import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addRecipeInput(parentModal = "#modalReg") {

    const inputRecipes = document.querySelectorAll(".medicamento-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputRecipes.length === 1) {
        document.querySelectorAll(".medicamento-id")[0].parentElement.parentElement.querySelector("div").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this,'.medicamento-id')"><i class="fas fa-times m-0"></i></button>
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
        parentModal: parentModal,
        placeholder: "Seleccione el medicamento"
    });
}

window.addRecipeInput = addRecipeInput;