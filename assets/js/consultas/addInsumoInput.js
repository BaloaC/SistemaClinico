import { select2OnClick } from "../global/dinamicSelect2.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
function addInsumoInput(parentModal = "#modalReg") {


    const inputInsumos = document.querySelectorAll(".insumo-id");

    // Validamos que exista un solo insumo para poder añadirle que se pueda eliminar
    if (inputInsumos.length === 1) {
        document.querySelectorAll(".insumo-id")[0].parentElement.parentElement.querySelector("div:nth-child(2)").classList.remove("d-none");
    }

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-12 col-md-5">
                <label for="insumo">Insumo</label>
                <select name="insumo_id" id="s-insumo${clicks}" class="form-control insumo-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="cantidad" class="p-0">Cantidad utilizada</label>
                <input type="number" step="any" name="cantidad" data-validate="true" data-type="number" class="form-control insumo-cant">
                <small class="form-text col-12">Solo se permiten números</small>
            </div>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this,'.insumo-id')"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;
    document.getElementById("addInsumo").insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-insumo${clicks}`,
        selectValue: "insumo_id",
        selectNames: ["nombre"],
        module: "insumos/consulta",
        parentModal: parentModal,
        placeholder: "Seleccione el insumo"
    });

    validateInputs();
}

window.addInsumoInput = addInsumoInput;