import { select2OnClick } from "../global/dinamicSelect2.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
async function addExamenInput() {

    clicks += 1;
    let template = `
        <div class="row align-items-center newInput">
            <hr>
            <div class="col-12 col-md-5">
                <label for="titular">Examen</label>
                <select name="examen_id[]" id="s-examen_id${clicks}" class="form-control examen" data-active="0" required>
                    <option value="" selected>Seleccione el examen</option>
                </select>
            </div>
            <div class="col-12 col-md-5">
                <label for="tipo_relacion">Costo del examen</label>
                <input type="number" step="any" data-validate="true" data-type="price" data-max-length="6" class="form-control costos" required>
                <small class="form-text">No se permiten números negativos</small>
            </div>
            <div class="col-3 col-md-1">
                <button type="button" class="btn" onclick="deleteExamenInput(this)"><i class="fas fa-times m-0"></i></button>
            </div>
        </div>
    `;

    document.getElementById("addExamenes").insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-examen_id${clicks}`,
        selectValue: "examen_id",
        selectNames: ["nombre"],
        module: "examenes/consulta",
        parentModal: "#modalAddPrecioExamen",
        placeholder: "Seleccione el examen"
    });

    validateInputs();
}

select2OnClick({
    selectSelector: "#s-examen_id",
    selectValue: "examen_id",
    selectNames: ["nombre"],
    module: "examenes/consulta",
    parentModal: "#modalAddPrecioExamen",
    placeholder: "Seleccione el examen"
});


window.addExamenInput = addExamenInput;