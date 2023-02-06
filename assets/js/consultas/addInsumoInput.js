import { select2OnClick } from "../global/dinamicSelect2.js";

let clicks = 0;
function addInsumoInput() {

    clicks += 1;
    let template = `
        <hr>
        <div class="col-12 col-md-6">
            <label for="insumo">Insumo</label>
            <select name="insumo_id" id="s-insumo${clicks}" class="form-control insumo-id" data-active="0">
                <option></option>
            </select>
            <label for="cantidad">Cantidad utilizada</label>
            <input type="number" name="cantidad" class="form-control insumo-cant">
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