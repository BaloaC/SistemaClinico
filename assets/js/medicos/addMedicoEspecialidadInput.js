import { select2OnClick } from "../global/dinamicSelect2.js";
import validateInputs from "../global/validateInputs.js";

let clicks = 0;
function addMedicoEspecialidadInput(button,parentModal = "#modalReg") {

    clicks += 1;

    let template = `
    <div class="row align-items-start newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Especialidad</label>
            <select id="s-especialidad${clicks}" data-validate="true" class="form-control ${(parentModal === "#modalReg") ? "medico-especialidad-id" : "medico-especialidad-act-id"}" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto">Costo especialidad</label>
            <input type="number" name="costo-especialidad" step="any" data-validate="true" data-type="price" class="form-control ${(parentModal === "#modalReg") ? "costo-especialidad" : "costo-especialidad-act"}"" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1">
            <button type="button" class="btn mt-4" onclick="deleteMedicoEspecialidadInput(this)"><i class="fas fa-times m-0"></i></button>
        </div>
    </div>

    `;

    document.getElementById(button).insertAdjacentHTML("beforebegin", template);
    select2OnClick({
        selectSelector: `#s-especialidad${clicks}`,
        selectValue: "especialidad_id",
        selectNames: ["nombre"],
        module: "especialidades/consulta",
        parentModal: parentModal,
        placeholder: "Seleccione una especialidad"
    });

    validateInputs();
}
window.addMedicoEspecialidadInput = addMedicoEspecialidadInput;