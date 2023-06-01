import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addInsumoInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
            <div class="col-12 col-md-5">
                <label for="insumo">Insumo</label>
                <select name="insumo_id" id="s-insumo${clicks}" class="form-control insumo-id" data-active="0">
                    <option></option>
                </select>
                </div>
                <div class="col-12 col-md-5">
                <label for="cantidad" class="p-0">Cantidad utilizada</label>
                <input type="number" name="cantidad" class="form-control insumo-cant">
            </div>
        </div>
    `;
    document.getElementById("addInsumo").insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-insumo${clicks}`,
        selectValue: "insumo_id",
        selectNames: ["nombre"],
        module: "insumos/consulta",
        parentModal: "#modalReg",
        placeholder: "Seleccione el insumo"
    });
}

window.addInsumoInput = addInsumoInput;