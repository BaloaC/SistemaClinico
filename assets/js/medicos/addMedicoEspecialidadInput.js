import validateExistingSelect2 from "../global/validateExistingSelect2.js"
import validateExistingSelect2OnChange from "../global/validateExistingSelect2OnChange.js"
import dinamicSelect2, { emptyAllSelect2, emptySelect2 } from "../global/dinamicSelect2.js";
import getAll from "../global/getAll.js";
import validateInputs from "../global/validateInputs.js";

export let especialidadesList = null;
const select2Options = {
    selectValue: "especialidad_id",
    selectNames: ["nombre"],
    placeholder: "Seleccione una especialidad"
}

let clicks = 0;
let modalOpened = false;
const modalRegister = document.getElementById("modalReg");
const modalUpdate = document.getElementById("modalAct");

const handleModalOpen = async () => {
    if (modalOpened === false) {
        especialidadesList = await getAll("especialidades/consulta");

        dinamicSelect2({
            obj: especialidadesList,
            selectSelector: "#s-especialidad",
            selectValue: "especialidad_id",
            selectNames: ["nombre"],
            parentModal: "#modalReg",
            placeholder: "Seleccione una especialidad",
        });

        $("#s-especialidad").on("change", () => { 
            validateExistingSelect2OnChange({
                parentModal: "#modalReg", 
                selectSelector: "#s-especialidad",
                selectClass: "medico-especialidad-id",
                objList: especialidadesList,
                select2Options,
                optionId: "especialidad_id"
            }); 
        });

        modalOpened = true;
    }
}

// Al abrir el modal cargar los select2
modalRegister.addEventListener('show.bs.modal', async () => await handleModalOpen());
modalUpdate.addEventListener('show.bs.modal', async () => await handleModalOpen());

async function addMedicoEspecialidadInput(button, parentModal = "#modalReg") {

    clicks += 1;

    const inputClassOptions = {
        "#modalReg": {
            selectClass: "medico-especialidad-id",
            costoClass: "costo-especialidad",
            deleteButtonFunction: "deleteMedicoEspecialidadInput(this)",
            addButtonId: "#addMedicoEspecialidad"
        },
        "#modalAct": {
            selectClass: "medico-especialidad-act-id",
            costoClass: "costo-especialidad-act",
            deleteButtonFunction: "deleteMedicoEspecialidadInput(this, '#modalAct')",
            addButtonId: "#addMedicoEspecialidadAct"
        },
    };

    const { selectClass, costoClass, deleteButtonFunction, addButtonId } = inputClassOptions[parentModal];

    let template = `
    <div class="row align-items-start newInput">
        <div class="col-12 col-md-5">
            <label for="medico">Especialidad</label>
            <select id="s-especialidad${clicks}" data-validate="true" class="form-control default-select ${selectClass}" data-active="0" required>
                <option></option>
            </select>
        </div>
        <div class="col-12 col-md-5">
            <label for="monto">Costo especialidad</label>
            <input type="number" name="costo-especialidad" step="any" data-validate="true" data-type="price" class="form-control ${costoClass}"" required>
            <small class="form-text">No se permiten números negativos</small>
        </div>
        <div class="col-3 col-md-1">
            <button type="button" class="btn mt-4" onclick="${deleteButtonFunction}"><i class="fas fa-times m-0"></i></button>
        </div>
    </div>

    `;

    document.getElementById(button).insertAdjacentHTML("beforebegin", template);

    let selectSelector = `#s-especialidad${clicks}`;

    // Vacimos el select primero antes de añadirlo
    emptyAllSelect2({
        selectSelector,
        placeholder: "Seleccione una especialidad",
        parentModal: parentModal,
    })

    const select = document.getElementById(`s-especialidad${clicks}`);
    const optionVacio = document.createElement("option");
    optionVacio.value = "";
    select.insertBefore(optionVacio, select.firstChild)

    // Se inserta la nueva información
    dinamicSelect2({
        obj: especialidadesList,
        selectSelector,
        selectValue: select2Options.selectValue,
        selectNames: select2Options.selectNames,
        parentModal: parentModal,
        placeholder: select2Options.placeholder
    });

    validateExistingSelect2({
        parentModal,
        selectSelector,
        selectClass,
        addButtonId,
        objList: especialidadesList,
        optionId: "especialidad_id",
        select2Options
    });

    validateExistingSelect2OnChange({
        parentModal,
        selectSelector,
        selectClass,
        objList: especialidadesList,
        optionId: "especialidad_id",
        select2Options,
    });

    $(selectSelector).on("change", () => { validateExistingSelect2OnChange({ parentModal, selectSelector, selectClass, objList: especialidadesList, select2Options, optionId: "especialidad_id", }); });

    validateInputs();
}

window.addMedicoEspecialidadInput = addMedicoEspecialidadInput;